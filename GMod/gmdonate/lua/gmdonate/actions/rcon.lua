
local ACTION = GMD.Action:create( "rcon" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) )then
		local cmd = ActionData[ 1 ];
		cmd = string.Replace( cmd, "**s", User:SteamID() );
		cmd = string.Replace( cmd, "**u", tostring( User:UserID() ) );
		cmd = string.Replace( cmd, "**n", User:Nick() );
		game.ConsoleCommand( cmd .. "\n" );
		return false;
	end
end
