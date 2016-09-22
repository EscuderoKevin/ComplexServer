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
	$channelist = $ts3->channelList();
	
	
	if(isset($_GET['delete'])) {
		$ts3->channelDelete($_GET['delete'],$force = TRUE);
		
	}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Channel List</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Channel List</li>
			
		</ol>
		<br />
		<?php if(isset($_GET['delete'])) { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-check"></i> Success</h4>
				Channel Deleted! , Realoading Page
				<META HTTP-EQUIV="refresh" CONTENT="2; URL=list.php">
			</div>
			
		</section>
		<?php }else{?>
		<section class="content">
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
									echo "<td align='center'>Id</td>";
									echo "<td align='center'>Name</td>";  
									echo "<td align='center'>Order</td>";  
									echo "<td align='center'>Password</td>";  
									echo "<td align='center'>Permanent</td>";  
									echo "<td align='center'>Action</td>"; 
									echo "</tr>";
									
									foreach ($channelist as $row) 
									{ 
										echo '<td align=center>' . $row['cid'] . '</td>';
										echo '<td align=center>' . $row['channel_name'] . '</td>';
										echo '<td align=center>' . $row['channel_order'] . '</td>';
										echo '<td align=center>' . $row['channel_password'] . '</td>';
										echo '<td align=center>' . ($row['channel_flag_permanent'] ? 'Yes' : 'No') . '</td>';
										echo '<td align=center><a class="fa fa-remove" href="list.php?delete='.$row['cid'].'">   </a><a class="fa fa-cog" href="editchannel.php?edit='.$row['cid'].'"></a></td>';
										echo '</tr>';
										echo '</center>';
										
									}
									
								?>	
							</table>
					</div>
				</div>
			</center>
			
		</div>
	<?php }?>
</section>
</div>
<?php include("../../desing/footer.php"); ?>			