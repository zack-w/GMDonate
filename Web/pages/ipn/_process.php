<?php

	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();
	
	foreach ($raw_post_array as $keyval) {
	  $keyval = explode ('=', $keyval);
	  if (count($keyval) == 2)
		 $myPost[$keyval[0]] = urldecode($keyval[1]);
	}
	
	$req = 'cmd=_notify-validate';
	
	if(function_exists('get_magic_quotes_gpc')) {
	   $get_magic_quotes_exists = true;
	}
	
	foreach ($myPost as $key => $value) {        
	   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
			$value = urlencode(stripslashes($value)); 
	   } else {
			$value = urlencode($value);
	   }
	   $req .= "&$key=$value";
	}
	
	$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
	//$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	
	if( !($res = curl_exec($ch)) ) {
		curl_close($ch);
		exit;
	}
	
	curl_close($ch);
	
	if ( strcmp ($res, "VERIFIED") == 0 ) {
		/* SETUP OUR VARIABLES */
		$Email = Setting::QuickValue( "pp_email" );
		$Currency = Setting::GetByField( "Setting", "SysName", "pp_currency" )->GetValue();
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$item_name = $_POST['item_name'];
		$item_number = intval( $_POST['item_number'] );
		$payment_status = $_POST['payment_status'];
		$payment_amount = floatval( $_POST['mc_gross'] );
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		$custom = $_POST['custom'];
		
		/* MAKE SURE THEY ARENT TRYING ANYTHING TRICKY */
		
		if( $payment_currency != $Currency ) {
			die( "" ); // Bad currency..
		} elseif( $receiver_email != $Email ) {
			die( "" ); // Bad receiver email..
		} elseif( $payment_status != "Completed" ) {
			die( "" ); // Transaction not complete
		}
		
		/* Fetch the User Account */
		$User = User::GetByField( "User", "SteamID", $custom );
		
		if( $User == false || $User->IsReal() == false ) {
			// They don't have an account.. wtf, lets make one to be safe
			$User = User::RegisterUser( $custom, "0.0.0.0" );
		}
		
		/* MAKE SURE THEY DIDNT ALREADY GET THEIR SHIT */
		$Donation = Donation::GetByField( "Donation", "TransactionID", $txn_id );
		
		if( $Donation->IsReal() == true ) {
			die( "" ); // They already got their shit
		}
		
		/* GIVE THEM THEIR SHIT */
		$time = time();
		$uid = $User->Data[ "ID" ];
		
		$User->ChangeValue( "Credit", $User->Data[ "Credit"] + $payment_amount );
		Database::Query( "INSERT INTO `gmd_donations` VALUES ( NULL, 1, '{$txn_id}', '{$custom}', '{$payer_email}', '{$first_name}', '{$last_name}', {$time}, {$payment_amount}, '{$payment_currency}' );" );
	} else {
		fwrite( $FileObj, "bad ipn" );
		die( "" ); // Could not validate IPN
	}
	
?>