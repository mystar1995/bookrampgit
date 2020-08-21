<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-home bg-c-blue"></i>
					<div class="d-inline">
						<h5>Dashboard</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-home"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Dashboard</a> </li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<div class="row">
						<div class="col-12"><h3>USERS</h3></div>
					</div>
					<div class="row">
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>reader" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Readers</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_user_count('reader');?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-user bg-c-blue"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>writer/approved" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Writers</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_user_count('writer');?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-edit bg-c-lite-green"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="row" style="margin-top: 30px;">
						<div class="col-12"><h3>BOOK FILES</h3></div>
					</div>
					<div class="row">
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>books/published" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Books</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_book_count();?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-book bg-c-blue"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>books/published" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Books Published</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_book_count('PUBLISHED');?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-upload bg-c-green"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>books/rejected" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Books Rejected</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_book_count('REJECTED');?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-ban bg-c-red"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xl-4 col-md-6">
							<a href="<?php echo base_url();?>books/under_review" class="card comp-card">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-b-25">Total Books Under Review</h6>
											<h3 class="f-w-700 text-c-blue"><?php echo get_book_count('UNDERREVIEW');?></h3>
										</div>
										<div class="col-auto">
											<i class="fas fa-eye bg-c-blue"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>