<?php

	class SETTING_TYPE {
		const NUM = 1; // Number
		const STR = 2; // String
		const IMG = 3; // Image
		const HTM = 4; // HTML
		const YN = 5; // boolean
	}
	
	class Setting extends DB_Accessor {
		
		public static $SettingList = array();
		public static $TableName = "gmd_settings";
		
		public function GetValue() {
			if( $this->Data[ "Type" ] == SETTING_TYPE::NUM ) return floatval( $this->Data[ "Value" ] );
			if( $this->Data[ "Type" ] == SETTING_TYPE::STR ) return $this->Data[ "Value" ];
			if( $this->Data[ "Type" ] == SETTING_TYPE::IMG ) return ( "includes/images/uploaded/" . $this->Data[ "Value" ] );
			if( $this->Data[ "Type" ] == SETTING_TYPE::HTM ) return $this->Data[ "Value" ];
			if( $this->Data[ "Type" ] == SETTING_TYPE::YN ) return ( $this->Data[ "Value" ] == "1" )?( true ):( false );
			return false;
		}
		
		public function GenerateEditor() {
			if( $this->Data[ "Type" ] == 4 ) {
				return "";
			}
			
			$ReturnForm = '
				<div class="row">
					<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
						<b>' . $this->Data[ "DisplayName" ] .'</b>
					</div>
					
					<div class="col-sm-6 col-md-8" style="text-align: left;">
			';
			
			if( $this->Data[ "Type" ] == 1 )
				$ReturnForm .= '<input type="number" name="input_' . $this->Data[ "SysName" ] . '" class="form-control" value="' . $this->Data[ "Value" ] . '" style="' . $this->Data[ "Style" ] . '" />';
			elseif( $this->Data[ "Type" ] == 2 )
				$ReturnForm .= '<input type="text" name="input_' . $this->Data[ "SysName" ] . '" class="form-control" value="' . $this->Data[ "Value" ] . '" style="' . $this->Data[ "Style" ] . '" />';
			elseif( $this->Data[ "Type" ] == 3 )
				$ReturnForm .= '<input type="file" name="input_' . $this->Data[ "SysName" ] . '" />';
			elseif( $this->Data[ "Type" ] == 5 ) {
				$ReturnForm .= '
					<select name="input_' . $this->Data[ "SysName" ] . '" style="height: 34px;">
						<option value="1" ' . (($this->Data[ "Value" ] == true)?("selected"):("")) . '>Yes</option>
						<option value="0" ' . (($this->Data[ "Value" ] == false)?("selected"):("")) . '>No</option>
					</select>
				';
			}
			
			$ReturnForm .= '
					</div>
				</div>
				
				<br />
			';
			
			return $ReturnForm;
		}
		
		public static function QuickValue( $SettingName ) {
			return Setting::GetByField( "Setting", "SysName", $SettingName )->GetValue();
		}
	}
	
	// Because we are precaching, we must delete cache when it's updated..
	Setting::PrecacheAll( "Setting" );
	
?>