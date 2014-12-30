
/*
	I chose to use a MySQL database rather than using HTTP simply because HTTP
	can be extremely unreliable. The only downside is that you need to install a
	DLL on the server but it is worth it because of the stability it has.
*/

require( "mysqloo" );

GMD.DB = {};
GMD.DB.Obj = mysqloo.connect( GMD.Config[ "DB_Host" ], GMD.Config[ "DB_Username" ], GMD.Config[ "DB_Password" ], GMD.Config[ "DB_Name" ], GMD.Config[ "DB_Port" ] );

function GMD.DB:QuickQuery( QueryStr, Callback, HoldThread )
	local queryObj = GMD.DB.Obj:query( QueryStr );
	
	function queryObj:onSuccess( data )
		if( Callback )then
			Callback( data );
		end
	end
	
	function queryObj:onError( err, cmd )
		MsgC( Color( 255, 0, 0 ), "GMDonate mysql query failed! " .. err .. "\n" );
	end
	
	queryObj:start();
	
	if( HoldThread )then
		queryObj:wait();
	end
end

function GMD.DB.Obj:onConnected()
	timer.Create( "GMD_NoTimeout", 5, 0, function()
		GMD.DB:QuickQuery( "SELECT 1 + 1;" );
	end );
	
	hook.Call( "GMD_Initialized", nil );
end

function GMD.DB.Obj:onConnectionFailed( err )
	MsgC( Color( 255, 0, 0 ), "GMDonate disabled.. unable to connect to database!\n" );
end

GMD.DB.Obj:connect();
GMD.DB.Obj:wait();
