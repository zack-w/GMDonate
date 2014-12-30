<?php

	class ItemStatus {
		const ACTIVE = 1;
		const DISABLED = 2;
	}
	
	class Item extends DB_Accessor {
	
		public static $TableName = "gmd_items";
		
		public function OnUserBuy( $UserObj ) {
			$this->ChangeValue( "NumPurchases", $this->GetValue( "NumPurchases" ) + 1 );
			
			// Give them all actions associated with this item
			foreach( ItemAction::GetAllByField( "ItemAction", "ItemID", $this->GetValue( "ID" ) ) as $ItemActionObj ) {
				$ItemActionObj->GiveToUser( $UserObj );
			}
			
			Database::Insert( "gmd_purchases", array(
				"ItemID" => $this->GetValue( "ID" ),
				"UserID" => $UserObj->GetValue( "ID" ),
				"Date" => time(),
				"PurchasingIP" => $_SERVER[ "REMOTE_ADDR" ],
				"PaymentAmount" => $this->GetValue( "Cost" )
			) );
		}
		
		public function SetImageFromInput( $FileInputName ) {
			$this->DeleteImage();
			
			if( isset( $_FILES[ $FileInputName ] ) ) {
				$File = $_FILES[ $FileInputName ];
				$FileExtension = end( explode( ".", $File[ "name" ] ) );
				$FileType = $File[ "type" ];
				$FileSize = $File[ "size" ];
				
				if( 75000 < $FileSize ) {
					// Too Big
				} elseif( $FileType != "image/png" && $FileType != "image/jpg" && $FileType != "image/jpeg" ) {
					// Bad Type
				} elseif( $FileExtension != "png" && $FileExtension != "jpg" && $FileExtension != "jpeg" ) {
					// Bad Extension
				} else {
					$ImageURLName = ( md5( rand() ) . "." . $FileExtension );
					move_uploaded_file( $File[ "tmp_name" ], "includes/images/uploaded/" . $ImageURLName );
				}
				
				$this->ChangeValue( "Image", $ImageURLName );
			}
		}
		
		public function DeleteImage() {
			if( !empty( $this->Data[ "Image" ] ) && $this->Data[ "Image" ] != "item_default.png" ) {
				@unlink( "includes/images/uploaded/" . $this->Data[ "Image" ] );
			}
		}
		
		public function Delete() {
			$ItemActions = ItemAction::GetAllByField( "ItemAction", "ItemID", $this->GetValue( "ID" ) );
			
			// Delete all actions related to this item
			foreach( $ItemActions as $ItemAction ) {
				// Delete all of the user actions using this Item Action
				$UserActions = UserAction::GetAllByField( "UserAction", "ItemAction", $ItemAction->GetValue( "ID" ) );
				
				foreach( $UserActions as $UserAction ) {
					$UserAction->Delete();
				}
				
				// Delete the actual item action
				$ItemAction->Delete();
			}
			
			// Delete the saved image (we warned them)
			$this->DeleteImage();
			
			// Literally delete the item itself
			Database::Query( "DELETE FROM `%s` WHERE `ID` = %s;", static::$TableName, $this->Data[ "ID" ] );
			DB_Accessor::FlushMemCache( get_class( $this ) );
		}
		
	}

	ItemCategory::PrecacheAll( "Item" );
	
?>