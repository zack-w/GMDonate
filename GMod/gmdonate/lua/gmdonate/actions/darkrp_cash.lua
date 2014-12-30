local ACTION = GMD.Action:create( "darkrp_cash" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) && User.addMoney )then
		User:ChatPrint( "[GMDonate] You have been given $" .. (tonumber( ActionData[ 1 ] ) or 0) );
		User:addMoney( tonumber( ActionData[ 1 ] ) or 0 );
		return false;
	else
		User:ChatPrint( "[GMDonate] Unable to give you RP cash, server doesn't support it!" );
	end
end
