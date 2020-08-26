<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-book bg-c-blue"></i>
					<div class="d-inline">
						<h3>CONTENT - REJECTED</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-book"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">CONTENT - REJECTED</a></li>
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
						<div class="card-header">
							<div class="row">
								<div class="col-md-12">
									<a href="<?php echo base_url();?>books/add" class="btn btn-primary btn-round">Add Books</a>
									<?php $user = get_logged_user();?>
									<?php if($user['user_type'] != 'writer'){?>
									<a href="javascript:;" class="btn btn-success disabled btn-round action_btn edit">Edit Books</a>
									<a href="javascript:;" class="btn btn-danger disabled btn-round action_btn delete">Delete Books</a>
									<a href="javascript:;" class="btn btn-success btn-round disabled action_btn active" attr_status="PUBLISHED">PUBLISH Books</a>
									<a href="javascript:;" class="btn btn-round btn-danger disabled action_btn active" attr_status="UNDERREVIEW">UNDERREVIEW Books</a>
									<?php }?>
									<a href="javascript:;" class="btn btn-round btn-danger disabled action_btn download">Download Books</a>
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="table-responsive dt-responsive">
								<table id="dom-jqry" class="table table-striped table-bordered nowrap">
									<thead>
										<th>No</th>
										<th>Cover Image</th>
										<th>Title</th>
										<th>Language</th>
										<th>Category</th>
										<th>Description</th>
										<th>Story</th>
										<th>Author</th>
										<th>Status</th>
									</thead>
									<tbody>
										<?php foreach($content as $key => $contentitem){?>
											<tr attr_id="<?php echo $contentitem['id'];?>">
												<td><?php echo $key + 1;?></td>
												<td style="text-align: center;">
													<?php if($contentitem['cover_image']){?>
														<img src="<?php echo base_url() . $contentitem['cover_image'];?>" style="width:50px;"/>
													<?php }?>	
												</td>
												<td><?php echo $contentitem['title'];?></td>
												<td><?php echo $contentitem['language'] == 'en'?'English':'Arabic';?></td>
												<td><?php echo $contentitem['category_name'];?></td>
												<td><?php echo $contentitem['description'];?></td>
												<td><?php echo $contentitem['story'];?></td>
												<td><?php echo $contentitem['username'];?></td>
												<td><?php echo $contentitem['status'];?></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>