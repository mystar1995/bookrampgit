<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-book bg-c-blue"></i>
					<div class="d-inline">
						<h3>Content</h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<div class="card">
						<div class="card-header">
							<div class="row">
								<div class="col-md-6"><h4><?php echo $content['title']?></h4></div>
							</div>
						</div>
						<div class="card-block">
							<div name="summernote" id="summernote_1"> 
								<?php echo $content['book_content'];?>
							</div>
							<?php if($content['status'] == 'DRAFT'){?>
							<div class="row">
								<button class="btn btn-success btn-round save_book" style="margin-left: auto;margin-right: 15px;" attr_id="<?php echo $content['id'];?>">Save</button>
								<button class="btn btn-primary btn-round publish_book" style="margin-right: 15px;" attr_id="<?php echo $content['id'];?>">Publish</button>
							</div>	
							<?php }?>
						</div>