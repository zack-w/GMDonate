
function GMD:InitServer()
	local ServerIP, Port = GetConVarString( "ip" ), GetConVarNumber( "hostport" );

	for ServerID, ServerRow in pairs( GMD.Servers ) do
		if( ServerIP == ServerRow[ "IP" ] and tonumber( Port ) == tonumber( ServerRow[ "Port" ] ) )then
			GMD[ "ServerID" ] = ServerID;
			GMD.DB.Initialized = true;
		end
	end
	
	if( GMD.DB.Initialized == true )then
		MsgC( Color( 0, 255, 0 ), "GMDonate has initialized with ServerID " .. GMD[ "ServerID" ] .. "\n" );
	else
		MsgC( Color( 255, 0, 0 ), "GMDonate could not initialize on " .. ServerIP .. ":" .. Port .. "!\n" );
	end
end

GMD.DB:QuickQuery( "SELECT * FROM `gmd_servers`;", function( data )
	for _, ServerRow in pairs( data ) do
		GMD[ "Servers" ][ ServerRow.ID ] = ServerRow;
	end
	
	GMD:InitServer();
end, true );

GMD.DB:QuickQuery( "SELECT * FROM `gmd_itemactions`;", function( data )
	for _, ItemAction in pairs( data ) do
		local activeServers = string.Explode( ";", ItemAction[ "Servers" ] or "" );
		
		// Only add it if it's active on this server
		for _, ActiveServerID in pairs( activeServers ) do
			ActiveServerID = tonumber( ActiveServerID );
			
			if( ActiveServerID == GMD[ "ServerID" ] )then
				MsgC( Color( 0, 255, 0 ), "[GMD] Loaded ItemAction #" .. ItemAction[ "ID" ] .. "\n" );
				GMD[ "ItemActions" ][ ItemAction.ID ] = {
					[ "ID" ] = ItemAction[ "ID" ],
					[ "ItemID" ] = ItemAction[ "ItemID" ],
					[ "ActionType" ] = ItemAction[ "ActionType" ],
					[ "ActionData" ] = string.Explode( "|;|", ItemAction[ "ActionData" ] ),
					[ "Servers" ] = string.Explode( ";", ItemAction[ "Servers" ] )
				};
			end
		end
	end
end, true );
