<?php
	
	$newAction = array();
	$newAction[ "Name" ] = "Permanent Weapon";
	$newAction[ "SysName" ] = "permweapon";
	$newAction[ "Description" ] = "Gives a player this weapon every time they spawn.";
	
	$weaponArg = new Argument();
	$weaponArg->DisplayName = "Weapon Class";
	$weaponArg->SysName = "weapon_class";
	$weaponArg->Description = "What is the weapon class such as weapon_physgun?";
	$weaponArg->PlaceHolder = "weapon_rpg";
	$weaponArg->Type = ARG_TYPE::STR;
	
	$expirationArg = new Argument();
	$expirationArg->DisplayName = "Expiration";
	$expirationArg->SysName = "weapon_length";
	$expirationArg->Description = "How many days should they be given this permanent weapon for? Enter 0 to give it forever.";
	$expirationArg->PlaceHolder = "30";
	$expirationArg->Type = ARG_TYPE::NUM;
	
	$newAction[ "ExecFunc" ] = function( $User, $Donation ) {
		// This action does nothing when executed
	};
	
	$newAction[ "Arguments" ] = array( $weaponArg, $expirationArg );
	Action::CreateAction( $newAction );
	
?>