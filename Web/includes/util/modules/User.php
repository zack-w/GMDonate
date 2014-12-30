<?php

	class User extends DB_Accessor {
	
		public static $TableName = "gmd_users";
		public static $ActiveUser = false;
		
		public function GetDonations() {
			return Donation::GetAllByField( "Donation", "AccountID", $this->Data[ "ID" ] );
		}
		
		public function GetPurchases() {
			return Purchase::GetAllByField( "Purchase", "UserID", $this->Data[ "ID" ] );
		}
		
		public function BuyItem( $ItemObj ) {
			$this->ChangeValue( "Credit", ($this->GetValue( "Credit" ) - $ItemObj->GetValue( "Cost" )) );
			$ItemObj->OnUserBuy( $this );
		}
		
		public function AddCredit( $Amt ) {
			$CurCredits = $this->GetValue( "Credit" );
			$this->ChangeValue( "Credit", ($CurCredits + $Amt) );
		}
		
		public function IsAdmin() {
			global $GMDConfig;
			if( $this->GetValue( "SteamID" ) == $GMDConfig[ "AdminSteamID" ] ) return true;
			if( $this->GetValue( "UserType" ) == 2 ) return true;
			return false;
		}
		
		// Sets the user viewing the page to authenticate to this account
		public function AuthToUser( $Length = 86400 ) {
			$AuthHash = md5( rand() ) . md5( rand() );
			$this->ChangeValue( "AuthHash", $AuthHash );
			User::$ActiveUser = $this;
			setcookie( "GMD_AuthHash", $AuthHash, time() + $Length );
		}
		
		// Logs the user in automatically (each page load)
		public static function AutoLogin() {
			if( empty( $_COOKIE[ "GMD_AuthHash" ] ) || strlen( $_COOKIE[ "GMD_AuthHash" ] ) != 64 ) {
				return false;
			}
			
			$User = User::GetByField( "User", "AuthHash", $_COOKIE[ "GMD_AuthHash" ] );
			
			if( $User == false || $User->IsReal() != true ) {
				// Their AuthHash was bad... should we log this maybe?
				// setcookie( "GMD_AuthHash", "0", 0 ); // diabled for now
				return false;
			}
			
			User::$ActiveUser = $User;
		}
		
		public static function RegisterUser( $SteamID, $IP ) {
			$AuthHash = md5( rand() ) . md5( rand() );
			$SteamID = Database::Escape( $SteamID );
			$IP = Database::Escape( $IP );
			
			Database::Query( "INSERT INTO `gmd_users` VALUES (NULL, '%s', '%s', '%s', 0, 0.0);", $AuthHash, $SteamID, $IP );
			return User::GetByField( "User", "SteamID", $SteamID );
		}
		
		public static function Logout() {
			User::$ActiveUser = false;
			setcookie( "GMD_AuthHash", "0", 0 );
			return true;
		}
		
		public static function AccessCheck_LoggedIn() {
			return ( function() {
				if( User::$ActiveUser == false )
					return "You must be logged in to access this page.";
				
				return true;
			} );
		}
		
		public static function AccessCheck_Admin() {
			return ( function() {
				if( User::$ActiveUser == false || User::$ActiveUser->IsAdmin() == false )
					return "You must be an administrator to access this page.";
				
				return true;
			} );
		}
	}

	User::AutoLogin();
	
?>