<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>GMDonate</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="includes/css/style.css" />
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#"></a>
			</div>
			<div class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
			  </ul>
			</div>
		  </div>
		</nav>
		
		<div class="mainPane">
			<?php
				if( User::$ActiveUser == false ) {
					echo '
						<div class="alert alert-info" role="alert">
							<b>Notice:</b> You are currently not signed in. Please "login with steam" to utilize the website.
						</div>
					';
				} else {
					/*echo '
						<div class="alert alert-danger" role="alert">
							<b>Notice:</b> This website is currently in development. You may experience issues.
						</div>
					';*/
				}
			?>
			
			<div>
				<div style="display: inline-block;height: 120px;text-align: right;float: right;">
					<?php
						if( User::$ActiveUser == false ) {
							// If they are not logged in, show a login button
							echo '
								<a href="?page=login">
									<img src="http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_large_noborder.png" />
								</a>
							';
						} else {
							echo '
								<div style="font-size: 12px;vertical-align: middle;margin-top: 20px;">
									Logged in as <b>' . User::$ActiveUser->Data[ "SteamID" ] . '</b> 
									<a href="?page=login&logout=yes">[Logout]</a>
									
									<br /><br />
									
									<a href="?page=donate" title="Your Balance. Click to add more.">
										<span class="cartButton">
											<img src="includes/images/money_dollar.png" />
											<span class="cartPrice" >' . number_format( (float) User::$ActiveUser->Data[ "Credit" ], 2, '.', '') . '</span>
										</span>
									</a>
								</div>
							';
						}
					?>
				</div>
				
				<a href='?'>
					<div style="display: inline-block;">
						<?php
							$BannerImg = Setting::GetByField( "Setting", "SysName", "banner" )->GetValue();
							echo "<img src='{$BannerImg}' />";
						?>
					</div>
				</a>
			</div>
			
			<br />
			
			<ul class="nav nav-tabs" role="tablist">
				<?php
					foreach( KERNEL::$Pages as $PageKey => $Page ) {
						if( $Page[ 1 ] !== false ) {
							if( !isset( $Page[ 3 ] ) )
								echo "<li><a href='?page=" . $PageKey . "'>" . $Page[ 0 ] . "</a></li>";
							else
								echo $Page[ 3 ]();
						}
					}
				?>
			</ul>
			
			<br /><br />
			
			<!--
			<a href="#" title="Buy now!">
				<span class="cartButton">
					<img src="includes/images/cart.png" />
					<span class="cartPrice" >12.00</span>
				</span>
			</a>
			-->