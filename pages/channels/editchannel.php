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
	
	$id = $_GET['edit'];
	$channel = $ts3->channelGetById($id);
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Editing Channel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Editing Channel</li>
			
		</ol>
		<br />
	</section>
	<?php if (isset($_POST["edit"])) { ?>
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Success</h4>
			Channel Edited! , Realoading Page
			<META HTTP-EQUIV="refresh" CONTENT="2; URL=list.php">
		</div>
		<?php }else{?>
		<section class="content">
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Editing Channel ID <?php echo $id; ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form class="form-horizontal" method="post" action="editingc.php" >
						<input type="hidden" name="id" class="form-control"  value="<?php echo $id; ?>">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
								
								<div class="col-sm-10">
									<input type="text" name="chname"class="form-control"  value="<?php echo $channel["channel_name"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Topic</label>
								
								<div class="col-sm-10">
									<input type="text" name="chtopic" class="form-control"  value="<?php echo $channel["channel_topic"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Description</label>
								
								<div class="col-sm-10">
									<input type="text" name="chdescription" class="form-control"  value="<?php echo $channel["channel_description"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
								
								<div class="col-sm-10">
									<input type="text" class="form-control"  value="<?php echo $channel["channel_password"]; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">MaxClients</label>
								
								<div class="col-sm-10">
									<input type="text" name="chmaxclients" class="form-control"  value="<?php echo $channel["channel_maxclients"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Order</label>
								
								<div class="col-sm-10">
									<input type="text" name="chorder" class="form-control"  value="<?php echo $channel["channel_order"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">Phonetic</label>
								
								<div class="col-sm-10">
									<input type="text" name="chphonetic" class="form-control"  value="<?php echo $channel["channel_name_phonetic"]; ?>">
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" onClick="window.location.reload()" class="btn btn-default">Reload Values</button>
							<button type="submit" name="edit" class="btn btn-info pull-right">Edit Channel</button>
						</div>
						<!-- /.box-footer -->
					</form>
				</div>
			</div>
		</section>
	</div>
<?php }?>
</div>
<?php include("../../desing/footer.php"); ?>							