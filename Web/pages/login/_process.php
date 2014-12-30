<?php

	global $GMDConfig;
	$OpenID = new LightOpenID( $GMDConfig[ "Domain" ] );
	
	if( User::$ActiveUser != false ) {
		if( isset( $_GET[ "logout" ] ) ) {
			User::Logout();
			KERNEL::HardNavigate( "home" );
		} else {
			// They are logged in, so just render the home screen
			KERNEL::LoadPage( "home", false );
		}
	} else {
		// See if they already signed in through OpenID
		
		/*
		if( false && $OpenID->validate() ) {
			/*
			$ID = $OpenID->identity;
			$URL_Parts = explode( "/", $ID );
			
			// Get their SteamID
			$CommunityID = $URL_Parts[ sizeof( $URL_Parts ) - 1];
			$SteamID = CommunityToSteam( $CommunityID );
			
			// Try and authenticate them
			$User = User::GetByField( "User", "SteamID", $SteamID );
			
			if( $User->IsReal() ) $User->AuthToUser();
			else User::RegisterUser( $SteamID, $_SERVER[ 'REMOTE_ADDR' ] )->AuthToUser();
			KERNEL::HardNavigate( "home" );
			
		} else {
			$OpenID->identity = 'http://steamcommunity.com/openid';
			header('Location: ' . $OpenID->authUrl());
		}
		*/
	}
	
?>