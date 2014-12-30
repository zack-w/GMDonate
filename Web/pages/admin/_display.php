<div class="row">
	<div class="col-sm-6 col-md-3">
		<div class="list-group">
			<?php
				foreach( $AdminAreas as $SysName => $DisplayName ) {
					echo '<a href="?page=admin&area=' . $SysName . '" class="list-group-item disabled">' . $DisplayName . '</a>';
				}
			?>
		</div>
	</div>
	
	<div class="col-sm-6 col-md-9">
		<div class="panel panel-default">
			<?php
				if( empty( $_GET[ "area" ] ) || $AdminAreas[ $_GET[ "area" ] ] == null ) {
					require( "dashboard/_process.php" );
					require( "dashboard/_display.php" );
				} else {
					require( $_GET[ "area" ] . "/_process.php" );
					require( $_GET[ "area" ] . "/_display.php" );
				}
			?>
			
			<div class="panel-footer" style="font-size: 12px;"><b>Note:</b> If you are having issues or are confused, please read the <a href="?page=admin&area=manual">manual</a>.</div>
		</div>
	</div>
</div>
