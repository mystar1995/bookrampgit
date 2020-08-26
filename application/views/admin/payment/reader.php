<style type="text/css">
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
						<h3>Reader's Payment</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-credit-card"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Payment(Reader)</a></li>
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
								<div class="col-md-6"></div>
								<div class="col-md-6" style="display: flex;">
									<button class="btn btn-info btn-round waves-effect waves-light status" style="margin-left: auto;" attr_status="all">All</button>
									<button class="btn btn-success btn-round waves-effect waves-light status inactive"  attr_status="APPROVED">Approved</button>
									<button class="btn btn-danger btn-round waves-effect waves-light status inactive"  attr_status="REJECTED">Rejected</button>
									<button class="btn btn-warning btn-round waves-effect waves-light status inactive"  attr_status="PENDING">Pending</button>
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="table-responsive dt-responsive">
								<table id="dom-jqry" class="table table-striped table-bordered nowrap">
									<thead>
										<th>No</th>
										<th>Transaction Id</th>
										<th>STATUS</th>
										<th>READER</th>
										<th>CONTENT</th>
										<th>Amount</th>
										<th>USED REWARDS</th>
										<th>PAID ON</th>
									</thead>
									<tbody>
										<?php foreach($transactions as $key => $transaction){?>
											<tr attr_id="<?php echo $transaction['id'];?>">
												<td><?php echo $key + 1;?></td>
												<td><?php echo $transaction['transaction_id'];?></td>
												<td><?php echo $transaction['status'];?></td>
												<td><?php echo $transaction['readername'];?></td>
												<td><?php echo $transaction['contentname'];?></td>
												<td>$ <?php echo $transaction['amount'];?></td>
												<td><?php echo $transaction['rewards'];?></td>
												<td><?php echo $transaction['created_at'];?></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>