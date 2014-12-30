<?php
	
	/*
		An Example Action
		--------------------
		Name: Give DarkRP Money
		SysName: darkrp_cash
		Description: Gives a user DarkRP Money
		Arguments:
			{
				Name: Amount
				SysName: cash_amount
				Description: The amount of money to give the player
				Type: Number
			}
	*/
	
	class ARG_TYPE {
		const NUM = 1; // A number
		const STR = 2; // A string
	}
	
	class Argument {
		public $DisplayName = "Unknown";
		public $SystemName = "unknown";
		public $Description = "No description.";
		public $PlaceHolder = "";
		public $Type = 0;
		
		public function GenerateEditor( $Value = "" ) {
			$Value = ( $Value == "" )?( "placeholder='{$this->PlaceHolder}'" ):( "value='{$Value}'" );
			
			$ReturnForm = '
				<div class="row">
					<div class="col-sm-6 col-md-4" style="text-align: right;line-height: 34px;">
						<span style="border-bottom: 1px dashed #AAA;" rel="tooltip" data-toggle"tooltip" data-placement="bottom" title="' . $this->Description . '">
							<b>' . $this->DisplayName .'</b>
						</span>
					</div>
					
					<div class="col-sm-6 col-md-8" style="text-align: left;">
			';
			
			if( $this->Type == 1 )
				$ReturnForm .= '<input type="text" name="input_' . $this->SysName . '" class="form-control" ' . $Value . ' style="width: 120px;" />';
			elseif( $this->Type == 2 )
				$ReturnForm .= '<input type="text" name="input_' . $this->SysName . '" class="form-control" ' . $Value . ' style="width: 280px;" />';
				
			$ReturnForm .= '
					</div>
				</div>
				
				<br />
				
				<script type="text/javascript">
					$(function () {
						$("[rel=\'tooltip\']").tooltip( {
							"selector": "",
							"placement": "top",
							"container":"body"
						} );
					});
				</script>
			';
			
			return $ReturnForm;
		}
	}
	
	class Action {
		public static $ActionList = array();
		
		public static function CreateAction( $ActionData ) {
			self::$ActionList[ $ActionData[ "SysName" ] ] = $ActionData;
		}
		
		public static function GetAction( $ActionName ) {
			return self::$ActionList[ $ActionName ];
		}
		
		public static function LoadActions() {
			foreach ( glob( "includes/util/modules/actions/*.php" ) as $ActionFile ) {
				require $ActionFile;
			}
		}
	}
	
	Action::LoadActions();
	
?>