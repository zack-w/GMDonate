<?php

	class Donation extends DB_Accessor {
	
		public static $TableName = "gmd_donations";
		
		public static function SumDonations( $NumDays = 10000 ) {
			$Time = time() - ( $NumDays * 86400 );
			$QueryRes = Database::Query( "SELECT SUM(Amount) FROM " . self::$TableName . " WHERE Date > {$Time};" )->fetch_assoc();
			$TotalDonated = ( isset( $QueryRes[ "SUM(Amount)" ] ) )?( intval( $QueryRes[ "SUM(Amount)" ] ) ):( 0 );
			return $TotalDonated;
		}
		
		public static function DailyAverage( $NumDays ) {
			return ( self::SumDonations( $NumDays ) / $NumDays );
		}
		
	}

?>