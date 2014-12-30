
local ACTION = GMD.Action:create( "pointshop2" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) && Pointshop2Controller )then
		-- Give them the regular points
		User:ChatPrint( "[GMDonate] You have been given " .. (tonumber( ActionData[ 1 ] ) or 0) .. " Pointshop 2 points." ); 
		Pointshop2Controller:addToPlayerWallet( User, "points", tonumber( ActionData[ 1 ] ) or 0 );
		
		-- Give them the premium points
		User:ChatPrint( "[GMDonate] You have been given " .. (tonumber( ActionData[ 2 ] ) or 0) .. " Pointshop 2 premium points." ); 
		Pointshop2Controller:addToPlayerWallet( User, "premiumPoints", tonumber( ActionData[ 2 ] ) or 0 );
		
		-- Remove the user action
		return false;
	else
		User:ChatPrint( "[GMDonate] Unable to give pointshop 2 points (unsupported by server)." );
	end
end
