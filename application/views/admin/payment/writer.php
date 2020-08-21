<style type="text/css">
	td{
		text-align: center;
	}

	.inactive
	{
		opacity: 0.5;
	}
</style>
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-credit-card bg-c-blue"></i>
					<div class="d-inline">
						<h3>Writer's Settlement</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-credit-card"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Settlement(Writer)</a></li>
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
								<div class="col-md-6"><button class="btn btn-primary btn-round editable disabled payment">Settle Payment</button></div>
								<div class="col-md-6" style="display: flex;">
									<button class="btn btn-info btn-round waves-effect waves-light" style="margin-left: auto;" attr_status="all">All</button>
									<button class="btn btn-success btn-round waves-effect waves-light" attr_status="SETTLED">Settled</button>
									<button class="btn btn-danger btn-round waves-effect waves-light" attr_status="DUE">Due</button>
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="table-responsive dt-responsive">
								<table id="dom-jqry" class="table table-striped table-bordered nowrap">
									<thead>
										<th>No</th>
										<th>Cover Pic</th>
										<th>Content Title</th>
										<th>Author Profile Pic</th>
										<th>Author Name</th>
										<th>Amount</th>
										<th>PAID ON</th>
									</thead>
									<tbody>
										<?php foreach($settlements as $key => $settlement) {?>
											<tr attr_id="<?php echo $settlement['id'];?>">
												<td><?php echo $key + 1;?></td>
												<td>
													<?php if($settlement['coverurl']){?>
														<img src="<?php echo base_url() . $settlement['coverurl'];?>" style="width:50px;"/>
													<?php }?>	
												</td>
												<td><?php echo $settlement['contenttitle'];?></td>
												<td>
													<?php if($settlement['profilepic']){?>
														<img src="<?php echo base_url() . $settlement['profilepic'];?>" style="width:50px;"/>
													<?php }?>	
												</td>
												<td><?php echo $settlement['authorname'];?></td>
												<td>$ <?php echo $settlement['amount'];?></td>
												<td><?php echo $settlement['created_at'];?></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>