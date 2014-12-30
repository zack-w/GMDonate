<div class="panel panel-default" style="padding: 20px;">
	<?php
		$ToSLink = Setting::QuickValue( "tos_link" );
	
		if( !empty( $ToSLink ) ) {
			echo '
				<div class="alert alert-warning" role="alert">
					<b>Notice:</b> By donating you agree to our <a href="' . $ToSLink . '">Terms of Service!</a>
				</div>
			';
		}
	?>
	
	<h3 style="margin-left: 20px;">Donate</h3>

	<br />
	
	<?php
		$PresetAmounts = array( 5, 10, 15, 20, 25, 30 );
		
		foreach( $PresetAmounts as $Amount ) {
			echo '
				<form name="form_' . $Amount . '" method="POST" action="?page=donate" style="display: inline-block;">
					<input type="hidden" name="go" value="true" />
					<input type="hidden" name="amount" value="' . $Amount . '" />
				
					<button style="background-color: #EEE;border: 1px solid #CCC;padding: 10px;display: inline-block;margin: 10px;color: #428bca;">
						<img src="includes/images/money_dollar.png" /> <b>' . number_format( (float) $Amount, 2, '.', '') . '</b>
					</button>
				</form>
			';
		}
	?>
	
	<form method="POST" action="?page=donate" style="display: inline-block;">
		<input type="hidden" name="go" value="true" />
		
		<div style="background-color: #EEE;border: 1px solid #CCC;padding: 10px;display: inline-block;margin: 10px;">
			<img src="includes/images/money_dollar.png" />
			<b><input type="number" name="amount" style="width: 60px;z-index: 999;" placeholder="50.00" style="color: #428bca;" /></b>
			<input type="submit" value="Go!" class="btn btn-primary btn-xs" />
		</div>
	</form>
</div>