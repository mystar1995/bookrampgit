<style type="text/css">
	.imagepicker
	{
		width: 100%;
		height: 300px;
		border-width: 1px;
		border-color: grey;
		border-style: solid;
		margin-bottom: 10px;
		border-radius: 10px;
		overflow: hidden;
	}

	.form-group
	{
		align-items: center;
	}
</style>
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h3>Add New Category</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-user"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>category">Category</a></li>
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
								<div class="col-xl-6 col-md-12" style="text-align: center;">
									<div style="display: flex;justify-content: center;">
										<div class="imagepicker">
											<?php if(isset($category['cover_url']) && $category['cover_url']){?>
												<img src="<?php echo base_url() . $category['cover_url']?>" style="width: 100%;height: 100%;"/>
											<?php }?>
										</div>	
									</div>
									<span class="btn btn-primary btn-round upload">Upload <i class="fas fa-upload"></i></span>
									<input type="file" id="browser" accept="image/*" style="display: none;"/>
								</div>
								<div class="col-xl-6 col-md-12" style="margin-left: auto;">
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">Category Name</label>
										<div class="col-md-12 col-xl-8">
											<input type="text" class="form-control" name="category" required="" value="<?php echo isset($category['category'])?$category['category']:'';?>">
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">Description</label>
										<div class="col-md-12 col-xl-8">
											<textarea class="form-control" name="description" rows="10"><?php echo isset($category['description'])?$category['description']:'';?></textarea>
										</div>
									</div>
									<div class="row form-group">
										<button class="btn btn-primary submit_category" style="margin-left: auto;margin-right: 15px;" attr_id="<?php echo isset($category['id'])?$category['id']:''?>">Submit</button>
									</div>	
								</div>
							</div>
							