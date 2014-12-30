
local ACTION = GMD.Action:create( "pointshop" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) && User.PS_GivePoints )then
		User:ChatPrint( "[GMDonate] You have been given " .. (tonumber( ActionData[ 1 ] ) or 0) .. " Pointshop points." ); 
		User:PS_GivePoints( tonumber( ActionData[ 1 ] ) or 0 );
		return false;
	else
		User:ChatPrint( "[GMDonate] Unable to give pointshop points (unsupported by server)." );
	end
end
