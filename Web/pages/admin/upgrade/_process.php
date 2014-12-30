<?php

	if( isset( $_POST[ "doUpgradeTxt" ] ) ) {
		$updateTxt = $_POST[ "upgradeCmd" ];
		$updateCmds = explode( "\n", $updateTxt );
		
		foreach( $updateCmds as $cmd ) {
			if( !empty( $cmd ) ) {
				Database::$DB->query( $cmd );
			}
		}
		
		echo '
			<div class="alert alert-success" role="alert" style="margin-bottom: 0;">
				Update command ran successfully!
			</div>
		';
	}
	
?>