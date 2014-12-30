<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title" style="font-size: 12px;height: 12px;">Send Credits</h3>
			</div>
		
			<div class="panel-body">
				<?php
					if( Setting::QuickValue( "credittransfer" ) == false ) {
						echo '<i style="font-size: 12px;">This feature has been disabled.</i>';
					} else {
				?>
				<form method="POST" action="?page=account" class="form-inline" role="form">
					<input type="hidden" name="sendCredits" value="1" />
					
					<div class="row" style="line-height: 38px;">
						<div class="col-md-4" style="text-align: right;">
							<b>Amount</b>
						</div>
						
						<div class="col-md-8" style="text-align: right;">
							<input type="text" name="amount" class="form-control" placeholder="$5.50" style="float: left;width: 80px;margin-right: 10px;" />
						</div>
					</div>
					
					<div class="row" style="line-height: 38px;">
						<div class="col-md-4" style="text-align: right;">
							<b>To</b>
						</div>
					
						<div class="col-md-8" style="text-align: right;">
							<input type="text" name="toSteam" class="form-control" placeholder="STEAM_0:1:23456789" />
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4" style="text-align: right;">
							<button type="submit" class="btn btn-primary btn-xs">Send Credits</button>
						</div>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title" style="font-size: 12px;height: 12px;">Purchase History</h3>
			</div>
			
			<table class="table" style="font-size: 13px;">
				<thead>
					<th style="width: 20%;">Date</th>
					<th style="width: 30%;">PurchaseID</th>
					<th style="width: 35%;">Item Name</th>
					<th style="width: 15%;">Amount</th>
				</thead>
				
				<tbody>
					<?php
						$Purchases = User::$ActiveUser->GetPurchases();
						
						if( count( $Purchases ) == 0 ) {
							echo '
								<tr>
									<td colspan=4>
										<div style="text-align: center;padding: 6px;font-size: 12px;"><i>You have never purchased anything before!</i></div>
									</td>
								</tr>
							';
						} else {
							foreach( $Purchases as $PurchaseObj ) {
								$ItemObj = Item::GetByField( "Item", "ID", $PurchaseObj->GetValue( "ItemID" ) );
							
								echo '
									<tr>
										<td>' . date( "n/j/y g:i A", $PurchaseObj->GetValue( "Date" ) ) . '</td>
										<td>' . $PurchaseObj->GetValue( "ID" ) . '</td>
										<td>' . $ItemObj->GetValue( "Name" ) . '</td>
										<td>
											<img src="includes/images/money_dollar.png" />
											' . number_format( (float) $PurchaseObj->GetValue( "PaymentAmount" ), 2, '.', '' ) . '</td>
									</tr>
								';
							}
						}
					?>
				</tbody>
			</table>
		</div>

		<br />

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title" style="font-size: 12px;height: 12px;">Donation History</h3>
			</div>
			
			<table class="table" style="font-size: 13px;">
				<thead>
					<th style="width: 20%;">Date</th>
					<th style="width: 30%;">TransactionID</th>
					<th style="width: 35%;">Paypal Email</th>
					<th style="width: 15%;">Amount</th>
				</thead>
				
				<tbody>
					<?php
						$Donations = User::$ActiveUser->GetDonations();
						
						if( count( $Donations ) == 0 ) {
							echo '
								<tr>
									<td colspan=4>
										<div style="text-align: center;padding: 6px;font-size: 12px;"><i>You have never donated before!</i></div>
									</td>
								</tr>
							';
						} else {
							foreach( $Donations as $DonationObj ) {
								echo '
									<tr>
										<td>' . date( "n/j/y g:i A", $DonationObj->GetValue( "Date" ) ) . '</td>
										<td>' . $DonationObj->GetValue( "TransactionID" ) . '</td>
										<td>' . $DonationObj->GetValue( "PayerEmail" ) . '</td>
										<td>
											<img src="includes/images/money_dollar.png" />
											' . number_format( (float) $DonationObj->GetValue( "Amount" ), 2, '.', '' ) . '</td>
									</tr>
								';
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>