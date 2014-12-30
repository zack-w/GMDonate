<?php

	if( isset( $_POST[ "addItemCat" ] ) ) {
		ItemCategory::MakeCategory( $_POST[ "itemCatName" ] );
	} elseif( isset( $_GET[ "delete" ] ) ) {
		$CatObj = ItemCategory::GetByField( "ItemCategory", "ID", intval( $_GET[ "delete" ] ) );
		$ItemsInCat = Item::GetAllByField( "Item", "Category", $CatObj->GetValue( "ID" ) );
		
		if( count( $ItemsInCat ) > 0 ) {
			echo '
				<div class="alert alert-danger" role="alert">
					<b>Error</b> The category "' . $CatObj->GetValue( "Name" ) . '" because it still contains items.
				</div>
			';
		} else {
			$CatObj->Delete();
			
			echo '
				<div class="alert alert-success" role="alert">
					<b>Success</b> The category "' . $CatObj->GetValue( "Name" ) . '" has been deleted.
				</div>
			';
		}
	}
	
?>