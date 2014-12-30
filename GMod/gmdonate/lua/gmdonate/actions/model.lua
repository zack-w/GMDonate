
local ACTION = GMD.Action:create( "model" );

function ACTION:give( User, ActionData )
	if( IsValid( User ) )then
		User:ChatPrint( "[GMDonate] Setting your model to " .. ActionData[ 1 ] );
		User:SetModel( ActionData[ 1 ] );
		User.GMD_PermModel = ActionData[ 1 ];
	end
end

hook.Add( "PlayerSpawn", "GMD_PermModel", function( User )
	if( User.GMD_PermModel != nil )then
		User:SetModel( User.GMD_PermModel );
	end
end );
