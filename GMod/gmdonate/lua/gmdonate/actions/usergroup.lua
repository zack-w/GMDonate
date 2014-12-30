
local ACTION = GMD.Action:create( "usergroup" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) )then
		User:ChatPrint( "[GMDonate] Setting your usergroup to " .. ( ActionData[ 1 ] or "" ) );
		User:SetUsergroup( ActionData[ 1 ] or "" );
	end
end
