<?php

	if( isset( $_POST[ "sendCredits" ] ) && Setting::QuickValue( "credittransfer" ) == true ) {
		$Amount = intval( str_replace( "$", "", $_POST[ "amount" ] ) );
		$ToSteam = $_POST[ "toSteam" ];
		
		if( $Amount == null || 0 >= $Amount || $Amount > User::$ActiveUser->GetValue( "Credit" ) ) {
			echo '
				<div class="alert alert-danger" role="alert">
					There was an error trying to transfer those credits...
				</div>
			';
		} else {
			$ToUser = User::GetByField( "User", "SteamID", $ToSteam );
			
			if( !isset( $ToUser ) || !$ToUser->IsReal() ) {
				echo '
					<div class="alert alert-danger" role="alert">
						No user was found with that SteamID!
					</div>
				';
			} else {
				User::$ActiveUser->AddCredit( -1 * $Amount );
				$ToUser->AddCredit( $Amount );
				
				echo '
					<div class="alert alert-success" role="alert">
						Sent $' . number_format( $Amount, 2 ) . ' to SteamID ' . $ToSteam . '
					</div>
				';
			}
		}
	}

?>