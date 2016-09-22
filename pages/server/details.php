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
	
	if (isset($_POST["save"])) {
		
		
    	$svname = $_POST["svname"];
		$slots = $_POST["slots"];
		$rslots = $_POST["rslots"];
		$port = $_POST["port"];
		
		$wmessage = $_POST["wmessage"];
		$hmessage = $_POST["hmessage"];
		
		$hostbanner = $_POST["hostbanner"];
		$hostbannerurl = $_POST["hostbannerurl"];
		
		$hostbutton = $_POST["hostbutton"];
		$hostbuttonurl = $_POST["hostbuttonurl"];
		$hostbuttontool = $_POST["hostbuttontool"];
		
		
		
		try{
			$ts3[virtualserver_name] = $svname;
			$ts3[virtualserver_maxclients] = $slots;
			$ts3[virtualserver_reserved_slots] = $rslots;
			
			$ts3[virtualserver_welcomemessage] = $wmessage;
			
			$ts3[virtualserver_hostbanner_url] = $hostbannerurl;
			$ts3[virtualserver_hostbanner_gfx_url] = $hostbanner;
			
			$ts3[virtualserver_hostbutton_tooltip] = $hostbuttontool;
			$ts3[virtualserver_hostbutton_url] = $hostbutton;
			$ts3[virtualserver_hostbutton_gfx_url] = $hostbuttonurl;
			
		}
		catch(TeamSpeak3_Exception $e)
		{
			echo "Error " . $e->getCode() . ": " . $e->getMessage();
		}
		
	}
	
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Edit Details</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Edit Details</li>
		</ol>
	</section>
	
	
	<section class="content">
		<?php if (isset($_POST["save"])){?>
			
			<div class="callout callout-success">
				<h4>Well done! , All your changes were made successfully!</h4>
				<p>You will be redirected where you were!.</p>
			</div>
			<meta http-equiv="refresh" content="5">
			
			<?}else{ ?>
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Server Details!</h3>
					
				</div>
				<div class="box-body">
					<form role="form" method="post">
						<!-- text input -->
						<div class="form-group">
							<label>Server Name</label>
							<input type="text" name="svname" class="form-control" value="<?php echo $ts3->virtualserver_name ?>">
						</div>
						<div class="form-group">
							<label>Server Port</label>
							<input type="text" name="port" class="form-control" disabled value=<?php echo $userdates['port']; ?>>
						</div>
						<div class="form-group">
							<label>Server Slots</label>
							<input type="text" name="slots" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value=<?php echo $userdates['slots']; ?>>
						</div>
						<div class="form-group">
							<label>Reserved Slots</label>
							<input type="text" name="rslots" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value=<?php echo $ts3->virtualserver_reserved_slots ?>>
						</div>
						<div class="form-group">
							<label>Welcome Message</label>
							<input type="textarea" name="wmessage" class="form-control" value="<?php echo $ts3->virtualserver_welcomemessage ?>">
						</div>
						<div class="form-group">
							<label>Host Message (Only Modal)</label>
							<input type="text" name="hmessage" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostmessage ?>">
						</div>
						<div class="form-group">
							<label>Host Banner</label>
							<input type="text" name="hostbanner" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostbanner_gfx_url ?>">
						</div>
						<div class="form-group">
							<label>Host Banner URL</label>
							<input type="text" name="hostbannerurl" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostbanner_url ?>">
						</div>
						<div class="form-group">
							<label>Host Button</label>
							<input type="text" name="hostbutton" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostbutton_gfx_url ?>">
						</div>
						<div class="form-group">
							<label>Host Button URL</label>
							<input type="text" name="hostbuttonurl" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostbutton_url ?>">
						</div>
						<div class="form-group">
							<label>Host Button Tooltip</label>
							<input type="text" name="hostbuttontool" class="form-control" <?php if($userdates['vip'] == 0 && $userdates['admin'] == 0){ ?> disabled <?php } ?> value="<?php echo $ts3->virtualserver_hostbutton_tooltip ?>">
						</div>
						
						<div class="box-footer">
							<button type="submit" onClick="window.location.reload()" class="btn btn-default">Reload Values</button>
							<button type="submit" name="save" class="btn btn-info pull-right">Save New Values</button>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</section>
</div>
<?php include("../../desing/footer.php"); ?>							