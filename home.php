<?php
	session_start();
	require_once 'functions/class.user.php';
	
	$user_home = new USER();
	
	
	if(!$user_home->is_logged_in())
	{
		$user_home->redirect('index.php');
	}
	
	$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['userSession']));
	$userdates = $stmt->fetch(PDO::FETCH_ASSOC);
	$error = 0;
	
	require_once('configs/settingsts3.php');
	require_once('libs/TeamSpeak3/TeamSpeak3.php');
	
	try	{
		$ts3_server = TeamSpeak3::factory("serverquery://".$ts3_user.":".$ts3_pass."@".$ts3_ip.":".$ts3_queryport."");
		$ts3 = $ts3_server->serverGetByPort($userdates['port']);
		$ts3->execute("clientupdate", array("client_nickname" => $ts3_queryname));
	}
	catch(TeamSpeak3_Exception $e)
	{
		$error = 1;
	}
	
?>
<?php include("desing/aside.php"); 
	if($error == 1){ ?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				ComplexServer
				<small>Dashboard</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box box-default">
							<div class="callout callout-warning">
								<h4>ERRROR!!!</h4>
								<p>Look , Your TS3 Server Its Stopped or Suspended.</p>
								<p>Please contact Administrator to Check This Error.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<?php }else{ ?>
	
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				ComplexServer
				<small>Dashboard</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</section>
		
		
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Server Quick Stats</h3>
						</div>
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>IP / PORT</th>
									<th>Name</th>
									<th>Slots</th>
									<th>Uptime</th>
								</tr>
								<tr>
									<td><a href="ts3server://<?php echo $ts3->getAdapterHost() ?>/?port=<?php echo $userdates['port'];?>&nickname=PanelTS3Worhost"><?php echo $ts3->getAdapterHost() ?>:<?php echo $userdates['port']; ?></td>
										<td><?php echo $ts3->virtualserver_name ?></td>
										<td><?php echo $ts3->virtualserver_clientsonline ?> / <?php echo $ts3->virtualserver_maxclients ?></td>
										<td><?php echo TeamSpeak3_Helper_Convert::seconds($ts3->virtualserver_uptime) ?></td>
									</tr>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="box">
				<table class="table table-bordered table-condensed f11 content-panel">
					<tr>
						<td colspan="2" align="center" class="info"><b>Account Info</b></td>
					</tr>
					<tr>
						<td width="35%"><b>User ID:</b></td>
						<td width="65%"><?php echo $userdates['userID'];?></td>
					</tr>
					<tr>
						<td width="35%"><b>Name:</b></td>
						<td width="65%"><?php echo $userdates['userName'];?></td>
					</tr>
					<tr>
						<td width="35%"><b>User Email:</b></td>
						<td width="65%"><?php echo $userdates['userEmail'];?></td>
					</tr>
					<tr>
						<td width="35%"><b>Server Port:</b></td>
						<td width="65%"><?php echo $userdates['port'];?></td>
					</tr>
					<tr>
						<td width="35%"><b>Server Slots:</b></td>
						<td width="65%"><?php echo $userdates['slots'];?></td>
					</tr>
					<tr>
						<td><b>Admin Access:</b></td>
						<td><?php echo ($userdates['admin'] == 1) ? 'Yes' : 'No';?></td>
					</tr>
					<tr>
						<td><b>Vip Access:</b></td>
						<td><?php echo ($userdates['vip'] == 1) ? 'Yes' : 'No - Get It <a href= "ordervip.php">Here</a>';?></td>
					</tr>
					<tr>
						<td width="35%"><b>Created:</b></td>
						<td width="65%"><?php echo $userdates['date'];?></td>
					</tr>
				</table>
			</div>
		</section>
	</div>
<?php } include("desing/footer.php"); ?>	