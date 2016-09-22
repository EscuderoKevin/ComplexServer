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
	
	if(isset($_POST['send'])) {
		$message = $_POST['message'];
		$ts3->message("[b][color=green]".$message."[/color][/b]   [COLOR=#ff0000] Send By WebPanel.[/COLOR]");    
	}
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Message</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Message</li>
		</ol>
		<br />
	</section>
	
	<section class="content">
		
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Server Message!</h3>
			</div>
			<? if(isset($_POST['send'])) { ?>
				
				<div class="callout callout-success">
					<h4>Well done! , Message Send successfully!</h4>
					<p>You will be redirected where you were!.</p>
				</div>
				<meta http-equiv="refresh" content="5">
				
				<?}else{ ?>
				<div class="box-body">
					<div class="form-panel">
						<form class="form-horizontal style-form" role="form" method="post">
							<div class="form-group">
								<label class="sr-only">Message</label>
								<div class="col-sm-10">
									<input type="text" class="form-control round-form" placeholder="Message..." name="message">
								</div>
							</div>
							<button type="submit" name="send" class="btn btn-theme">Send Message</button>
						</form>
					</div>
				<? } ?>
			</div>
		</div>
	</section>
</div>
<?php include("../../desing/footer.php"); ?>																						