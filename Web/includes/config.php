<?php

	// Make sure noone bad tries to access the config
	if( defined( "GMDonate_Initialized" ) == false ) {
		die( "Hacking attempt detected and logged." );
	}
	
	global $GMDConfig;
	
	$GMDConfig = array(
		"Domain" => "yourwebsite.com", // See examples below
		"Path" => "/donate/", // See examples below
		"DB_Host" => "",
		"DB_Username" => "",
		"DB_Password" => "",
		"DB_Name" => "",
		"DB_Port" => 3306,
		"AdminSteamID" => "",
		"LicenseKey" => "", // Read below
	);
	
	/* ---[ License Key Information ]---
		Your license key is the TransactionID of the PayPal payment when you bought this item.
		If you need help locating your license key, contact me using the CoderHire ticket system.
		WARNING: Distributing your key will result in it being suspend.
		
		----------------------------------------------------------------------------------
		
		Website: mywebsite.com/donate/
			Domain: mywebsite.com
			Path: /donate/
		
		Website: donate.mywebsite.com
			Domain: donate.mywebsite.com
			Path: /
			
		Website: donate.mywebsite.com/auto/
			Domain: donate.mywebsite.com
			Path: /auto/
			
		----------------------------------------------------------------------------------
			
		Note, the UseAPC field should remain true all the time as it dramatically decreases
		the about of database queries and increases performance using caching in the
		memory. The only reason I added a field to disable it was because some webservers
		may not have APC enabled so if you don't disable it, the module will not work.
		Below I have it automatically disable APC if it's not installed.
	*/
	
	$GMDConfig[ "UseAPC" ] = extension_loaded( "apc" );
	
?>