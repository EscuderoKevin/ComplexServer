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
	
	if (isset($_POST["edit"])) {
		
		$idhide = $_POST['id'];
    	$chname = $_POST["chname"];
		$chtopic = $_POST["chtopic"];
		$chdescription = $_POST["chdescription"];
		$chmaxclients = $_POST["chmaxclients"];
		$chorder = $_POST["chorder"];
		$chphonetic = $_POST["chphonetic"];
		
		try{
			
			
			$channela = $ts3->channelGetById($idhide);
			$channela[channel_name] = $chname;
			$channela[channel_topic] = $chtopic;
			$channela[channel_description] = $chdescription;
			$channela[channel_maxclients] = $chmaxclients;
			$channela[channel_order] = $chorder;
			$channela[channel_name_phonetic] = $chphonetic;
			
		}
		catch(TeamSpeak3_Exception $e)
		{
			echo "Error " . $e->getCode() . ": " . $e->getMessage();
		}
		
	}
	
?>
<?php include("../../desing/aside.php"); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Server
			<small>Channel Editing</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Server</a></li>
			<li class="active">Channel Editing</li>
			
		</ol>
		<br />
	</section>
	<section class="content">
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Success</h4>
			Channel Edited! , Realoading Page
			<META HTTP-EQUIV="refresh" CONTENT="0; URL=list.php">
		</div>
	</section>
</div>
</div>
<?php include("../../desing/footer.php"); ?>					