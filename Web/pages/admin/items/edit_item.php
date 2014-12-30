<?php
	
	$ItemObj = Item::GetByField( "Item", "ID", intval( $_GET[ "item" ] ) );
	$CatObj = ItemCategory::GetByField( "ItemCategory", "ID", $ItemObj->GetValue( "Category" ) );
	
	if( isset( $_POST[ "editItem" ] ) ) {
		$ImageURLName = "item_default.png";
		
		if( isset( $_FILES[ "itemImage" ] ) ) $ItemObj->SetImageFromInput( "itemImage" );
		$ItemObj->ChangeValue( "Name", $_POST[ "itemName" ] );
		$ItemObj->ChangeValue( "Cost", floatval( $_POST[ "itemCost" ] ) );
		$ItemObj->ChangeValue( "ShowImage", ( !empty( $_POST[ "showImage" ] ) )?( 1 ):( 0 ) );
		$ItemObj->ChangeValue( "Description", $_POST[ "itemDesc" ] );
		$ItemObj->ChangeValue( "Status", intval( $_POST[ "itemStatus" ] ) );
		
		echo '<div class="alert alert-success" role="alert">Product has been updated successfully.</div>';
	}
	
?>

<h4>Edit Item</h4>

<form enctype="multipart/form-data"  method="POST" action="?page=admin&area=items&edit=1&item=<?= $ItemObj->GetValue( "ID" ); ?>">
	<input type="hidden" name="editItem" value="1" />
	<input type="hidden" id="itemDesc" name="itemDesc" value="<?= $ItemObj->GetValue( "Description" ); ?>" />
	
	<div class="row">
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Category</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<input type="text" class="form-control" value="<?= $CatObj->GetValue( "Name" ); ?>" style="width: 200px;" readonly>
			</div>
		</div>
		
		<br />
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Name</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<input name="itemName" type="text" class="form-control" value="<?= $ItemObj->GetValue( "Name" ); ?>" placeholder="Bronze VIP" style="width: 200px;" required>
			</div>
		</div>
		
		<br />
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Item Status</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<select name="itemStatus" style="height: 34px;">
					<option value="1">Active</option>
					<option value="2">Disabled</option>
				</select>
			</div>
		</div>
		
		<br />
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Cost</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<input name="itemCost" type="number" class="form-control" value="<?= $ItemObj->GetValue( "Cost" ); ?>" style="width: 100px;" placeholder="7.50" required>
			</div>
		</div>
		
		<br />
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Image</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<div class="input-group">
					<span class="input-group-addon">
						<input type="checkbox" name="showImage" <?= ($ItemObj->GetValue("ShowImage") == 1)?("checked"):(""); ?> >
					</span>
					<input type="file" name="itemImage" class="form-control" style="width: 250px;" >
				</div>
			</div>
		</div>
		
		<br />
			
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;">
				<b>Actions</b>
			</div>
			
			<div class="col-sm-6 col-md-8">
				<div class="dropdown" style="display: inline-block;margin-left: 10px;">
					<a id="drop4" role="button" data-toggle="dropdown" href="#" class="btn btn-xs btn-success">Add Action <span class="caret"></span></a>
					<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4" style="font-size: 12px;">
						<?php
							foreach( Action::$ActionList as $ActionObj ) {
								echo '
									<li role="presentation">
										<a role="menuitem" href="?page=admin&area=items&addaction=' . $ActionObj[ "SysName" ] . '&item=' . $ItemObj->GetValue( "ID" ) . '">' . $ActionObj[ "Name" ] . '</a>
									</li>
								';
							}
						?>
					</ul>
				</div>
				
				<div class="panel panel-default" style="width: 200px;float: left;padding: 3px;">
					<?php
						$ItemActions = ItemAction::GetAllByField( "ItemAction", "ItemID", $ItemObj->GetValue( "ID" ) );
						
						if( count( $ItemActions ) == 0 ) {
							echo '<div style="text-align: center;padding: 4px;font-style: italic;font-size: 12px;">No Actions to Display!</div>';
						} else {
							foreach( $ItemActions as $ItemAction ) {
								$ActionObj = Action::GetAction( $ItemAction->GetValue( "ActionType" ) );
								echo '<a href="?page=admin&area=items&editaction=' . $ItemAction->GetValue( "ID" ) . '"><div class="actionItem">' . $ActionObj[ "Name" ] . '</div></a>';
							}
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;">
				<b>Description</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<div style='background-color: #FFF;'>
					<div class="btn-toolbar" data-role="editor-toolbar" data-target="#itemWYSIWYG">
						<div class="btn-group">
							<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
								<ul class="dropdown-menu">
								</ul>
							</div>
						<div class="btn-group">
							<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
								<ul class="dropdown-menu">
								<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
								<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
								<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
								</ul>
						</div>
						<div class="btn-group">
							<a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
							<a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
							<a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
						</div>
						<div class="btn-group">
							<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
							<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
						</div>
						<div class="btn-group">
							<a class="btn btn-default" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
							<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 37px; height: 30px;">
						</div>
					</div>
					
					<div id="itemWYSIWYG" class="itemWYSIWYG" onkeyup="itemDescUpdated();" onkeypress="itemDescUpdated();"><?= $ItemObj->GetValue("Description"); ?></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 30px;" value="Save" />
			</div>
		</div>
	</div>
</form>

<script>
	$('#itemWYSIWYG').wysiwyg();
	
	function itemDescUpdated() {
		document.getElementById( "itemDesc" ).value = $('.itemWYSIWYG').cleanHtml();
	}
</script>


