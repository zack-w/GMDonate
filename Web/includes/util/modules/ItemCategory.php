<?php

	class ItemCategory extends DB_Accessor {
	
		public static $TableName = "gmd_itemcategories";
		
		public function Delete() {
			Database::Query( "DELETE FROM `gmd_itemcategories` WHERE `ID` = %s;", $this->GetValue( "ID" ) );
			DB_Accessor::FlushMemCache( "ItemCategory" );
		}
		
		public static function MakeCategory( $CatName ) {
			if( empty( $CatName ) ) return;
			
			// Make it in the database
			Database::Insert( self::$TableName, array(
				"Name" => $CatName,
			) );
			
			// Flush the cache
			DB_Accessor::FlushMemCache( "ItemCategory" );
		}
	}

	ItemCategory::PrecacheAll( "ItemCategory" );
	
?>