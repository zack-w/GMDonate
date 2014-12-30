<?php

	// Make sure noone bad tries to access the config
	if( defined( "GMDonate_Initialized" ) == false ) {
		die( "Hacking attempt detected and logged." );
	}

	$AdminAreas = array(
		"dashboard" => "Dashboard",
		"general_settings" => "General Settings",
		"servers" => "Servers",
		"item_categories" => "Item Categories",
		"items" => "Items",
		//"users" => "Users",
		"upgrade" => "Upgrade",
		"manual" => "Manual",
	);

?>