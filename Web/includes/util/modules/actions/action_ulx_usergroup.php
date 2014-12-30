<?php

	$newAction = array();
	$newAction[ "Name" ] = "GMod ULX Usergroup";
	$newAction[ "SysName" ] = "ulx_usergroup";
	$newAction[ "Description" ] = "Gives a player a ULX usergroup.";
	
	$usergroupArg = new Argument();
	$usergroupArg->DisplayName = "Usergroup";
	$usergroupArg->SysName = "usergroup";
	$usergroupArg->Description = "The name of the usergroup.";
	$usergroupArg->PlaceHolder = "operator";
	$usergroupArg->Type = ARG_TYPE::STR;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $usergroupArg );
	Action::CreateAction( $newAction );
	
?>