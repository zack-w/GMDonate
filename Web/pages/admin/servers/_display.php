<div style="padding: 20px;">
	<table class="table" style="font-size: 13px;">
		<thead>
			<th style="width: 35%;">Display Name</th>
			<th style="width: 25%;">Server IP</th>
			<th style="width: 20%;">Port</th>
			<th style="text-align: right;width: 20%;">Actions</th>
		</thead>
		
		<tbody>
			<?php
				$Servers = Servers::GetCachedResults( "Servers" );
				
				if( count( $Servers ) == 0 ) {
					echo "
						<tr>
							<td colspan='3' style='text-align: center;padding: 12px;font-size: 12px;'>
								<i>There are no servers to display!</i>
							</td>
						</tr>
					";
				} else {
					foreach( $Servers as $Server ) {
						echo "
							<tr>
								<td>" . $Server->GetValue( "Name" ) . "</td>
								<td>" . $Server->GetValue( "IP" ) . "</td>
								<td>" . $Server->GetValue( "Port" ) . "</td>
								<td style='text-align: right;'>
									<a href='?page=admin&area=servers&delete=" . $Server->GetValue( "ID" ) . "'><span class='btn btn-xs btn-danger'>Delete</span></a>
								</td>
							</tr>
						";
					}
				}
			?>
		</tbody>
	</table>

	<br />
	
	<form class="form-inline" method="POST" action="?page=admin&area=servers">
		<input type="hidden" name="addServer" value="yes" />
		<input type="text" name="displayName" class="form-control" style="height: 28px;width: 150px;" placeholder="Display Name" required /> 
		<input type="text" name="serverIP" class="form-control" style="height: 28px;width: 150px;" placeholder="IP Address" required /> <b>:</b>
		<input type="text" name="serverPort" class="form-control" style="height: 28px;width: 70px;" placeholder="Port" required />
		<input type="submit" value="Add" class="btn btn-xs btn-success" />
	</form>
</div>