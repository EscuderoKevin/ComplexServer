<?php
	session_start();
	require_once '../../functions/class.user.sub.php';
	
	$user_home = new USER();
	
	
	if(!$user_home->is_logged_in())
	{
		$user_home->redirect('../../index.php');
	}
	
	$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['userSession']));
	$userdates = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$ts3 = $user_home->subconexts3();
	$count = $ts3->clientCount();
	$error = 0;
	if($count == 0){$error = 1;}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Client
			<small>List</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Client</a></li>
			<li class="active">List</li>
		</ol>
		<br />
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<?php if($error == 1){ ?>
					<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						¡Not Users Conected!
					</div>
					<?php }else{?>
					
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">Client List</h3>
						</div>
						<div class="box-body">
							<table id="userlist" class="table table-bordered table-striped">
								<center>
									<thead>
										<tr>
											<th>UID</th>
											<th>Name</th>
											<th>Plataform</th>
											<th>IP</th>
											<th>Connections</th>
											<th>Version</th>
											<th>Country</th>
										</tr>
									</thead>
									<tbody>
										
										<?php
											foreach($ts3->clientList() as $client)
											{
												if($client['client_type'] == 1) continue;
												echo "<tr>";
												echo "<td>".$client['client_unique_identifier']."</td>";
												echo "<td>".$client."</td>";
												echo "<td>".$client['client_platform']."</td>";
												echo "<td>".$client['connection_client_ip']."</td>";
												echo "<td>".$client['client_totalconnections']."</td>";
												echo "<td>".$client['client_version']."</td>";
												echo "<td>".$client['client_country']."</td>";
												echo "</tr>";
											}
										?>
									</center>
									
								</tbody>
							</table>
						</div>
					</div>
					
				<?php } ?>
			</div>
		</div>
	</section>
	
</div>
<?php include("../../desing/footer.php"); ?>																			