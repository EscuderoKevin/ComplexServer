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
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Viewer</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Viewer</li>
			
		</ol>
		<br />
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Server Viewer!</h3>
			</div>
			<div class="box-body">
				<?php
					require_once("../../functions/tsstatus/tsstatus.php");
					require("../../configs/settingsts3.php");
					$tsstatus = new TSStatus($ts3_ip, 10011);
					$tsstatus->useServerPort($userdates['port']);
					$tsstatus->imagePath = "../../functions/tsstatus/img/";
					$tsstatus->timeout = 2;
					$tsstatus->setLoginPassword($ts3_user, $ts3_pass);
					$tsstatus->hideEmptyChannels = false;
					$tsstatus->hideParentChannels = false;
					$tsstatus->showNicknameBox = false;
					$tsstatus->showPasswordBox = false;
					echo $tsstatus->render();
				?>
			</div>
		</div>
	</section>
	
	
	<section class="content">
	</section>
</div>
<?php include("../../desing/footer.php"); ?>			