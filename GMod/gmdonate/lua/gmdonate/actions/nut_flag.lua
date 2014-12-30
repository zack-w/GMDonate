
local ACTION = GMD.Action:create( "nut_flag" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) && IsValid( User.GiveFlag ) )then
		User:ChatPrint( "[GMDonate] You have been given the flag '" .. ActionData[ 1 ] .. "'" );
		User:GiveFlag( ActionData[ 1 ] or "" );
		return false;
	end
end
