<style type="text/css">
	td
	{
		text-align: center;
	}
</style>
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h3>Reader</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-user"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="#!">Reader</a></li>
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
								<div class="col-md-8">
									<a class="btn btn-primary btn-round" href="<?php echo base_url();?>reader/add">Add Reader</a>
									<button class="btn btn-success btn-round disabled editable edit">Edit</button>
									<button class="btn btn-danger btn-round disabled editable delete">Delete</button>
								</div>
							</div>
						</div>
						<div class="card-block">
							<div class="table-responsive dt-responsive">
								<table id="dom-jqry" class="table table-striped table-bordered nowrap table-hover">
									<thead>
										<th>No</th>
										<th>Profile Pic</th>
										<th>Name</th>
										<th>Email</th>
										<th>Phone Number</th>
										<th>DOB</th>
										<th>Age Group</th>
										<th>Gender</th>
										<th>Country</th>
										<th>City</th>
										<th>Short BIO</th>
										<th>Rewards</th>
										<th>Language</th>
									</thead>
									<tbody>
										<?php foreach($reader as $key => $readeritem){?>
											<tr attr_id="<?php echo $readeritem['id'];?>">
												<td><?php echo $key + 1;?></td>
												<td style="text-align: center;">
													<?php if($readeritem['profile_pic']){?>
														<img src="<?php echo base_url() . $readeritem['profile_pic'];?>" style="width: 50px;"/>
													<?php }?>
												</td>
												<td><?php echo $readeritem['username'];?></td>
												<td><?php echo $readeritem['email'];?></td>
												<td><?php echo $readeritem['phone_number'];?></td>
												<td><?php echo $readeritem['dob'];?></td>
												<td><?php echo $readeritem['age_group'];?></td>
												<td><?php echo ucfirst($readeritem['gender']);?></td>
												<td><?php echo $readeritem['country_name'];?></td>
												<td><?php echo $readeritem['city'];?></td>
												<td><?php echo $readeritem['short_bio'];?></td>
												<td><?php echo $readeritem['rewards'];?></td>
												<td><?php echo $readeritem['language'] == 'en'?'English':'Arabic';?></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>