<?php

	function GetUserSteamInfo( $CommunityID )
	{
		$Key = "A04024BC178CF190A60DC2A177C6C404";
		
		$Data = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0001/?key=" . $Key . "&steamids=" . $CommunityID);
		$DataTable = json_decode( $Data );
		
		return $DataTable->response->players->player[ 0 ];
	}
	
	function SteamToCommunity( $SteamID )
	{
		$parts = explode(':', str_replace('STEAM_', '' ,$SteamID)); 
		return bcadd(bcadd('76561197960265728', $parts['1']), bcmul($parts['2'], '2')); 
	}

	function CommunityToSteam( $CommunityID )
	{
		$tmpfriendID = $CommunityID;
		$iServer = "1";
		
		if(bcmod($CommunityID, "2") == "0"){ $iServer = "0"; }
		$tmpfriendID = bcsub($tmpfriendID,$iServer);
		
		if(bccomp("76561197960265728",$tmpfriendID) == -1)
			$tmpfriendID = bcsub($tmpfriendID,"76561197960265728");
			
		$tmpfriendID = bcdiv($tmpfriendID, "2");
		return ("STEAM_0:" . $iServer . ":" . $tmpfriendID);
	}
	
?>