<?php
	
	if( Servers::GetCacheCount( "Servers" ) == 0 ) {
		KERNEL::OnError( "You must first add a server before adding an item.", false );
	} else {
	
	if( isset( $_FILES[ "itemImage" ] ) ) {
		$ImageURLName = "item_default.png";
		
		// TODO -- Make this utilize the built in functionality of the Item class
		if( isset( $_FILES[ "itemImage" ] ) ) {
			$File = $_FILES[ "itemImage" ];
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
				$ImageURLName = md5( rand() );
				move_uploaded_file( $File[ "tmp_name" ], "includes/images/uploaded/" . $ImageURLName . "." . $FileExtension );
			}
		}
		
		Database::Insert( "gmd_items", array(
			"Category" => intval( $_POST[ "catID" ] ),
			"Name" => $_POST[ "itemName" ],
			"Description" => $_POST[ "itemDesc" ],
			"Cost" => floatval( $_POST[ "itemCost" ] ),
			"Image" => $ImageURLName,
			"ShowImage" => ( !empty( $_POST[ "showImage" ] ) )?( 1 ):( 0 ),
			"Status" => ItemStatus::ACTIVE
		) );
		
		echo "<h4>You are being redirected..</h4>";
		KERNEL::HardNavigate( "admin", "&area=items" );
	} else {
	
	$CatObj = ItemCategory::GetByField( "ItemCategory", "ID", $_GET[ "catid" ] );
	
?>

<h4>Add Item</h4>

<form enctype="multipart/form-data" method="POST" action="?page=admin&area=items&newitem=1">
	<input type="hidden" name="addItem" value="1" />
	<input type="hidden" name="catID" value="<?= $CatObj->GetValue( "ID" ); ?>" />
	<input type="hidden" id="itemDesc" name="itemDesc" value="No Description Available" />
	
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
				<input name="itemName" type="text" class="form-control" value="" placeholder="Bronze VIP" style="width: 200px;" required>
			</div>
		</div>
		
		<br />
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<b>Cost</b>
			</div>
			
			<div class="col-sm-6 col-md-8" style="text-align: left;">
				<input name="itemCost" type="text" class="form-control" style="width: 100px;" placeholder="7.50" required>
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
						<input type="checkbox" name="showImage" >
					</span>
					<input type="file" name="itemImage" class="form-control" style="width: 250px;" >
				</div>
			</div>
		</div>
		
		<br />
		
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
					
					<div id="itemWYSIWYG" class="itemWYSIWYG" onkeyup="itemDescUpdated();" onkeypress="itemDescUpdated();">No Description Available</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
				<input type="submit" class="btn btn-primary btn-sm" style="margin-left: 30px;" value="Add Item" />
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

<?php
	}}
?>