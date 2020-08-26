<style type="text/css">
	.imagepicker
	{
		width: 200px;
		height: 200px;
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

<?php 
	
	$age_group = array(5,12,15,18,30,40,50,60);
?>
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-book bg-c-blue"></i>
					<div class="d-inline">
						<h3>Add New Book</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-book"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>books/published">Books</a></li>
						<li class="breadcrumb-item"><a href="#">Add</a></li>
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
								<div class="col-xl-4 col-md-12" style="text-align: center;">
									<div style="display: flex;justify-content: center;">
										<div class="imagepicker">
											<?php if(isset($book['cover_image'])){?>
												<img src="<?php echo base_url() . $book['cover_image'];?>" style="width: 100%;height: 100%;"/>
											<?php }?>
										</div>	
									</div>
									<span class="btn btn-primary btn-round upload">Upload <i class="fas fa-upload"></i></span>
									<input type="file" id="browser" accept="image/*" style="display: none;"/>
								</div>
								<div class="col-xl-8 col-md-12" style="margin-left: auto;">
									<div class="row form-group">
										<label class="col-md-12 col-xl-3">Title</label>
										<div class="col-md-12 col-xl-9">
											<input type="text" class="form-control" name="title" required="" value="<?php echo isset($book['title'])?$book['title']:'';?>">
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-md-12 col-xl-3">Description</label>
										<div class="col-md-12 col-xl-9">
											<textarea class="form-control" name="description" required="" rows="5"><?php echo isset($book['description'])?$book['description']:'';?></textarea>
											<span class="messages"></span>
										</div>
									</div>	
									<div class="row form-group">
										<label class="col-md-12 col-xl-3">Story</label>
										<div class="col-md-12 col-xl-9">
											<textarea class="form-control" name="story" required="" rows="5"><?php echo isset($book['story'])?$book['story']:'';?></textarea>
											<span class="messages"></span>
										</div>
									</div>	
								</div>
							</div>
							<div class="row" style="margin-top: 30px;">
								<div class="col-xl-4  col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Language</label>
										<div class="col-xl-6 col-md-12">
											<select class="form-control" name="language">
												<option value="en" <?php echo (isset($book['language']) && $book['language'] == 'en')?'selected':'';?>>English</option>
												<option value="ar" <?php echo (isset($book['language']) && $book['language'] == 'ar')?'selected':'';?>>Arabic</option>
											</select>
										</div>
										<span class="messages"></span>
									</div>
								</div>
								<div class="col-xl-4  col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Category</label>
										<div class="col-xl-6 col-md-12">
											<select class="form-control" name="category">
												<?php foreach($category as $category_item){?>
													<option value="<?php echo $category_item['id'];?>" <?php echo (isset($book['category']) && $book['category'] == $category_item['id'])?'selected':'';?>><?php echo $category_item['category'];?></option>
												<?php }?>
											</select>
										</div>
										<span class="messages"></span>
									</div>
								</div>
								<div class="col-xl-4 col-md-12">
									<div class="row">
										<div class="col-xl-4 col-md-12">Content File</div>
										<div class="col-xl-8 col-md-12">
											<input type="file" id="content_file" accept="doc/*">
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top: 30px;">
								<div class="col-xl-4  col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Age Group</label>
										<div class="col-xl-6 col-md-12">
											<select class="form-control" name="age_group">
												<?php foreach($age_group as $age){?>
												<option value="<?php echo $age;?>" <?php echo $book['age_group'] == $age?'selected':'';?>><?php echo $age;?>+</option>
												<?php }?>
											</select>
										</div>
										<span class="messages"></span>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<button class="btn btn-primary btn-round submit_books" attr_id = "<?php echo isset($book['id'])?$book['id']:'';?>" style="margin-left: auto;margin-right: 15px;">Submit</button>
								<button class="btn btn-success btn-round continue_writing" attr_id = "<?php echo isset($book['id'])?$book['id']:'';?>" style="margin-right: 15px;">Continue Writing</button>
							</div>