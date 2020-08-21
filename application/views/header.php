<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<title>Book Ramp</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
		<meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
		<meta name="author" content="colorlib" />
		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/waves.min.css" type="text/css" media="all">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/feather.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/global/bootstrap-toastr/toastr.css">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome-n.min.css">

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/chartist.css" type="text/css" media="all">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/widget.css">
		<style type="text/css">
			.btn-round
			{
				margin-left: 10px;
			}

			#dom-jqry tbody tr
			{
				cursor: pointer;
			}

			#dom-jqry tbody tr:hover
			{
				background-color: #eeeeee;
			}

			#dom-jqry tbody tr.active
			{
				background-color: #333;
				color: white;	
			}
		</style>
		<?php 
			if(isset($css)){
			foreach($css as $style){
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() . $style;?>">
		<?php }}?>
	</head>
	<body>
		<div class="loader-bg">
			<div class="loader-bar"></div>
		</div>
		<div id="pcoded" class="pcoded">
			<div class="pcoded-overlay-box"></div>
			<div class="pcoded-container navbar-wrapper">
				<nav class="navbar header-navbar pcoded-header">
					<div class="navbar-wrapper">
						<div class="navbar-logo">
							<a href="index.html">
								<img class="img-fluid" src="<?php echo base_url();?>/assets/jpg/bookramp_logo.png" alt="Theme-Logo" style="max-width: 200px;"/>
							</a>
							<a class="mobile-menu" id="mobile-collapse" href="#!">
								<i class="feather icon-menu icon-toggle-right"></i>
							</a>
							<a class="mobile-options waves-effect waves-light">
								<i class="feather icon-more-horizontal"></i>
							</a>
						</div>
						<div class="navbar-container container-fluid">
							<ul class="nav-left">
								<li class="header-search">
									<div class="main-search morphsearch-search">
										<div class="input-group">
											<span class="input-group-prepend search-close">
												<i class="feather icon-x input-group-text"></i>
											</span>
											<input type="text" class="form-control" placeholder="Enter Keyword">
											<span class="input-group-append search-btn">
												<i class="feather icon-search input-group-text"></i>
											</span>
										</div>
									</div>
								</li>
							</ul>
							<ul class="nav-right">
								<li class="user-profile header-notification">
									<div class="dropdown-primary dropdown">
										<div class="dropdown-toggle" data-toggle="dropdown">
											<img src="<?php echo get_user_logo();?>" class="img-radius" alt="User-Profile-Image">
											<span><?php echo get_username();?></span>
											<i class="feather icon-chevron-down"></i>
										</div>
										<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
											<li>
												<a href="<?php echo base_url() . 'reader/add/' . get_user_id();?>">
													<i class="feather icon-user"></i> Profile
												</a>
											</li>
											<li>
												<a href="<?php echo base_url(). 'auth/logout';?>">
													<i class="feather icon-log-out"></i> Logout
												</a>
											</li>
										</ul>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			
				<div class="pcoded-main-container">
					<div class="pcoded-wrapper">
						<nav class="pcoded-navbar">
							<div class="nav-list">
								<div class="pcoded-inner-navbar main-menu">
									<ul class="pcoded-item pcoded-left-item">
										<?php display_header();?>
									</ul>
								</div>
							</div>
						</nav>
