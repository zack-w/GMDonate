if( GMD.Actions == nil )then
	GMD.Actions = {};
end

GMD.Action = {};
GMD.Action.__index = GMD.Action;

function GMD.Action:create( SysName )
	local newAction = {};
	newAction[ "SysName" ] = SysName;
	setmetatable( newAction, GMD.Action );
	GMD.Actions[ SysName ] = newAction;
	return newAction;
end

function GMD.Action:give( User, ActionData )
	// to be overwritten
	// returning false will set the status to 0 (meaning inactive)
end

hook.Add( "PlayerInitialSpawn", "LoadGMDActions", function( User )
	// To let them settle in
	timer.Simple( 5, function()
		GMD.DB:QuickQuery( "SELECT * FROM `gmd_useractions` WHERE `UserData` = '" .. User:SteamID() .. "' AND `Status` = 1;", function( data )
			// Loop through all their actions
			for _, userAction in pairs( data ) do
				// Get the item action that they are recieving
				local itemAction = GMD[ "ItemActions" ][ userAction[ "ItemAction" ] ];
				
				if( itemAction != nil && GMD.Actions[ itemAction[ "ActionType" ] ] )then
					local keepActive = GMD.Actions[ itemAction[ "ActionType" ] ]:give( User, itemAction[ "ActionData" ] );
					
					// If the action tells us that it's a one time thing..
					if( keepActive == false )then
						GMD.DB:QuickQuery( "UPDATE `gmd_useractions` SET `Status` = 0 WHERE `ID` = " .. userAction[ "ID" ] .. ";" );
					end
				end
				
				hook.Call( "GMD_UserInitialized", nil, User );
			end
		end );
	end );
end );
