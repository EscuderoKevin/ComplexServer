<?php $dir = dirname($_SERVER['REQUEST_URI']); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Complex Server | Dashboard</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="/complexserver/desing/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="/complexserver/desing/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="/complexserver/desing/dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="/complexserver/desing/plugins/iCheck/flat/blue.css">
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<a href="/complexserver/home.php" class="logo">
					<span class="logo-mini"><b>C</b> SV</span>
					<span class="logo-lg"><b>ComplexServer</b> EK</span>
				</a>
				<nav class="navbar navbar-static-top">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<span class="hidden-xs"><?php echo $userdates['userName']; ?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										
										<p>
											Complex Server | R4P3.NET
											Escudero Kevin - Web Developer
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-right">
											<a href="/complexserver/logout.php" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<?php 	if($error == 1){ }else{?> 
				<aside class="main-sidebar">
					<section class="sidebar">
						<div class="user-panel" style="height: 50px;">
							<div class="pull-left info">
								<p>Hi, <?php echo $userdates['userName']; ?></p>
							</div>
						</div>
						<ul class="sidebar-menu">
							<li class="header">MAIN NAVIGATION</li>
							<li class="treeview">
								<a href="/complexserver/home.php">
									<i class="fa fa-dashboard"></i> <span>Dashboard</span>
									<span class="pull-right-container">
										<i class="fa fa-hand-peace-o"></i>
									</span>
								</a>
							</li>
							<li <?php  if($dir == '/complexserver/pages/server') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
								<a href="#">
									<i class="fa fa-files-o"></i>
									<span>Server!</span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/server/details.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/server/details.php"><i class="fa fa-circle-o"></i> Edit Details</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/server/viewer.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/server/viewer.php"><i class="fa fa-circle-o"></i> Viewer</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/server/message.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/server/message.php"><i class="fa fa-circle-o"></i> Global Message</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/server/banlist.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/server/banlist.php"><i class="fa fa-circle-o"></i> Ban List</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/server/reset.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/server/reset.php"><i class="fa fa-circle-o"></i> Reset Server</a></li>
								</ul>
							</li>
							<li <?php  if($dir == '/complexserver/pages/client') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
								<a href="#">
									<i class="fa fa-pie-chart"></i>
									<span>Clients</span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/kick.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/kick.php"><i class="fa fa-circle-o"></i> Kick 1</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/kickall.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/kickall.php"><i class="fa fa-circle-o"></i> Kick All</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/message.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/message.php"><i class="fa fa-circle-o"></i> Message</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/ban.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/ban.php"><i class="fa fa-circle-o"></i> Ban Client</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/list.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/list.php"><i class="fa fa-circle-o"></i> Client List</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/client/edit.php') { echo 'class="active"'; } ?>><a href="/complexserver/pages/client/edit.php"><i class="fa fa-circle-o"></i> Edit Client</a></li>
								</ul>
							</li>
							<li <?php  if($dir == '/complexserver/pages/channels') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
								<a href="#">
									<i class="fa fa-laptop"></i>
									<span>Channels</span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/channels/create.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/channels/create.php"><i class="fa fa-circle-o"></i> Create</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/channels/list.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/channels/list.php"><i class="fa fa-circle-o"></i> List</a></li>
								</ul>
							</li>
							<li <?php  if($dir == '/complexserver/pages/tokens') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
								<a href="#">
									<i class="fa fa-edit"></i> <span>Tokens</span>
									<span class="pull-right-container">
										<i class="fa fa-angle-left pull-right"></i>
									</span>
								</a>
								<ul class="treeview-menu">
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/tokens/generate.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/tokens/generate.php"><i class="fa fa-circle-o"></i> Generate</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/tokens/list.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/tokens/list.php"><i class="fa fa-circle-o"></i> List</a></li>
									<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/tokens/groups.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/tokens/groups.php"><i class="fa fa-circle-o"></i> Server Groups</a></li>
								</ul>
							</li>
							<?php if($userdates['vip'] == 1){ ?>
								<li <?php  if($dir == '/complexserver/pages/vip') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
									<a href="#">
										<i class="fa fa-edit"></i> <span>Vip Area</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li>
											<a href="#"><i class="fa fa-circle-o"></i> Backups
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											
											<ul class="treeview-menu">
												
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/generate.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/generate.php"><i class="fa fa-circle-o"></i> Generate</a></li>
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/restore.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/restore.php"><i class="fa fa-circle-o"></i> Restore</a></li>
											</ul>
										</li>
										<li>
											<a href="#"><i class="fa fa-circle-o"></i> Support
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											
											<ul class="treeview-menu">
												
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/tickets.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/tickets.php"><i class="fa fa-circle-o"></i> Tickets</a></li>
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/chat.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/chat.php"><i class="fa fa-circle-o"></i> Chat</a></li>
											</ul>
										</li>
										<li>
											<a href="#"><i class="fa fa-circle-o"></i> Others
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
												</span>
											</a>
											
											<ul class="treeview-menu">
												
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/tsdns.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/tsdns.php"><i class="fa fa-circle-o"></i> TSDNS</a></li>
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/hosturl.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/hosturl.php"><i class="fa fa-circle-o"></i> Host Banner & URL</a></li>
												<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/vip/advertisements.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/vip/advertisements.php"><i class="fa fa-circle-o"></i> Advertisements</a></li>
											</ul>
										</li>
									</ul>
								</li>
							<? } ?>
							<?php if($userdates['admin'] == 1){ ?>
								<li <?php  if($dir == '/complexserver/pages/admin') { echo 'class="active treeview"'; } else { 'class="treeview"'; } ?>>
									<a href="#">
										<i class="fa fa-edit"></i> <span>Admin Area</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li class="treeview">
											<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/dashboardadmin.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/dashboardadmin.php">
												<i class="fa fa-dashboard"></i> <span>Dashboard</span>
												<span class="pull-right-container">
													<i class="fa fa-hand-peace-o"></i>
												</span>
											</a>
											</li>
											<li>
												<a href="#"><i class="fa fa-circle-o"></i> Support
													<span class="pull-right-container">
														<i class="fa fa-angle-left pull-right"></i>
													</span>
												</a>
												
												<ul class="treeview-menu">
													
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/tickets.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/tickets.php"><i class="fa fa-circle-o"></i> Tickets</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/chat.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/chat.php"><i class="fa fa-circle-o"></i> Chat</a></li>
												</ul>
											</li>
											<li>
												<a href="#"><i class="fa fa-circle-o"></i> Server & Users
													<span class="pull-right-container">
														<i class="fa fa-angle-left pull-right"></i>
													</span>
												</a>
												
												<ul class="treeview-menu">
													
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/clientlist.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/clientlist.php"><i class="fa fa-circle-o"></i>Client List</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/client.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/client.php"><i class="fa fa-circle-o"></i>Create Client & Server</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/deleteserverclient.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/deleteserverclient.php"><i class="fa fa-circle-o"></i> Delete Client & Server</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/editclient.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/editclient.php"><i class="fa fa-circle-o"></i> Edit Client</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/server.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/server.php"><i class="fa fa-circle-o"></i>Create Server</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/editserver.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/editserver.php"><i class="fa fa-circle-o"></i> Edit Server</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin//deleteserver.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/server/deleteserver.php"><i class="fa fa-circle-o"></i> Delete Server</a></li>
													
												</ul>
											</li>
											<li>
												<a href="#"><i class="fa fa-circle-o"></i> Others
													<span class="pull-right-container">
														<i class="fa fa-angle-left pull-right"></i>
													</span>
												</a>
												
												<ul class="treeview-menu">
													
													
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/others/globalmessage.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/others/globalmessage.php"><i class="fa fa-circle-o"></i> Global Message</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/others/serverdefault.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/others/serverdefault.php"><i class="fa fa-circle-o"></i> Server Template</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/others/servermessage.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/others/servermessage.php"><i class="fa fa-circle-o"></i> Server Message</a></li>
													<li <?php  if($_SERVER['REQUEST_URI'] == '/complexserver/pages/admin/others/cronmessage.php') { echo 'class="active"'; } ?>> <a href="/complexserver/pages/admin/others/cronmessage.php"><i class="fa fa-circle-o"></i> Cron Message</a></li>
												</ul>
											</li>
										</ul>
									</li>
								<? } ?>
							</ul>
						</section>
					</aside>	
				<?php } echo $_SERVER['REQUEST_URI']; ?>								