<?php
	
	$newAction = array();
	$newAction[ "Name" ] = "Donate Credit";
	$newAction[ "SysName" ] = "credit";
	$newAction[ "Description" ] = "Gives a player credit that they can use on the donation page.";
	
	$amountArg = new Argument();
	$amountArg->DisplayName = "Credit";
	$amountArg->SysName = "credit_amount";
	$amountArg->Description = "How much credit should be given to the player?";
	$amountArg->PlaceHolder = "1.00";
	$amountArg->Type = ARG_TYPE::NUM;
	
	$newAction[ "ExecFunc" ] = function( $User, $ActionData ) {
		$User->ChangeValue( "Credit", ( $User->GetValue( "Credit" ) + $ActionData[ 0 ] ) );
		return false;
	};
	
	$newAction[ "Arguments" ] = array( $amountArg );
	Action::CreateAction( $newAction );
	
?>