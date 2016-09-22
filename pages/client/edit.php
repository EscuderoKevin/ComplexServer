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
	
	if(isset($_POST['edit'])) {
		
		$description = $_POST['description'];
		$nick= $_POST['client'];
		$client = $ts3->clientGetByName($nick);
		$client["client_description"] = $description;
		
	}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Client
			<small>Kick</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Client</a></li>
			<li class="active">Kick</li>
		</ol>
		<br />
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<?php if($error == 1){ ?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>
						¡Not Users Conected!
					</div>
					
					<?php }else{
						
						if(isset($_POST['edit'])){?>
						
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-ban"></i> Well Done!</h4>
							¡User : <?php echo $nick; ?> Description Set To "<?php echo $description; ?>" !
							<center><h3> Reloading Page... </h3></center>
							<meta http-equiv="refresh" content="3">
						</div>
					<?php }else{?>
					
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">Client List</h3>
						</div>
						<div class="box-body">
							<form role="form" method="post" >
								<div class="form-group">
									<label>Select Client.</label>
									<select class="form-control" name="client" onchange="change_select(this);">
										<option name="client" value="">Select Client</option>
										<?php 
											
											foreach($ts3->clientList() as $tsclient) {
											if($tsclient['client_type'] == 1) continue;
											echo '<option value="'.$tsclient.'">'.$tsclient.'</option>';
											}
										?>
									</select>
									<select style="display:none" name="client_description">
										<?php
											foreach($ts3->clientList() as $tsclient) {
												if($tsclient['client_type'] == 1) continue;
												echo '<option id="cl_desc_'.$tsclient.'" value="'.$tsclient["client_description"].'">'.$tsclient.'</option>';
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Description.</label>
									<input type="text" class="form-control" name="description" id="description_client_">
								</div>
								<input type="text" style="display:none" name="name" id="description_client_">
								
								<div class="box-footer">
									<button type="submit" onClick="window.location.reload()" class="btn btn-default">Reload List</button>
									<button type="submit" name="edit" class="btn btn-default pull-right">Edit Client</button>
								</div>
							</form>
							
							<script>
								function change_select(select) {
									if(select.value == "") {
										document.getElementById('description_client_').value = "";
									}
									else {
										document.getElementById('description_client_').value = document.getElementById("cl_desc_"+select.value).value;
									}
								}
							</script>
						</div>
					</div>
					
				<?php }} ?>
			</div>
		</div>
	</section>
	
</div>
<?php include("../../desing/footer.php"); ?>																			