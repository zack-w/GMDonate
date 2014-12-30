<div style="padding: 18px;">
	<h3>GMDonate Manual</h3>
	<hr />
	
	<b>I. Introduction</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		GMDonate is a highly advanced donation system that is built with the ability
		to scale very large communities. I put a lot of time into developing this manual so that it covers most
        aspects of the system, but I may have missed some things. If you have a question that isn't answered by this manual, I recommend you make a ticket on <a href="http://coderhire.com/">CoderHire</a>.
	</div>
	
	<br />
	
	<b>II. Users & Authentication</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		I made the user and authentication simple because I don't expect the users (donators) to be looking
		at this page for too long. The whole point is to make the process quick and easy. I added other features such as
		viewing transaction history, but other than that, it should still be a quick process. Currently,
		the only way to login is by using a Steam Account, which prevents the user from having to register an account.
	</div>
	
	<br />
	
	<b>III. Donation Process</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		<ol>
			<li>Login to the website with the "Login with Steam" button</li>
			<li>Click on the "balance" button under the user's SteamID</li>
			<li>Select the desired donation amount</li>
			<li>Go through the PayPal process</li>
			<li>Return to the shop and select the desired item</li>
            <li>(Action Executed)</li>
			<li>User recieves the item</li>
		</ol>
	</div>
	
	<br />
	
	<b>IV. Actions</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		An action is something that ties into an item/product that executes a command when someone purchases an item. An action basically
		automatically gives the person their desired item, so an example action is "give DarkRP cash" or "set forum usergroup". You can tie multiple
		actions to a single item that will execute when someone donates. This is the most powerful feature of the donation system, because it
        introduces complete customization of the automated system. <b>NOTE:</b> Server MUST be restarted for actions to take effect on an item.
	</div>
	
	<br />
	
	<b>V. Servers</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		Another major feature of this donation system is that it separates servers. You can add a server by it's IP and Port.
		When adding an action to an item, you can specify that action to only execute on a specific server. For example, if you have a
		DarkRP and TTT server, you wouldn't want to run the action Give DarkRP Cash on the TTT server. <b>NOTE:</b> It is important to make sure you
		don't have any actions running on servers that shouldn't be, as it may cause errors and break the server.
	</div>
	
	<br />
	
	<b>VI. GMod ULX & Usergroup Actions</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		So there are two different actions that both set usergroups, the ULX Usergroup and then the GMod Generic Usergroup. If you are using ULX and wish to give someone
		a usergroup when they donate, use the ULX Usergroup. The other usergroup is for <b>other admin mods besides ULX</b> though <b>it may not work</b>. If you attempt to
		set a usergroup using the generic usergroup (not ULX) then it <b>may overwrite an existing usergroup</b>. If you are having issues make a ticket on CoderHire and 
		I will look at it but <b>only ULX is assured to work</b>.
	</div>
	
	<br />
	
	<b>VII. Nutscript Flags</b>
	<div style="padding: 4px 0px 0px 18px;width: 500px;">
		Nutscript has a series of built in flags (listed below). You can also create your own flags that will work. Each flag is a single letter in Nutscript.
		
		<br /><br />
		
		<table class="table table-condensed" style="font-size: 12px;">
			<thead style="border: 1px solid #BBB;background-color: #EEE;font-weight: bold;">
				<td style="text-align: center;">Flag</td>
				<td>Description</td>
			</thead>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">p</td>
				<td>Gives the player access to a physgun.</td>
			</tr>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">t</td>
				<td>Gives the player access to a toolgun.</td>
			</tr>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">n</td>
				<td>Gives the player access to spawn NPCs.</td>
			</tr>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">r</td>
				<td>Gives the player access to spawn ragdolls.</td>
			</tr>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">c</td>
				<td>Gives the player access to spawn vehicles.</td>
			</tr>
			
			<tr style="border: 1px solid #BBB;">
				<td style="text-align: center;">e</td>
				<td>Gives the player access to spawn objects.</td>
			</tr>
		</table>
	</div>
</div>