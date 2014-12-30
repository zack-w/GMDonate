
local ACTION = GMD.Action:create( "permweapon" );
GMD.PermWeaponHolders = {};

function GMD.GivePermWeapons( User )
	if( GMD.PermWeaponHolders[ User:SteamID() ] != nil )then
		for _, PermWepData in pairs( GMD.PermWeaponHolders[ User:SteamID() ] ) do
			User:Give( PermWepData[ 1 ] or "" );
		end
	end
end

function ACTION:give( User, ActionData, ActionDateEffective )
	if( GMD.PermWeaponHolders[ User:SteamID() ] == nil )then
		GMD.PermWeaponHolders[ User:SteamID() ] = {};
	end
	
	local userTable = ( GMD.PermWeaponHolders[ User:SteamID() ] == nil ) and ( {} ) or ( GMD.PermWeaponHolders[ User:SteamID() ] );
	userTable[ #userTable + 1 ] = { ActionData[ 1 ], ActionData[ 2 ] };
	
	// See if it expired yet
	if( tonumber( ActionData[ 2 ] ) != 0 && os.time() > ( tonumber( ActionData[ 2 ] ) * 1440 + ActionDateEffective ) )then
		User:ChatPrint( "[GMD] Notice, your permanent weapon (" .. ActionData[ 1 ] .. ") has expired." );
		return false;
	else
		User:ChatPrint( "[GMD] Loaded permanent weapon (" .. ActionData[ 1 ] .. ")" );
		GMD.PermWeaponHolders[ User:SteamID() ] = userTable;
	end
end

hook.Add( "PlayerSpawn", "GivePermWeapon", GMD.GivePermWeapons );
hook.Add( "GMD_UserInitialized", "GivePermWeapon", GMD.GivePermWeapons );
