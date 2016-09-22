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
	
	
	try{
		$tokenlist = $ts3->privilegeKeyList();
		$error= 0;
	}
	catch(TeamSpeak3_Adapter_ServerQuery_Exception $e) 
	{ 
		$error = 1;
	} 
	
	if(isset($_GET['delete'])) {
		$ts3->privilegeKeyDelete($_GET['delete']);
		
	}
	
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Token List</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Token List</li>
			
		</ol>
		<br />		
		<section class="content">
			<?php if($error == 1) { ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Alert!</h4>
					¡Not Have Tokens!!
				</div>
			</div>
			<?php }else{
			if(isset($_GET['delete'])) { ?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Success</h4>
					Token Deleted! , Realoading Page
					<META HTTP-EQUIV="refresh" CONTENT="2; URL=list.php">
				</div>
			<?php }else{ ?>
			<center>
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Channel List</h3>
					</div>
					<center>
						<div class="row">
							<div class="col-xs-12">
								<?php 
									echo "<table class='table table-hover table-bordered'>";  
									echo '<center>';
									echo "<tr style='font-weight: bold;'>";  
									echo "<td align='center'>Token</td>";
									echo "<td align='center'>Type</td>";  
									echo "<td align='center'>Server Group</td>";  
									echo "<td align='center'>Channel</td>";  
									echo "<td align='center'>Created</td>";  
									echo "<td align='center'>Description</td>"; 
									echo "<td align='center'>Action</td>"; 
									echo "</tr>";
									
									foreach ($tokenlist as $row) 
									{ 
										try{
											$namegroup = $ts3->serverGroupGetById($row['token_id1']);
										}
										catch(TeamSpeak3_Adapter_ServerQuery_Exception $e) 
										{ 
											$namegroup = $ts3->channelGroupGetById($row['token_id1']);
										} 
										
										if($row['token_id2'] == 0){$namechannel = "No";}else{$name = $ts3->channelGetById($row['token_id2'] ); $namechannel = $name['channel_name'];}
										
										echo '<td align=center>' . $row['token'] . '</td>';
										echo '<td align=center>' . ($row['token_type'] ? 'Channel' : 'Server') . '</td>';
										echo '<td align=center>' . $namegroup['name'] . '</td>';
										echo '<td align=center>' . $namechannel. '</td>';
										echo '<td align=center>' . date('d/m/Y - H:i',$row['token_created']) . '</td>';
										echo '<td align=center>' . $row['token_description']. '</td>';
										echo '<td width="30" align=center><a class="fa fa-remove" href="list.php?delete='.$row['token'].'"></a></td>';
										echo '</tr>';
										echo '</center>';
										
										
									}
									
								?>	
							</table>
						</div>
					</div>
				</div>
			</center>
			<?php }}?>	
	</section>
</div>
<?php include("../../desing/footer.php"); ?>																							