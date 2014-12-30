<div style="padding: 18px;">
	<h3>Upgrading</h3>
	<hr />
	
	Since I plan on doing updates frequently, here are some instructions on how to properly upgrade.
	<br />
	<i style="font-size: 11px;">Note: These instructions are tailored for <a href="https://filezilla-project.org/download.php?type=client">FileZilla</a></i>
	
	<br /><br />
	
	<b>Web Upgrade</b>
	<ol style="font-size: 12px;">
		<li>Open FileZilla and connect to your web FTP server, then navigate to your donation directory</li>
		<li>Copy your config.php for later, unless the revision notes say otherwise</li>
		<li>Open the zip file you download and then drag everything into web into your FTP directory</li>
		<li>A window will shortly popup, select "Overwrite" and then check "Always use this action"</li>
		<li>Open the config.txt and paste the config you copied earlier so you dont need to reenter your config</li>
		<li>Copy the text from UpdateConfig.txt and paste it in the box below <b style="color: darkred;">only if this is an upgrade, not an install</b></li>
	</ol>
	
	<br /><br />
	
	<b>GMod Addon Upgrade</b>
	<ol style="font-size: 12px;">
		<li>Open FileZilla and connect to your web FTP server</li>
		<li>Open the zip file you download and then drag everything into GMod into your FTP directory</li>
		<li>A window will shortly popup, select "Overwrite" and then check "Always use this action"</li>
		<li>Reenter your database information into the init.lua file</li>
	</ol>
	
	<br /><br />
	
	<b>UpdateConfig.txt</b> - Put the contents of UpdateConfig.txt here, then hit execute
	
	<div style="margin-left: 20px;">
		<form method="POST" action="?page=admin&area=upgrade">
			<input type="hidden" name="doUpgradeTxt" value="yes" />
			<textarea name="upgradeCmd" class="form-control" style="width: 600px;height: 200px;"></textarea>
			<br />
			<input type="submit" class="btn btn-sm btn-primary" value="Execute" />
		</form>
	</div>
</div>
	