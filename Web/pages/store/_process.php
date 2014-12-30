<?php
	
	if( isset( $_GET[ "dobuy" ] ) && intval( $_GET[ "dobuy" ] ) && User::$ActiveUser->IsReal() ) {
		$ItemObj = Item::GetByField( "Item", "ID", intval( $_GET[ "dobuy" ] )  );
	
		if( isset( $ItemObj ) && $ItemObj->IsReal() ) {
			if( User::$ActiveUser->GetValue( "Credit" ) >= $ItemObj->GetValue( "Cost" ) ) {
				User::$ActiveUser->BuyItem( $ItemObj );
			}
		}
		
		KERNEL::HardNavigate( "store", "&cat=" . $ItemObj->GetValue( "Category" ) );
	}
	
?>