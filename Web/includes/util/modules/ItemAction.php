<?php

	class ItemAction extends DB_Accessor {
	
		public static $TableName = "gmd_itemactions";
		public static $SerialKey = "|;|";
		
		public function GiveToUser( $UserObj ) {
			Database::Insert( "gmd_useractions", array(
				"DateEffective" => time(),
				"ItemAction" => ( $this->GetValue( "ID" ) ),
				"UserData" => ( $UserObj->GetValue( "SteamID" ) ),
				"Status" => 1
			) );
			
			$ActionArr = Action::GetAction( $this->GetValue( "ActionType" ) );
			
			if( !empty( $ActionArr ) ) {
				$execReturn = $ActionArr[ "ExecFunc" ]( $UserObj, $this->GetData() );
				
				if( $execReturn === false ) {
					$LastInsertID = Database::LastInsertID();
					Database::Query( "UPDATE `gmd_useractions` SET `Status` = 0 WHERE `ID` = {$LastInsertID};" );
				}
			}
		}
		
		public function SetData( $DataArray ) {
			$this->ChangeValue( "", implode( ItemAction::$SerialKey, $DataArray ) );
		}
		
		public function GetData() {
			return explode( ItemAction::$SerialKey, $this->GetValue( "ActionData" ) );
		}
		
		public function Delete() {
			Database::Query( "DELETE FROM `gmd_itemactions` WHERE `ID` = %s;", $this->GetValue( "ID" ) );
			DB_Accessor::FlushMemCache( "ItemAction" );
		}
		
		public static function AddItemAction( $ItemID, $ActionType, $ActionData, $Servers ) {
			// Make it in the database
			Database::Insert( self::$TableName, array(
				"ItemID" => $ItemID,
				"ActionType" => $ActionType,
				"ActionData" => $ActionData,
				"Servers" => $Servers,
			) );
			
			// Flush the cache
			DB_Accessor::FlushMemCache( "ItemAction" );
		}
	}
	
?>