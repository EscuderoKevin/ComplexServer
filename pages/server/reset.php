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
	
	
	if (isset($_POST["reset"])) {
		
		if ($_POST["type"] == "server"){
			$new_ts3 = $user_home->CreateServer($ts3);
			$servername = $user_home->__servername;
			$token = $new_ts3[token];
		}
		
		if ($_POST["type"] == "perms"){
			$newtoken = $ts3->serverGetByPort($userdates['port'])->permReset();
		}
	}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Resets</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Resets</li>
			
		</ol>
		<br />
	</section>
	
	
	<section class="content">
		<?php if (isset($_POST["reset"])){
			
			if ($_POST["type"] == "server"){ ?>
			
			<div class="callout callout-success">
				<h4>Well done! , Your Server Are Reseted !</h4>
			</div>
			
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Server Reseted!</h3>
					
				</div>
				<div class="box-body">
					<dl>
						<dt>Server Name:</dt>
						<dd><?php echo $servername; ?></dd>
						<dt>New ServerAdmin Token:</dt>
						<dd><?php echo $token; ?></dd>
					</dl>
				</div>
				<div class="box-footer">
					<button  onclick="history.go(-1);" class="btn btn-info pull-right">Reload Page</button>
				</div>
			</div>
			
			
			<?php }if ($_POST["type"] == "perms"){ ?>
			
			<div class="callout callout-success">
				<h4>Well done! , Your Server Permissions Are Reset! !</h4>
				<h4> New Token: <?php echo $newtoken; ?> </h4>
				<h3> Copy New Token - Redirecting...... </h3>
				<meta http-equiv="refresh" content="20">
			</div>
			
		<?php } }else{ ?>
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Server Resets!</h3>
				
			</div>
			<div class="box-body">
				<form role="form" method="post">
					<!-- text input -->
					<div class="form-group">
						<label>Select What Its You Like</label>
						<h2> THIS SELECT NOT HAVE WAY TO BACK! TAKE CARE !!!!! </h2>
						<select name="type" class="form-control">
							<option disabled="disabled">Select Here</option>
							<option disabled="disabled">There is no way back</option>
							<option value="server">Reset SERVER</option>
							<option value="perms">Reset Permissions</option>
						</select>
					</div>
					<div class="box-footer">
						<button type="submit" name="reset" class="btn btn-info pull-right">Reset</button>
					</div>
				</form>
			</div>
		<?php } ?>
		</div>
	</section>
</div>
<?php include("../../desing/footer.php"); ?>			