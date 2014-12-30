<?php
	
	// This base is pulled from Schnell (also created by Hans)
	
	abstract class DB_Accessor {
		public $Data = array();
		
		public static $TableName = "unknown";
		public static $DataCache = array();
		
		public function OnConstructed() {
			// To be overwritten
		}
		
		public function __construct( $Data = null ) {
			if( $Data == null )
				return;
		
			if( empty( DB_Accessor::$DataCache[ get_class( $this ) ] ) )
				DB_Accessor::$DataCache[ get_class( $this ) ] = array();
			
			DB_Accessor::$DataCache[ get_class( $this ) ][ intval( $Data[ "ID" ] ) ] = $this;
			$this->Data = $Data;
			
			$this->OnConstructed( $Data[ "ID" ] );
		}
		
		public function IsReal() {
			return ( isset( $this->Data[ "ID" ] ) && $this->Data[ "ID" ] > 0 );
		}
		
		public function GetValue( $Key ) {
			if( !isset( $this->Data[ $Key ] ) ) {
				trigger_error( "Unknown key type [" . $Key . "] in class [" . get_class( $this ) . "] (func::GetValue)" );
				return false;
			}
			
			return $this->Data[ $Key ];
		}
		
		public function ChangeValue( $Key, $Value ) {
			if( !isset( $this->Data[ $Key ] ) ) {
				trigger_error( "Unknown key type [" . $Key . "] in class [" . get_class( $this ) . "]" );
				return false;
			}
			
			$this->Data[ $Key ] = $Value;
			
			if( !is_numeric( $Value ) )
				$Value = "'" . Database::Escape( $Value ) . "'";
			
			$Query = Database::Query( "UPDATE `%s` SET `%s` = %s WHERE `ID` = %s;", static::$TableName, $Key, $Value, $this->Data[ "ID" ] );
			DB_Accessor::FlushMemCache( get_class( $this ) );
			return true;
		}
		
		public function Delete() {
			Database::Query( "DELETE FROM `%s` WHERE `ID` = %s;", static::$TableName, $this->Data[ "ID" ] );
			DB_Accessor::FlushMemCache( get_class( $this ) );
		}
		
		// This loads a cache from memory to the PHP session cache
		// I know, I should prob. only have 1 copy in memory, so dont tell me pls
		public static function LoadMemCache( $ClassName ) {
			global $GMDConfig;
			
			if( $GMDConfig[ "UseAPC" ] ) {
				if( !apc_exists( "SchnellCacheExpire_" . $ClassName ) || !apc_exists( "SchnellCache_" . $ClassName ) ) {
					return false;
				}
				
				$Timestamp = intval( apc_fetch( "SchnellCacheExpire_" . $ClassName ) );
				
				if( !$Timestamp || time() > $Timestamp ) {
					return false;
				}
				
				DB_Accessor::$DataCache[ $ClassName ] = apc_fetch( "SchnellCache_" . $ClassName );
				return true;
			} else {
				return false;
			}
		}
		
		// This flushes the mem cache
		public static function FlushMemCache( $ClassName, $Recache = true ) {
			global $GMDConfig;
			DB_Accessor::$DataCache[ $ClassName ] = null;
			
			if( $GMDConfig[ "UseAPC" ] ) {
				apc_store( "SchnellCacheExpire_" . $ClassName, 0 );
			}
			
			if( $Recache ) self::PrecacheAll( $ClassName );
		}
		
		public static function PrecacheAll( $ClassName ) {
			global $GMDConfig;
			$ClassValues = get_class_vars( $ClassName );
			
			// Check Table Name
			if( !isset( $ClassValues[ "TableName" ] ) ) {
				trigger_error( "Unknown table name for class [" . $ClassName . "]" );
				return false;
			}
			
			if( DB_Accessor::LoadMemCache( $ClassName ) === true ) {
				return; // We loaded from cache successfully
			}
			
			$Query = Database::Query( "SELECT * FROM `%s`;", $ClassValues[ "TableName" ] );
			DB_Accessor::$DataCache[ $ClassName ] = array();
			
			while( $Row = $Query->fetch_assoc() ) {
				DB_Accessor::$DataCache[ $ClassName ][ $Row[ "ID" ] ] = ( new $ClassName( $Row ) );
			}
			
			if( $GMDConfig[ "UseAPC" ] ) {
				apc_store( "SchnellCache_" . $ClassName, DB_Accessor::$DataCache[ $ClassName ] );
				apc_store( "SchnellCacheExpire_" . $ClassName, time() + 0 ); // 5 minutes by default [TESTING - SET TO 0]
			}
		}
		
		public static function GetCacheCount( $ClassName ) {
			$Results = DB_Accessor::GetCachedResults( $ClassName );
			return ( $Results == false )?( 0 ):( count( $Results ) );
		}
		
		public static function GetCachedResults( $ClassName ) {
			if( isset( DB_Accessor::$DataCache[ $ClassName ] ) ) {
				return DB_Accessor::$DataCache[ $ClassName ];
			}
			
			return array();
		}
		
		public static function SearchCachedResults( $ClassName, $SearchKey = "", $SearchValue = "" ) {
			$CachedResults = DB_Accessor::GetCachedResults( $ClassName );
			$ReturnObjects = array();
			
			foreach( $CachedResults as $Obj ) {
				if( $Obj->Data[ $SearchKey ] == $SearchValue )
					array_push( $ReturnObjects, $Obj );
			}
			
			return $ReturnObjects;
		}
		
		public static function GetAllByField( $ClassName = "", $FieldName = "", $Value = "" ) {
			$ClassValues = get_class_vars( $ClassName );
			
			// Check Table Name
			if( !isset( $ClassValues[ "TableName" ] ) ) {
				trigger_error( "Unknown table name for class [" . $ClassName . "]" );
				return false;
			}
			
			if( !is_numeric( $Value ) )
				$Value = "'" . Database::Escape( $Value ) . "'";
			
			$Query = Database::Query( "SELECT * FROM `%s` WHERE `%s` = %s;", $ClassValues[ "TableName" ], $FieldName, $Value );
			
			$Results = array();
			
			while( $Row = $Query->fetch_assoc() ) {
				array_push( $Results, ( new $ClassName( $Row ) ) );
			}
			
			return $Results;
		}
		
		public static function GetByField( $ClassName, $FieldName, $Value ) {
			$ClassValues = get_class_vars( $ClassName );
		
			if( isset( DB_Accessor::$DataCache[ $ClassName ] ) ) {
				foreach( DB_Accessor::$DataCache[ $ClassName ] as $Obj ) {
					if( $Obj->Data[ $FieldName ] == $Value ) {
						return $Obj;
					}
				}
			}
			
			$Array = DB_Accessor::GetAllByField( $ClassName, $FieldName, $Value );
			
			if( 1 > count( $Array ) ) {
				return new $ClassName();
			}
			
			return array_pop( $Array );
		}
	}
	
?>