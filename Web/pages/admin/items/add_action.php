<?php 

	$ItemObj = Item::GetByField( "Item", "ID", intval( $_GET[ "item" ] ) );
	$ActionArr = Action::GetAction( $_GET[ "addaction" ] );
	
	if( isset( $_POST[ "doAddAction" ] ) ) {
		$ActionData = "";
		$ServerData = "";
		
		foreach( $ActionArr[ "Arguments" ] as $ArgObject ) {
			$ActionData .= $_POST[ "input_" . $ArgObject->SysName ] . ItemAction::$SerialKey;
		}
		
		foreach( Servers::GetCachedResults( "Servers" ) as $ServerObj ) {
			if( isset( $_POST[ "action_server_" . $ServerObj->GetValue( "ID" ) ] ) ) {
				$ServerData .= $ServerObj->GetValue( "ID" ) . ";";
			}
		}
		
		ItemAction::AddItemAction( $ItemObj->GetValue( "ID" ), $ActionArr[ "SysName" ], $ActionData, $ServerData );
		KERNEL::HardNavigate( "admin", "&area=items&edit=1&item=" . $ItemObj->GetValue( "ID" ) );
	}
	
?>

<h4>Add Action</h4>

<form method="POST" action="?page=admin&area=items&addaction=<?= $ActionArr[ "SysName"]; ?>&item=<?= $ItemObj->GetValue( "ID" ); ?>">
	<input type="hidden" name="doAddAction" value="yes" />
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<b>Item Name</b>
		</div>
		
		<div class="col-sm-6 col-md-8" style="text-align: left;">
			<input type="text" class="form-control" value="<?= $ItemObj->GetValue( "Name" ); ?>" style="width: 200px;" readonly>
		</div>
	</div>
	
	<br />
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<b>Action Name</b>
		</div>
		
		<div class="col-sm-6 col-md-8" style="text-align: left;">
			<input type="text" class="form-control" value="<?= $ActionArr[ "Name" ]; ?>" style="width: 200px;" readonly>
		</div>
	</div>
	
	<br />
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<b>Action Description</b>
		</div>
		
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<?= $ActionArr[ "Description" ]; ?>
		</div>
	</div>
	
	<br />
	
	<?php
		foreach( $ActionArr[ "Arguments" ] as $ArgObject ) {
			echo $ArgObject->GenerateEditor();
		}
	?>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<b>Servers</b>
		</div>
		
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<div style="font-size: 12px;border: 1px solid #DDD;padding: 6px;width: 300px;border-radius: 4px;">
				<?php
					foreach( Servers::GetCachedResults( "Servers" ) as $ServerObj ) {
						echo '<input name="action_server_' . $ServerObj->GetValue( "ID" ) . '" type="checkbox" /> ' . $ServerObj->GetValue( "Name" ) . '<br />';
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<input type="submit" class="btn btn-sm btn-primary" value="Create" />
		</div>
	</div>
</form>