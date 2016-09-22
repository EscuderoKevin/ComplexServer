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
	$servergroups = $ts3->serverGroupList(array("type" => TeamSpeak3::GROUP_DBTYPE_REGULAR));
	$channelgroups = $ts3->channelGroupList(array("type" => TeamSpeak3::GROUP_DBTYPE_REGULAR));
	$channelist = $ts3->channelList();
	
	
	if(isset($_POST['generate'])) {
		
		$sgid = $_POST['id'];
		$description = $_POST['descrip'];
		
		$type = TeamSpeak3::TOKEN_SERVERGROUP;
		$id2 = 0;
		$ts3->privilegeKeyCreate($type,$sgid,$id2,$description);	
		
	}
	
	if(isset($_POST['generatec'])) {
		
		$id1 = $_POST['idsvch'];
		$id2 = $_POST['idch'];
		$description = $_POST['descrip'];
		
		$type = TeamSpeak3::TOKEN_CHANNELGROUP;
		$ts3->privilegeKeyCreate($type,$id1,$id2,$description);	
		
	}
	
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Generate Token</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Generate Token</li>
			
		</ol>
		<br />		
	</section>
	<section class="content">
		<?php if(isset($_POST['generate']) || isset($_POST['generatec'])) { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-check"></i> Success</h4>
				Token Created! , Realoading Page
				<META HTTP-EQUIV="refresh" CONTENT="2; URL=list.php">
			</div>
			<?php }else{ ?>
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Generate Token ServerGroup</h3>
				</div>
				<form class="form-horizontal" method="post">
					<div class="box-body">
						
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">ServerGroup</label>
							
							<div class="col-sm-10">
								<select class="form-control" name="id" required>
									<?php 
										
										foreach($servergroups as $groups) {
											echo '<option value="'.$groups['sgid'].'">'.$groups['name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
							
							<div class="col-sm-10">
								<input type="text" name="descrip" class="form-control"  placeholder="For EscuderoKevin">
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" name="generate" class="btn btn-info pull-right">Generate Token</button>
						</div>
						<!-- /.box-footer -->
					</div>
				</form>
				<br><br>
			</div>
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Generate Token ChannelGroup</h3>
				</div>
				<form class="form-horizontal" method="post">
					<div class="box-body">
						
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Select ChannelGroup</label>
							
							<div class="col-sm-10">
								<select class="form-control" name="idsvch" required>
									<?php 
										
										//foreach($channelgroups as $groups2) {
										//	echo '<option value="'.$groups2['sgid'].'">'.$groups2['name'].'</option>';
										//}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Select Channel</label>
							
							<div class="col-sm-10">
								<select class="form-control" name="idch" required>
									<?php 
										
										foreach ($channelist as $row) {
											echo '<option value="'.$row['cid'].'">'.$row['channel_name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
							
							<div class="col-sm-10">
								<input type="text" name="descrip" class="form-control"  placeholder="For EscuderoKevin">
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" name="generatec" class="btn btn-info pull-right">Generate Token</button>
						</div>
						<!-- /.box-footer -->
						</div>
					</form>
				
			</div>
		<?php var_dump($channelgroups);} ?>
	</section>
</div>	
<?php include("../../desing/footer.php"); ?>																												