<h3 style="margin-left: 20px;">Dashboard</h3>

<div class="panel-body">
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;"><b>Past 24 Hours</b></div>
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<img src="includes/images/money_dollar.png" />
			<?= number_format( (float) Donation::SumDonations( 1 ), 2, '.', ''); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;"><b>Daily Average Donations</b></div>
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<img src="includes/images/money_dollar.png" />
			<?= number_format( (float) Donation::DailyAverage( 30 ), 2, '.', ''); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;"><b>Total Donations</b></div>
		<div class="col-sm-6 col-md-8" style="text-align: left;line-height: 34px;">
			<img src="includes/images/money_dollar.png" />
			<?= number_format( (float) Donation::SumDonations(), 2, '.', ''); ?>
		</div>
	</div>
</div>