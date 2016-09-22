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
	
	if(isset($_POST['message'])) {
		
		$message = $_POST['msg'];
		$client = $_POST['client'];
		$ts3->clientGetByName($client)->message($message);
	}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Client
			<small>Message</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Client</a></li>
			<li class="active">Message</li>
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
							<h3 class="box-title">Client Message</h3>
						</div>
						<div class="box-body">
							<?php if(isset($_POST['message'])) { ?>	
								<div class="alert alert-success"><b>Good!</b> Message Sended. Reloading page</div>
								<meta http-equiv="refresh" content="3" >
								
								<?php }else{?>
								<form role="form" method="post" >
									<div class="form-group">
										<label>Select Client.</label>
										<select class="form-control" name="client">
											<?php 
												
												foreach($ts3->clientList() as $tsclient) {
													if($tsclient['client_type'] == 1) continue;
													echo"<option value=$tsclient>".$tsclient."</option>";
												}
											?>
										</select>
									</div>
									<input type="text" class="form-control" name="msg" placeholder="Message">
									<div class="box-footer">
										<button type="submit" onClick="window.location.reload()" class="btn btn-default">Reload List</button>
										<button type="submit" name="message" class="btn btn-default pull-right">Send Message</button>
									</div>
								</form>
							<?php } ?>
						</div>
					</div>
					
				<?php } ?>
			</div>
		</div>
	</section>
	
</div>
<?php include("../../desing/footer.php"); ?>																																			