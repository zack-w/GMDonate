<?php

	$newAction = array();
	$newAction[ "Name" ] = "Pointshop";
	$newAction[ "SysName" ] = "pointshop";
	$newAction[ "Description" ] = "Gives a player points in pointshop.";
	
	$amountArg = new Argument();
	$amountArg->DisplayName = "Amount";
	$amountArg->SysName = "poins_amount";
	$amountArg->Description = "How many points should be given to the player?";
	$amountArg->PlaceHolder = "1000";
	$amountArg->Type = ARG_TYPE::NUM;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $amountArg );
	Action::CreateAction( $newAction );

?>