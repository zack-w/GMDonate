<?php 

	$ItemAction = ItemAction::GetByField( "ItemAction", "ID", $_GET[ "editaction" ] );
	$ItemActionData = $ItemAction->GetData();
	
	$ActionArr = Action::GetAction( $ItemAction->GetValue( "ActionType" ) );
	$ItemObj = Item::GetByField( "Item", "ID", $ItemAction->GetValue( "ItemID" ) );
	
	if( isset( $_POST[ "doEditAction" ] ) ) {
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
		
		$ItemAction->ChangeValue( "ActionData", $ActionData );
		$ItemAction->ChangeValue( "Servers", $ServerData );
		KERNEL::HardNavigate( "admin", "&area=items&edit=1&item=" . $ItemObj->GetValue( "ID" ) );
	} elseif( isset( $_GET[ "del" ] ) ) {
		$ItemAction->Delete();
		KERNEL::HardNavigate( "admin", "&area=items&edit=1&item=" . $ItemObj->GetValue( "ID" ) );
	}
	
?>

<h4>Edit Action</h4>

<form method="POST" action="?page=admin&area=items&editaction=<?= $ItemAction->GetValue( "ID" ); ?>">
	<input type="hidden" name="doEditAction" value="yes" />
	
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
		$i = 0;
		
		foreach( $ActionArr[ "Arguments" ] as $ArgObject ) {
			echo $ArgObject->GenerateEditor( $ItemActionData[ $i ] );
			$i++;
		}
	?>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<b>Servers</b>
		</div>
		
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<div style="font-size: 12px;border: 1px solid #DDD;padding: 6px;width: 300px;border-radius: 4px;">
				<?
					$ServersArr = explode( ";", $ItemAction->GetValue( "Servers" ) );
					
					foreach( Servers::GetCachedResults( "Servers" ) as $ServerObj ) {
						$Checked = "";
						
						foreach( $ServersArr as $ServerID ) {
							if( $ServerObj->GetValue( "ID" ) == intval( $ServerID ) ) {
								$Checked = "checked";
							}
						}
					
						echo '<input name="action_server_' . $ServerObj->GetValue( "ID" ) . '" type="checkbox" ' . $Checked . ' /> ' . $ServerObj->GetValue( "Name" ) . '<br />';
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
			<input type="submit" class="btn btn-sm btn-primary" value="Save" />
			
			<span class="dropdown">
				<a id="drop4" role="button" data-toggle="dropdown" href="#" class="btn btn-sm btn-danger">Delete</a>
				<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
					<li><a role="menuitem" href="?page=admin&area=items&editaction=<?= $ItemAction->GetValue( "ID" ); ?>&del=1" style="font-weight: bold;color: darkred;background-color: #FFDFDF;">Confirm</a></li>
					<li><a role="menuitem" href="#">Cancel</a></li>
				</ul>
			</span>
		</div>
	</div>
</form>