<?php

	$newAction = array();
	$newAction[ "Name" ] = "Pointshop 2";
	$newAction[ "SysName" ] = "pointshop2";
	$newAction[ "Description" ] = "Gives a player points in pointshop 2.";
	
	$pointsAmt = new Argument();
	$pointsAmt->DisplayName = "Points";
	$pointsAmt->SysName = "poins_amount";
	$pointsAmt->Description = "How many points should be given to the player?";
	$pointsAmt->PlaceHolder = "1000";
	$pointsAmt->Type = ARG_TYPE::NUM;
	
	$premAmt = new Argument();
	$premAmt->DisplayName = "Premium Points";
	$premAmt->SysName = "prempoins_amount";
	$premAmt->Description = "How many premium points should be given to the player?";
	$premAmt->PlaceHolder = "500";
	$premAmt->Type = ARG_TYPE::NUM;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $pointsAmt, $premAmt );
	Action::CreateAction( $newAction );

?>