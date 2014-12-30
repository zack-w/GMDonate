<?php

	class DLC {
		
		static $DLCs = array();
		
		public static function CreateDLC( $DLCData ) {
			self::$DLCs[ $DLCData[ "SysName" ] ] = $DLCData;
		}
		
		public static function GetAction( $DLCName ) {
			return self::$DLCs[ $DLCName ];
		}
		
		static function loadDLCs() {
			foreach ( glob( "includes/util/dlc/*.php" ) as $DLCFile ) {
				require $DLCFile;
			}
		}
		
	}

?>