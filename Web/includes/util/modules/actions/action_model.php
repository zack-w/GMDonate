<?php

	$newAction = array();
	$newAction[ "Name" ] = "Set Player Model";
	$newAction[ "SysName" ] = "model";
	$newAction[ "Description" ] = "Sets a players model every time they spawn.";
	
	$modelArg = new Argument();
	$modelArg->DisplayName = "Model Name";
	$modelArg->SysName = "usergroup";
	$modelArg->Description = "The class name of the model.";
	$modelArg->PlaceHolder = "models/player/Group01/Female_01.mdl";
	$modelArg->Type = ARG_TYPE::STR;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $modelArg );
	Action::CreateAction( $newAction );
	
?>