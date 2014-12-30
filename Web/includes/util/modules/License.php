<?php
	
	class License {
		
		public static function getKey() {
			global $GMDConfig;
			return $GMDConfig[ "LicenseKey" ];
		}
		
		public static function isKeyValid( $K ) {
			return strlen( $k ) > 12; // todo
		}
		
	}
	
?>