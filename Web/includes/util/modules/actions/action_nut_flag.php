<?php

	$newAction = array();
	$newAction[ "Name" ] = "Nutscript Flag";
	$newAction[ "SysName" ] = "nut_flag";
	$newAction[ "Description" ] = "Gives a player a nutscript flag. See manual for list of flags.";
	
	$flagLetter = new Argument();
	$flagLetter->DisplayName = "Flag Letter";
	$flagLetter->SysName = "flag_letter";
	$flagLetter->Description = "This is the letter of the flag to be given to the player.";
	$flagLetter->PlaceHolder = "n";
	$flagLetter->Type = ARG_TYPE::STR;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $flagLetter );
	Action::CreateAction( $newAction );
	
?>