<?php

	if( isset( $_GET[ "delete" ] ) ) {
		Servers::GetByField( "Servers", "ID", intval( $_GET[ "delete" ] ) )->Delete();
	} elseif( isset( $_POST[ "addServer" ] ) ) {
		Servers::AddServer( $_POST[ "displayName" ], $_POST[ "serverIP" ], intval( $_POST[ "serverPort" ] ) );
	}
	
?>