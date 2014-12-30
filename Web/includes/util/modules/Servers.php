<?php

	class Servers extends DB_Accessor {
	
		public static $TableName = "gmd_servers";
		
		public function Delete() {
			Database::Query( "DELETE FROM `gmd_servers` WHERE `ID` = %s;", $this->GetValue( "ID" ) );
			DB_Accessor::FlushMemCache( "Servers" );
		}
		
		public static function AddServer( $DisplayName, $IP, $Port ) {
			// Make it in the database
			Database::Insert( self::$TableName, array(
				"Name" => $DisplayName,
				"IP" => $IP,
				"Port" => $Port,
			) );
			
			// Flush the cache
			DB_Accessor::FlushMemCache( "Servers" );
		}
		
	}
	
	Servers::PrecacheAll( "Servers" );
	
?>