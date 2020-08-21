<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h3>CATEGORY</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-user"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">CATEGORY</a></li>
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
								<div class="col-md-6"><a href="<?php echo base_url();?>category/add" class="btn btn-primary">Add Category</a></div>
							</div>
						</div>
						<div class="card-block">
							<div class="table-responsive dt-responsive">
								<table id="dom-jqry" class="table table-striped table-bordered nowrap">
									<thead>
										<th>PK</th>
										<th style="width: 100px;">COVER URL</th>
										<th>CATEGORY</th>
										<th>DESCRIPTION</th>
										<th style="width: 100px;"></th>
									</thead>
									<tbody>
										<?php foreach($category as $key =>  $cat){?>
										<tr attr_id="<?php echo $cat['id'];?>">
											<td><?php echo $key + 1;?></td>
											<td>
												<?php echo $cat['cover_url']?'<img src="' . base_url() . $cat['cover_url'] . '" style="width:100px;"/>':'';?>
											</td>
											<td><?php echo $cat['category'];?></td>
											<td style="white-space:normal;"><?php echo $cat['description'];?></td>
											<td>
												<a href="<?php echo base_url() . 'category/add/' . $cat['id'];?>" class="btn btn-success">Edit</a>
												<a href="javascript:;" class="btn btn-danger delete" attr_id="<?php echo $cat['id'];?>">Delete</a>
											</td>
										</tr>
									<?php }?>
									</tbody>
								</table>
							</div>
						</div>