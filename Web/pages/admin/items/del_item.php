<?php
	$ItemObj = Item::GetByField( "Item", "ID", intval( $_GET[ "delete" ] ) );
	
	if( isset( $_GET[ "deleteConf" ] ) ) {
		$ItemObj->Delete();
		KERNEL::HardNavigate( "admin", "&area=items" );
		die( "<h4>Redirecting...</h4>" );
	}
?>

<h3>Delete Item</h3>
<br />

<div style="margin-left: 25px;font-size: 13px;">
	<b style="color: darkred;">Warning: Deleting an item is not reccomended and may cause unforseen consequences.</b>
	<br /><br />
	Deleting an item will leave permanant, undoable effects. <b>It is highly reccomended that you simply
	disable an item</b> that you no longer wish for people to be able to see or purchase. The deletion of 
	items is only reccomended in scenarios when the item was simply a test and has not been used.
	
	<br /><br />
	
	<b>Effects of deletion</b>
	<ol>
		<li>Item name/details will not be available, anywhere, for any reason (including purchase history)</li>
		<li>All actions that have been associated with this action will be deleted</li>
		<li>People that have not yet recieved their benefits for this item will not get them</li>
		<li>People will no longer get recurring things associated with this item</li>
		<li>Other things that may somehow relate to this item will be lost</li>
		<li>Errors will occur when an attempt is made to access this item</li>
	</ol>
	
	<b>Item Name:</b> <?= $ItemObj->GetValue( "Name" ); ?>
</div>

<br />

<a href="?page=admin&area=items&delete=<?= $ItemObj->GetValue( "ID" ); ?>&deleteConf=1" class="btn btn-danger btn-sm">
	I Understand The Above - Delete the Item
</a>
