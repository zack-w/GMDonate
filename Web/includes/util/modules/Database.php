<?php
	
	class Database {
		
		public static $DB;
		public static $NumQueries = 0;
		
		public static function Connect() {
			global $GMDConfig;
			Database::$DB = new mysqli( $GMDConfig[ "DB_Host" ], $GMDConfig[ "DB_Username" ], $GMDConfig[ "DB_Password" ], $GMDConfig[ "DB_Name" ], $GMDConfig[ "DB_Port" ] );
		
			if( self::isInstalled() == false )
				self::Install();
		}
		
		static function Escape( $Value ) {
			return Database::$DB->escape_string( $Value );
		}
		
		static function Insert( $TableName, $Data ) {
			$InsertQuery = "INSERT INTO `{$TableName}` (";
			$Incrementer = 0;
			
			foreach( $Data as $Key => $Value ) {
				$Incrementer++;
				$InsertQuery .= "`" . $Key . "` ";
				if( count( $Data ) > $Incrementer ) $InsertQuery .= ",";
			}
			
			$InsertQuery .= ") VALUES (";
			$Incrementer = 0;
			
			foreach( $Data as $Key => $Value ) {
				$Incrementer++;
			
				if( is_numeric( $Value ) )
					$InsertQuery .= $Value;
				else
					$InsertQuery .= "'" . Database::Escape( $Value ) . "'";
					
				if( count( $Data ) > $Incrementer ) $InsertQuery .= ",";
			}
			
			$InsertQuery .= ");";
			Database::Query( $InsertQuery );
		}
		
		static function LastInsertID() {
			return Database::$DB->insert_id;
		}
		
		static function Query() {
			Database::$NumQueries++;
			
			$Args = func_get_args();
			$Query = $Args[ 0 ];
			unset( $Args[ 0 ] );
			return ( Database::$DB->query( vsprintf( $Query, $Args ) ) );
		}
	
		static function isInstalled() {
			$QueryRes = self::Query( "SELECT 1 FROM gmd_settings LIMIT 1;" );
			return empty( self::$DB->error );
		}
	
		static function Install() {
			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_donations` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `AccountID` int(10) unsigned DEFAULT NULL,
				  `TransactionID` varchar(32) DEFAULT NULL,
				  `SteamID` varchar(32) DEFAULT NULL,
				  `PayerEmail` varchar(64) DEFAULT NULL,
				  `FirstName` varchar(48) DEFAULT NULL,
				  `LastName` varchar(48) NOT NULL,
				  `Date` int(10) unsigned DEFAULT NULL,
				  `Amount` decimal(10,0) DEFAULT NULL,
				  `Currency` varchar(24) DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
			" );
			
			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_itemactions` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `ItemID` int(10) unsigned DEFAULT NULL,
				  `ActionType` varchar(64) DEFAULT NULL,
				  `ActionData` text,
				  `Servers` text,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_itemcategories` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `Name` varchar(32) DEFAULT NULL,
				  `Visible` tinyint(2) unsigned DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_items` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `Category` int(10) unsigned DEFAULT NULL,
				  `Name` varchar(64) DEFAULT NULL,
				  `Description` text,
				  `Cost` float unsigned DEFAULT NULL,
				  `NumPurchases` int(10) unsigned DEFAULT '0',
				  `Image` varchar(128) DEFAULT NULL,
				  `ShowImage` tinyint(2) unsigned DEFAULT NULL,
				  `Status` tinyint(2) unsigned DEFAULT 1,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_purchases` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `ItemID` int(10) unsigned DEFAULT NULL,
				  `UserID` int(10) unsigned DEFAULT NULL,
				  `Date` int(10) unsigned DEFAULT NULL,
				  `PurchasingIP` varchar(64) DEFAULT NULL,
				  `PaymentAmount` int(10) unsigned DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_servers` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `Name` varchar(64) DEFAULT NULL,
				  `IP` varchar(32) DEFAULT NULL,
				  `Port` int(10) unsigned DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_settings` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `Type` tinyint(4) unsigned DEFAULT NULL,
				  `Style` varchar(225) DEFAULT NULL,
				  `SysName` varchar(32) DEFAULT NULL,
				  `DisplayName` varchar(32) DEFAULT NULL,
				  `Description` varchar(225) DEFAULT NULL,
				  `Value` text,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
			" );

			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_useractions` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `DateEffective` int(10) unsigned DEFAULT NULL,
				  `ItemAction` int(10) unsigned DEFAULT NULL,
				  `UserData` varchar(32) DEFAULT NULL,
				  `Status` tinyint(3) unsigned DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
			" );
			
			self::$DB->query( "
				CREATE TABLE IF NOT EXISTS `gmd_users` (
				  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `AuthHash` varchar(225) DEFAULT NULL,
				  `SteamID` varchar(32) DEFAULT NULL,
				  `RegistrationIP` varchar(64) DEFAULT NULL,
				  `UserType` int(10) unsigned DEFAULT NULL,
				  `Credit` float DEFAULT NULL,
				  PRIMARY KEY (`ID`)
				) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
			" );
			
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '4', null, 'homehtml', 'Home Page', 'The text that is displayed on the home screen.', '\r\n		\r\n		\r\n		\r\n		<h3><b>GMDonate</b></h3><br>\r\nHello and thank you for purchasing GMDonate. Please remember to fully read the manual on the administrator page. If you are unable to access the administrator page, make sure that you added your SteamID to the config.php file.<div><br></div><div>- Hans</div>');" );
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '2', 'width: 100px;', 'pp_currency', 'PayPal Currency', 'The currency you wish for people to pay in on paypal.', 'USD');" );
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '2', 'width: 250px;', 'pp_email', 'PayPal Email', 'The email address that you wish for people to donate to.', 'your@email.com');" );
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '3', 'margin-top: 10px;', 'banner', 'Logo', 'Your logo/banner that will be shown at the top of the page.', 'gmdonate_logo.png');" );
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '5', '', 'credittransfer', 'Allow sending credits?', 'Should players be able to send credits to eachother?', '1');" );
			self::$DB->query( "INSERT INTO `gmd_settings` VALUES (NULL, '2', 'width: 250px;', 'tos_link', 'ToS Link', 'This should be a link to your terms of service. Leave empty for no terms of service.', '');" );
		}
	
	}
	
	Database::Connect();
	
?>