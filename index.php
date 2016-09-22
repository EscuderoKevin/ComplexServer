<?php
	session_start();
	require_once 'functions/class.user.php';
	$user_login = new USER();
	
	if($user_login->is_logged_in()!="")
	{
		$user_login->redirect('home.php');
	}
	
	if(isset($_POST['btn-login']))
	{
		$email = trim($_POST['txtemail']);
		$upass = trim($_POST['txtupass']);
		
		if($user_login->login($email,$upass))
		{
			$user_login->redirect('home.php');
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>ComplexServer Creator! | EscuderoKevin For R4P3.NET</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="desing/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="desing/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="desing/plugins/iCheck/square/blue.css">
		
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="index.php"><b>ComplexServer</b>By EscuderoKevin</a>
			</div>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<?php 
					if(isset($_GET['inactive']))
					{
					?>
					<div class='alert alert-error'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
					</div>
					<?php
					}
				?>
				<p class="login-box-msg">Sign in to start your session</p>
				
				<form method="post">
					<?php
						if(isset($_GET['error']))
						{
						?>
						<div class='alert alert-success'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<strong>Wrong Details!</strong> 
						</div>
						<?php
						}
					?>
					<div class="form-group has-feedback">
						<input type="email" class="form-control" name="txtemail" placeholder="Email">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="txtupass" placeholder="Password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<button type="submit" name="btn-login" class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				
				<a href="fpass.php">I forgot my password</a><br>
				<a href="signup.php" class="text-center">Register a new membership</a>
				
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->
		
		<!-- jQuery 2.2.3 -->
		<script src="desing/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="desing/bootstrap/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="desing/plugins/iCheck/icheck.min.js"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
				});
			});
		</script>
	</body>
</html>
