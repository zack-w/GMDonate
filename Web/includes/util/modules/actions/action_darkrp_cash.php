<?php

	$newAction = array();
	$newAction[ "Name" ] = "DarkRP Cash";
	$newAction[ "SysName" ] = "darkrp_cash";
	$newAction[ "Description" ] = "Gives a player DarkRP cash.";
	
	$amountArg = new Argument();
	$amountArg->DisplayName = "Amount";
	$amountArg->SysName = "cash_amount";
	$amountArg->Description = "How much money should be given to the player?";
	$amountArg->PlaceHolder = "125000";
	$amountArg->Type = ARG_TYPE::NUM;
	
	$newAction[ "ExecFunc" ] = function( $User, $ActionData ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $amountArg );
	Action::CreateAction( $newAction );
	
?>