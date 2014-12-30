<?php

	$newAction = array();
	$newAction[ "Name" ] = "RCon Command";
	$newAction[ "SysName" ] = "rcon";
	$newAction[ "Description" ] = "Runs the specified RCon command when the player joins.";
	
	$rconCmd = new Argument();
	$rconCmd->DisplayName = "Command";
	$rconCmd->SysName = "command";
	$rconCmd->Description = "Runs an rcon command. Use **s for SteamID, **n for Name, and **u for UserID.";
	$rconCmd->PlaceHolder = "ulx adduser **s operator";
	$rconCmd->Type = ARG_TYPE::STR;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $rconCmd );
	Action::CreateAction( $newAction );

?>