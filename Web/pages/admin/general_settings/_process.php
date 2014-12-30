<?php

	if( isset( $_POST[ "settings_updated" ] ) ) {
		foreach( Setting::GetCachedResults( "Setting" ) as $SettingObj ) {
			
			if( $SettingObj->Data[ "Type" ] == 1 || $SettingObj->Data[ "Type" ] == 2 || $SettingObj->Data[ "Type" ] == 4 || $SettingObj->Data[ "Type" ] == 5 ) {
				// See if the value was updated then save it in the DB
				if( isset( $_POST[ "input_" . $SettingObj->Data[ "SysName" ] ] ) ) {
					$SettingObj->ChangeValue( "Value", $_POST[ "input_" . $SettingObj->Data[ "SysName" ] ] );
				}
			}
			
			if( $SettingObj->Data[ "Type" ] == 3 ) {
				if( isset( $_FILES[ "input_" . $SettingObj->Data[ "SysName" ] ] ) ) {
					$File = $_FILES[ "input_" . $SettingObj->Data[ "SysName" ] ];
					$FileExtension = end( explode( ".", $File[ "name" ] ) );
					$FileType = $File[ "type" ];
					$FileSize = $File[ "size" ];
					
					if( 75000 < $FileSize ) {
						// Too Big
					} elseif( $FileType != "image/png" && $FileType != "image/jpg" && $FileType != "image/jpeg" ) {
						// Bad Type
					} elseif( $FileExtension != "png" && $FileExtension != "jpg" && $FileExtension != "jpeg" ) {
						// Bad Extension
					} else {
						$NewName = md5( rand() );
						move_uploaded_file( $File[ "tmp_name" ], "includes/images/uploaded/" . $NewName . "." . $FileExtension );
						@unlink( $SettingObj->GetValue() );
						$SettingObj->ChangeValue( "Value", $NewName . "." . $FileExtension );
						echo '<meta http-equiv="refresh" content="1">';
					}
				}
			}
		}
	}

?>