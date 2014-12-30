<?php
	
	$ItemCategories = ItemCategory::GetCachedResults( "ItemCategory" );
	
	if( count( $ItemCategories ) == 0 ) {
		KERNEL::OnError( "You must add an item category before accessing this page.", false );
	} else {
		foreach( $ItemCategories as $ItemCat ) {
			echo '
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="?page=admin&area=items&newitem=1&catid=' . $ItemCat->GetValue( "ID" ) .'" style="float: right;"><span class="btn btn-xs btn-success">Add Item</span></a>
						<b>' . $ItemCat->GetValue( "Name" ) . ' Items</b>
					</div>
					
					<table class="table">
						<thead style="font-size: 12px;">
							<th style="width: 50%;">Name</th>
							<th style="width: 25%;">Cost</th>
							<th style="width: 25%;text-align: right;">Actions</th>
						</thead>
						
						<tbody>
			';
			
			$Items = Item::SearchCachedResults( "Item", "Category", $ItemCat->GetValue( "ID" ) );
			
			if( count( $Items ) == 0 ) {
				echo '<tr><td colspan=3 style="text-align: center;padding: 16px;font-size: 12px;"><i>No items to display!</i></td></tr>';
			} else {
				foreach( $Items as $ItemObj ) {
					echo '
						<tr style="font-size: 12px;">
							<td>' . $ItemObj->GetValue( "Name" ) . ' 
					';
					
					if( $ItemObj->GetValue( "Status" ) == ItemStatus::DISABLED )
						echo '<b style="font-size: 10px;color: #888;"> (Disabled)</b>';
					
					echo '
							</td>
							<td><img src="includes/images/money_dollar.png" /> ' . number_format( $ItemObj->GetValue( "Cost" ), 2 ) . '</td>
							<td style="text-align: right;">
								<a href="?page=admin&area=items&edit=1&item=' . $ItemObj->GetValue( "ID" ) . '" class="btn btn-info btn-xs">Edit</a>
								<a href="?page=admin&area=items&delete=' . $ItemObj->GetValue( "ID" ) . '" class="btn btn-danger btn-xs">Delete</a>
							</td>
						</tr>
					';
				}
			}
			
			echo '
						</tbody>
					</table>
				</div>
				<br />
			';
		}
	}
	
?>