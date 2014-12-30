<?php

	$newAction = array();
	$newAction[ "Name" ] = "GMod Usergroup";
	$newAction[ "SysName" ] = "usergroup";
	$newAction[ "Description" ] = "Gives a player an ingame usergroup. Read the manual before using this.";
	
	$usergroupArg = new Argument();
	$usergroupArg->DisplayName = "Usergroup";
	$usergroupArg->SysName = "usergroup";
	$usergroupArg->Description = "The name of the usergroup, how it's stored may vary from addon to addon.";
	$usergroupArg->PlaceHolder = "superadmin";
	$usergroupArg->Type = ARG_TYPE::STR;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $usergroupArg );
	Action::CreateAction( $newAction );
	
?>