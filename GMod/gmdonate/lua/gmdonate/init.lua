
/*
	READ: The config information below should match that in the GMDonate/includes/config.php
	NOTE: Only change the config info below, NOTHING ELSE!
*/

GMD = {
	[ "VERSION" ] = "R5",
	[ "ServerID" ] = 0,
	[ "Initialized" ] = false,
	[ "Servers" ] = {},
	[ "ItemActions" ] = {},
	[ "Config" ] = {
		//****** ONLY CHANGE BELOW THIS LINE ******\\
			DB_Host = "",
			DB_Username = "",
			DB_Password = "",
			DB_Name = "",
			DB_Port = 3306,
		//****** ONLY CHANGE ABOVE THIS LINE ******\\
	},
};

MsgC( Color( 0, 255, 0 ), "GMDonate " .. GMD.VERSION .. " loaded!\n" );

include( "kernel/db.lua" );
include( "kernel/action.lua" );
include( "kernel/kernel.lua" );

include( "actions/darkrp_cash.lua" );
include( "actions/permweapon.lua" );
include( "actions/model.lua" );
include( "actions/nut_flag.lua" );
include( "actions/rcon.lua" );
include( "actions/ulx_usergroup.lua" );
include( "actions/usergroup.lua" );
include( "actions/pointshop.lua" );
include( "actions/pointshop2.lua" );
