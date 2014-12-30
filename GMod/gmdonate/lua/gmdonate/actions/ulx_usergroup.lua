
local ACTION = GMD.Action:create( "ulx_usergroup" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) && ULib && ULib.ucl )then
		User:ChatPrint( "[GMDonate] Your ULX rank has been set to " .. ( ActionData[ 1 ] or "" ) );
		ULib.ucl.addUser( User:SteamID(), allows, denies, ( ActionData[ 1 ] or "" ) );
		return false;
	else
		User:ChatPrint( "[GMDonate] Unable to set ULX rank on this server." );
	end
end
