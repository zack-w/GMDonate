<div style='padding: 14px;'>
<?php
	
	if( isset( $_GET[ "newitem" ] ) ) {
		require_once( dirname( __FiLE__ ) . "/add_item.php" );
	} elseif( isset( $_GET[ "edit" ] ) ) {
		require_once( dirname( __FiLE__ ) . "/edit_item.php" );
	} elseif( isset( $_GET[ "addaction" ] ) ) {
		require_once( dirname( __FiLE__ ) . "/add_action.php" );
	} elseif( isset( $_GET[ "editaction" ] ) ) {
		require_once( dirname( __FiLE__ ) . "/edit_action.php" );
	} elseif( isset( $_GET[ "delete" ] ) ) {
		require_once( dirname( __FILE__ ) . "/del_item.php" );
	} else {	
		require_once( "list_items.php" );
	}
	
?>
</div>