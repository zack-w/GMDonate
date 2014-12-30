<?php

	if( isset( $_POST[ "go" ] ) ) {
		global $GMDConfig;
		$Amount = intval( $_POST[ "amount" ] );
		$PageURL = $GMDConfig[ "Domain" ] . $GMDConfig[ "Path" ];
		
		die( '
			<form id="donateForm" action="https://www.paypal.com/cgi-bin/webscr" method="POST">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="notify_url" value="http://' . $PageURL . '?page=ipn">
				<input type="hidden" name="image_url" value="' . ( $PageURL . Setting::QuickValue( "banner" ) ) . '">
				<input type="hidden" name="business" value="' . Setting::QuickValue( "pp_email" ) . '">
				<input type="hidden" name="currency_code" value="' . Setting::QuickValue( "pp_currency" ) . '">
				<input type="hidden" name="amount" value="' . $Amount . '">
				<input id="coinName" type="hidden" name="item_name" value="Donation">
				<input type="hidden" name="custom" value="' . User::$ActiveUser->GetValue( "SteamID" ) . '">
			</form>
			
			<div class="panel panel-default" style="padding: 40px;">
				<h3>Donate</h3>
				<br />
				Please wait while you are being redirected...
			</div>
			
			<script>document.getElementById( "donateForm" ).submit();</script>
		' );
	}

?>