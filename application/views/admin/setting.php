<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-settings bg-c-blue"></i>
					<div class="d-inline">
						<h3>Setting</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-settings"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Setting</a></li>
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
							<div class="row">
								<div class="col-xl-6 col-md-12">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Content Price</label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="content_price" value="<?php echo get_setting('content_price');?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Content Server Number</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="content_service_number" value="<?php echo get_setting('content_service_number');?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Purchase Points</label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="purchase_points" value="<?php echo get_setting('purchase_points');?>">
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-md-12">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Custom Server Email</label>
										<div class="col-sm-8">
											<input type="email" class="form-control" name="content_server_email" value="<?php echo get_setting('content_server_email');?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Reader Reward Points</label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="reward_points" value="<?php echo get_setting('reward_points');?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Point in Cents</label>
										<div class="col-sm-8">
											<input type="number" class="form-control" name="point_cents" value="<?php echo get_setting('point_cents');?>">
										</div>
									</div>
								</div>		
							</div>
							<div class="form-group row">
								<label class="col-md-12">Terms and Condition</label>
								<div class="col-md-12">
									<textarea class="form-control" rows="6" name="terms_condition"><?php echo get_setting('terms_condition');?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-12">Learn how to use</label>
								<div class="col-md-12">
									<textarea class="form-control" rows="6" name="how_to_use"><?php echo get_setting('how_to_use');?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-12">FAQS</label>
								<div class="col-md-12">
									<textarea class="form-control" rows="6" name="faqs"><?php echo get_setting('faqs');?></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12" style="display: flex;">
									<button class="btn btn-primary btn-round save_btn" style="margin-left: auto;">Save</button>
								</div>
							</div>
						</div>