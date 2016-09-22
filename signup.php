<?php
session_start();
require_once 'functions/class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}



    function getClientIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
		return $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED']))
		return $_SERVER['HTTP_X_FORWARDED'];
        else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
		return $_SERVER['HTTP_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_FORWARDED']))
		return $_SERVER['HTTP_FORWARDED'];
        else if(!empty($_SERVER['REMOTE_ADDR']))
		return $_SERVER['REMOTE_ADDR'];
        else
		return false;
	}
$connection = mysql_connect("localhost", "worhost_complex", "eb03f2b332");
$db_select = mysql_select_db("worhost_complexserver", $connection);
$result = mysql_query("SELECT COUNT(*) FROM tbl_users WHERE registerIP = '{$_SERVER['REMOTE_ADDR']}'"); 
$count = mysql_fetch_row($result); 	
if (!empty($count[0])) die('Your IP has already been used');

if(isset($_POST['btn-signup']))
{
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$ip = trim(getClientIp());
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id and registerIP =:register_ip");
	$stmt->execute(array(":email_id"=>$email, ":register_ip"=>$ip));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  EMAIL OR IP
			  </div>
			  ";
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$code,$ip))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;
			
			$message = "					
						Hello $uname,
						<br /><br />
						Welcome to Coding Cage!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href='http://worhost.net/complexserver/verify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";
						
			$subject = "Confirm Registration";
						
			$reg_user->send_mail($email,$message,$subject);	
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";
		}
		else
		{
			echo "sorry , Query could no execute...";
			echo $ip;
		}		
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup | Coding Cage</title>
    <!-- Bootstrap -->
    <link href="desing/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="desing/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="desing/assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="desing/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
				<?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
        <a href="index.php" style="float:right;" class="btn btn-large">Sign In</a>
      </form>

    </div> <!-- /container -->
    <script src="desing/vendors/jquery-1.9.1.min.js"></script>
    <script src="desing/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>