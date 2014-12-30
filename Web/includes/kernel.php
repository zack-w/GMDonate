<?php
	
	if( defined( "GMDonate_Initialized" ) == false ) {
		die( "Hacking attempt detected and logged." );
	}
	
	require_once( "includes/config.php" );
	
	class KERNEL {
		
		static $Pages = array();
		static $DefaultPage = "";
		static $ErrorMessage = "";
		
		static function OnError( $ErrorMessage, $HeaderFooter = true ) {
			KERNEL::$ErrorMessage = $ErrorMessage;
			KERNEL::LoadPage( "error", $HeaderFooter );
		}
		
		static function SetDefaultPage( $newDefaultPage ) {
			KERNEL::$DefaultPage = $newDefaultPage;
		}
		
		static function AddPage( $PageName, $DisplayName, $ShowOnNav = false, $AccessCheck = null, $ButtonHTM = null ) {
			if( !ctype_alpha( $PageName ) )
				KERNEL::OnError( "Invalid page name '" . $PageName . "'" );
				
			if( !is_dir( "pages/" . $PageName ) )
				KERNEL::OnError( "No page directory 'pages/" . $PageName );
			
			if( !is_file( "pages/" . $PageName . "/_process.php" ) )
				KERNEL::OnError( "No page process file located 'pages/" . $PageName . "/_process.php" );
			
			if( !is_file( "pages/" . $PageName . "/_display.php" ) )
				KERNEL::OnError( "No page display file located 'pages/" . $PageName . "/_display.php" );
			
			KERNEL::$Pages[ $PageName ] = array( $DisplayName, $ShowOnNav, $AccessCheck, $ButtonHTM );
		}
		
		static function IsValidPage( $PageName ) {
			return ( isset( KERNEL::$Pages[ $PageName ] ) );
		}
		
		static function LoadModule( $ModuleName, $Required = true ) {
			if( !is_file( "includes/util/modules/" . $ModuleName . ".php" ) && $Required )
				KERNEL::OnError( "No module reference file 'includes/util/modules/" . $ModuleName . ".php'" );
			
			@include( "includes/util/modules/" . $ModuleName . ".php" );
		}
		
		static function LoadPage( $PageName, $Wrapper = true ) {
			if( KERNEL::IsValidPage( $PageName ) == false )
				KERNEL::OnError( "Attempt to load invalid page '" . $PageName . "'" );
			
			if( !is_null( KERNEL::$Pages[ $PageName ][ 2 ] ) ) {
				$Result = call_user_func( KERNEL::$Pages[ $PageName ][ 2 ] );
				
				if( $Result !== true ) {
					KERNEL::OnError( "Access Denied - " . $Result );
					die( "" ); // Force cancel just incase
				}
			}
			
			if( $Wrapper ) {
				global $GMDConfig;
				$OpenID = new LightOpenID( $GMDConfig[ "Domain" ] );
				
				if( $OpenID->validate() ) {
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
				} elseif( $_GET[ "page" ] == "login" ) {
					if( User::$ActiveUser != false ) {
						if( isset( $_GET[ "logout" ] ) ) User::Logout();
						KERNEL::HardNavigate( "home" );
					} else {
						$OpenID->identity = 'http://steamcommunity.com/openid';
						header('Location: ' . $OpenID->authUrl());
					}
				}
				
				LightOpenID::revalidate();
			}
			
			global $OutputData;
			$OutputData = "";
			
			if( $Wrapper ) require( "includes/util/header.php" );
				require( "pages/" . $PageName . "/_process.php" );
				require( "pages/" . $PageName . "/_display.php" );
				echo $OutputData;
			if( $Wrapper ) require( "includes/util/footer.php" );
		}
		
		static function NavigatePage() {
			if( !$_GET[ "page" ] )
				KERNEL::LoadPage( KERNEL::$DefaultPage );
			else
				KERNEL::LoadPage( $_GET[ "page" ] );
		}
		
		static function HardNavigate( $Page, $Extra = "" ) {
			$Path = ( $GMDConfig[ "Domain" ] . $GMDConfig[ "Path" ] . "?page=" . $Page . $Extra );
			echo '<meta http-equiv="refresh" content="1;URL=' . $Path . '">';
		}
		
	}

?>