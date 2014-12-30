<div style="padding: 20px;">
	<table class="table" style="font-size: 13px;">
		<thead>
			<th style="width: 50%;">Category Name</th>
			<th style="text-align: center;width: 20%;">Num Products</th>
			<th style="text-align: right;width: 30%;">Actions</th>
		</thead>
		
		<tbody>
			<?php
				$ItemCategories = ItemCategory::GetCachedResults( "ItemCategory" );
				
				if( count( $ItemCategories ) == 0 ) {
					echo "
						<tr>
							<td colspan='3' style='text-align: center;padding: 12px;font-size: 12px;'>
								<i>There are no item categories to display!</i>
							</td>
						</tr>
					";
				} else {
					foreach( $ItemCategories as $ItemCat ) {
						$ItemsInCat = Item::GetAllByField( "Item", "Category", $ItemCat->GetValue( "ID" ) );
					
						echo "
							<tr>
								<td>" . $ItemCat->GetValue( "Name" ) . "</td>
								<td style='text-align: center;'>" . count( $ItemsInCat ) . "</td>
								<td style='text-align: right;'>
									<a href='?page=admin&area=item_categories&delete=" . $ItemCat->GetValue( "ID" ). "'><span class='btn btn-xs btn-danger'>Delete</span></a>
								</td>
							</tr>
						";
					}
				}
			?>
		</tbody>
	</table>

	<br />
	
	<form class="form-inline" method="POST" action="?page=admin&area=item_categories">
		<input type="hidden" name="addItemCat" value="yes" />
		<input type="text" name="itemCatName" class="form-control" style="height: 28px;" placeholder="Category Name" required="true" />
		<input type="submit" value="Create" class="btn btn-xs btn-success" />
	</form>
</div>