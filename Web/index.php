<?php
	
	/********************************
	*	GMDonate Script by Hans		*
	*********************************/
	
	define( "GMDonate_Initialized", true );
	require_once( "includes/kernel.php" );
	
	KERNEL::LoadModule( "Database" );
	KERNEL::LoadModule( "DB_Accessor" );
	KERNEL::LoadModule( "SteamUtil" );
	KERNEL::LoadModule( "Setting" );
	KERNEL::LoadModule( "User" );
	KERNEL::LoadModule( "ItemCategory" );
	KERNEL::LoadModule( "Purchase" );
	KERNEL::LoadModule( "OpenID" );
	KERNEL::LoadModule( "Donation" );
	KERNEL::LoadModule( "Item" );
	KERNEL::LoadModule( "Action" );
	KERNEL::LoadModule( "ItemAction" );
	KERNEL::LoadModule( "UserAction" );
	KERNEL::LoadModule( "Servers" );
	KERNEL::LoadModule( "License" );
	
	KERNEL::AddPage( "home", "Home", true );
	KERNEL::AddPage( "store", "Store", true, null, function() {
		$btnHtm = '
			<li class="dropdown closed">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				  Store <span class="caret"></span>
				</a>
				
				<ul class="dropdown-menu">
		';
		
		foreach( ItemCategory::GetCachedResults( "ItemCategory" ) as $ItemCat ) {
			$btnHtm .= '<li><a href="?page=store&cat=' . $ItemCat->GetValue( "ID" ) . '">' . $ItemCat->GetValue( "Name" ) . '</a></li>';
		}
		
		return $btnHtm . '
				</ul>
			</li>
			
			<script>
				$( ".dropdown-toggle" ).dropdown();
			</script>
		';
	} );
	KERNEL::AddPage( "account", "Your Account", true, User::AccessCheck_LoggedIn() );
	KERNEL::AddPage( "donate", "Donate", true, User::AccessCheck_LoggedIn() );
	KERNEL::AddPage( "admin", "Admin", true, User::AccessCheck_Admin() );
	KERNEL::AddPage( "login", "Login", false );
	KERNEL::AddPage( "ipn", "Paypal IPN [Private]", false );
	KERNEL::AddPage( "error", "Error", false );
	
	KERNEL::SetDefaultPage( "home" );
	KERNEL::NavigatePage();
	
?>