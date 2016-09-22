<?php
	session_start();
	require '../../functions/class.user.sub.php';
	require '../../configs/creatingchannel.php';
	
	
	$user_home = new USER();
	
	
	if(!$user_home->is_logged_in())
	{
		$user_home->redirect('../../index.php');
	}
	
	$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['userSession']));
	$userdates = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$ts3 = $user_home->subconexts3();
	$channelist = $ts3->channelList();
	$clientlist = $ts3->clientList();
	
	
	$unixTime = time();
	$realTime = date('[Y-m-d]-[H:i]',$unixTime);
	
	if(isset($_POST['create'])) {
		
		
		
		$chname = $_POST['chname'];
		$chtopic = $_POST['chtopic'];
		
		$chdescription = $_POST['chdescription'];
		$chpassword = $_POST['chpassword'];
		$chtype = $_POST['chtype'];
		$owner = $_POST['client'];
		$order = $_POST['order'];
		
		settype($order, 'int');
		$chorder = $order == 0 ? $noorder : $order;

		if($owner != 0) {
			$descriptionfinal = '[center][b][u]'.$chname.'[/u][/b][/center][hr][b][list][*]Date: '.$realTime.'[*]Owner: '.$noowner.' [/list][/b]';
			
		}
		else{
			$client = $ts3->clientGetByName($owner);
			$clientuid= $client[client_unique_identifier];
			$descriptionfinal = '[center][b][u]'.$chname.'[/u][/b][/center][hr][b][list][*]Date: '.$realTime.'[*]Owner: ' . $client . '[/list][/b]';
			$kevin = 1 ;
		}
		
		
		try{
			
			
			$data = array(
			"channel_name" => $chname,
			"channel_topic" => $chtopic,
			"channel_description" => $descriptionfinal,
			"channel_order" => $chorder,
			"channel_password" => $chpassword,
			);
			
			if ($chtype == "perm"){
				$data["channel_flag_permanent"] = true;
			}
			elseif ($chtype == "semi"){
				$data["channel_flag_semi_permanent"] = true;
			}
			elseif ($chtype == "temp"){
				$data["CHANNEL_FLAG_TEMPORARY"] = true;
			}
			elseif($chtype == "def"){
				$data["CHANNEL_FLAG_DEFAULT"] = true;
				$data["channel_flag_permanent"] = true;
			}
			
			$channel_cid = $ts3->channelCreate($data);
		}
		catch(Exception $e)
		{
			echo "Error (ID " . $e->getCode() . ") <b>" . $e->getMessage() . "</b>";
		}
		
		if(isset($kevin)) {
			$ts3->clientGetByUid($clientuid)->setChannelGroup($channel_cid, $channel_admin_group);
			$ts3->clientMove($client, $channel_cid);
		}
	}
	
	
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Create Channel</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Create Channel</li>
			
		</ol>
		<br />
	</section>
	<?php if (isset($_POST["asd"])) { ?>
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Success</h4>
			Channel Created , Realoading Page
			<META HTTP-EQUIV="refresh" CONTENT="2; URL=create.php">
		</div>
		<?php }else{?>
		<section class="content">
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Create Channel </h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<form class="form-horizontal" method="post">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Owner</label>
								<div class="col-sm-10">
									<select class="form-control" name="client">
										<option value="0">Select Client</option>
										<?php 
											
											foreach($clientlist as $tsclient) {
												if($tsclient['client_type'] == 1) continue;
												echo '<option value="'.$tsclient.'">'.$tsclient.'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Order</label>
								<div class="col-sm-10">
									<select class="form-control" name="order">
										<option selected value="0">Select Channel</option>
										<?php 
											foreach($channelist as $tschannel) {
												echo '<option value="'.$tschannel['cid'].'">'.$tschannel['channel_name'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Type</label>
								
								<div class="col-sm-10">
									<select class="form-control" name="chtype">
										<option selected value="perm"> Permanent </option>
										<option value="semi">Semi Permanent </option>
										<option value="temp"> Temporary </option>
										<option value="def"> Defalut (Lobby) </option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
								
								<div class="col-sm-10">
									<input type="text" name="chname" class="form-control"  placeholder="Channel Name">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Topic</label>
								
								<div class="col-sm-10">
									<input type="text" name="chtopic" class="form-control"  placeholder="Channel Name">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
								
								<div class="col-sm-10">
									<input type="text" name="chdescription" class="form-control"  placeholder="Channel Description">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Password</label>
								
								<div class="col-sm-10">
									<input type="text" name="chpassword" class="form-control"  placeholder="Channel Password">
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<button type="submit" name="create" class="btn btn-info pull-right">Create Channel</button>
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