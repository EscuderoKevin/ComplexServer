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
		$banlist = $ts3->banList();
		$error= 0;
	}
	catch(TeamSpeak3_Adapter_ServerQuery_Exception $e) 
	{ 
		$error = 1;
	} 
	
	
	if(isset($_GET['delete'])) {
		$ts3->banDelete($_GET['delete']);
		
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
		<?php if($error == 1) { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-ban"></i> Alert!</h4>
				¡Not Users Banned!
			</div>
		</div>
		<?php }else{
			if(isset($_GET['delete'])) { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-check"></i> Success</h4>
				Ban Removed! , Realoading Page
				<META HTTP-EQUIV="refresh" CONTENT="2; URL=banlist.php">
			</div>
		<?php }?>
		<center>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Server Ban List</h3>
							<h5> Info: 0 Seconds = Permanent </h5>
							<h5> Info: Clear Name = IP Ban </h5>
						</div>
						<?php 
							echo "<table class='table table-hover'>";  
							echo '<center>';
							echo "<tr style='font-weight: bold;'>";  
							echo "<td width='150' align='center'>Id</td>";
							echo "<td width='150' align='center'>Name</td>";  
							echo "<td width='300' align='center'>UID</td>";  
							echo "<td width='150' align='center'>Date</td>";  
							echo "<td width='150' align='center'>Invoker</td>";  
							echo "<td width='150' align='center'>Time</td>";  
							echo "<td width='150' align='center'>Reason</td>"; 
							echo "<td width='30' align='center'>Action</td>"; 
							echo "</tr>";
							
							foreach ($banlist as $row) 
							{ 
								$segundos = " Seconds";
								echo '<td width="150" align=center>' . $row['banid'] . '</td>';
								echo '<td width="150" align=center>' . $row['lastnickname'] . '</td>';
								echo '<td width="300" align=center>' . $row['uid'] . '</td>';
								echo '<td width="150" align=center>' . date('d/m/Y - H:i',$row['created']) . '</td>';
								echo '<td width="150" align=center>' . $row['invokername'] . '</td>';
								echo '<td width="150" align=center>' . $row['duration'].$segundos. '</td>';
								echo '<td width="150" align=center>' . $row['reason'] . '</td>';
								echo '<td width="30" align=center><a class="fa fa-remove" href="banlist.php?delete='.$row['banid'].'"></a></td>';
								echo '</tr>';
								echo '</center>';
								
							}
							
						?>	
					</table>
				</div>
			</div>
		</div>
	</center>
<?php }?>	
</section>
</div>
<?php include("../../desing/footer.php"); ?>																						