<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h5>Profanity Screening</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-user"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Profanity Screening</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<div class="card">
						<div class="card-block">
							<div class="form-group row">
								<label class="col-md-12">Profanity Keywords (multiple keywords in the new line)</label>
								<div class="col-md-12">
									<textarea class="form-control" name="profanity" rows="10" placeholder="Profanity Keywords"><?php echo get_setting('profanity');?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12" style="display: flex;">
									<button class="btn btn-primary save_btn" style="margin-left: auto;">Submit</button>
								</div>
							</div>
						</div>