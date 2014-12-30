<?php

	if( !is_numeric( $_GET[ "cat" ] ) ) {
		die( "Nice try. Your attempt has been recorded." );
	}
	
	$Items = Item::SearchCachedResults( "Item", "Category", $_GET[ "cat" ] );
	$ItemsRendered = 0;
	
	foreach( $Items as $ItemObj ) {
		if( $ItemObj->GetValue( "Status" ) != ItemStatus::DISABLED ) {
			if( $ItemsRendered % 2 == 0 ) echo '<div class="row">';
			
			echo '
				<div class="col-sm-6 col-md-6">
					<div class="thumbnail">
			';
			
			// The code for showing the image
			if( $ItemObj->Data[ "ShowImage" ] == 1 ) {
				if( empty( $ItemObj->Data[ "Image" ] ) || $ItemObj->Data[ "Image" ] == "item_default.png" ) 
					echo '<img data-src="js/holder.js/100%x150/text:No Image Available" alt="..." />';
				else
					echo '<img src="includes/images/uploaded/' . $ItemObj->Data[ "Image" ] . '" />';
			}			
			
			echo '
				<div class="caption">
					<h3>' . $ItemObj->GetValue( "Name" ) . '</h3>

					' . $ItemObj->GetValue( "Description" ) . '
					
					<br /><br />
			';
			
			if( User::$ActiveUser != false && User::$ActiveUser->IsAdmin() ) {
				echo '
					<a href="?page=admin&area=items&edit=1&item=' . $ItemObj->GetValue( "ID" ) . '" style="display: inline;float: left;margin: 2px 14px 0 0;">
						<img src="includes/images/pencil.png" class="cartButton" />
					</a>
				';
			}
			
			if( User::$ActiveUser == false || !User::$ActiveUser->IsReal() ) {
				echo '
					<a href="javascript:toggleBadBal(' . $ItemObj->GetValue("ID") . ');" title="Buy now!">
						<span class="cartButton">
							<img src="includes/images/cart.png" />
							<span class="cartPrice" >' . number_format( (float) $ItemObj->GetValue( "Cost" ), 2 ) . '</span>
						</span>
					</a>
					
					<br /><br />
					
					<span id="errorMsg_' . $ItemObj->GetValue( "ID" ) . '" style="display: none;color: darkred;font-weight: bold;font-size: 12px;">
						Please login to purchase this item.
					</span>
				';
			} elseif( $ItemObj->GetValue( "Cost" ) > User::$ActiveUser->GetValue( "Credit" ) ) {
				echo '
					<a href="javascript:toggleBadBal(' . $ItemObj->GetValue("ID") . ');" title="Buy now!">
						<span class="cartButton">
							<img src="includes/images/cart.png" />
							<span class="cartPrice" >' . number_format( (float) $ItemObj->GetValue( "Cost" ), 2 ) . '</span>
						</span>
					</a>
					
					<br /><br />
					
					<span id="errorMsg_' . $ItemObj->GetValue( "ID" ) . '" style="display: none;color: darkred;font-weight: bold;font-size: 12px;">
						[Error] Not enough funds in account.
					</span>
				';
			} else {
				echo '
					<span class="dropdown">
						<a id="drop4" role="button" data-toggle="dropdown" href="#">
							<span class="cartButton">
								<img src="includes/images/cart.png" />
								<span class="cartPrice" >' . number_format( (float) $ItemObj->GetValue( "Cost" ), 2 ) . '</span>
							</span>
						</a>
						
						<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
							<li><a role="menuitem" href="?page=store&cat=' . $ItemObj->GetValue( "Category" ) . '&dobuy=' . $ItemObj->GetValue("ID") . '">Confirm Purchase</a></li>
							<li><a href="">Cancel</a></li>
						</ul>
					</span>
				';
			}
			
			echo '
						</div>
					</div>
				</div>
			';
			
			if( $ItemsRendered % 2 == 1 ) echo '</div>';
			
			$ItemsRendered++;
		}
	}
	
	if( $ItemsRendered == 0 ) {
		echo '
			<div class="panel panel-default" style="padding: 18px;">
				There are currently no items to display in this category!
			</div>
		';
	}
	
?>

<script>
	function toggleBadBal( itemID ) {
		var errDiv = document.getElementById( "errorMsg_" + itemID );
		errDiv.style.display = "block";
	}
</script>