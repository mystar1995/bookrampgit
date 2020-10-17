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
<div class="pcoded-content">
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="feather icon-user bg-c-blue"></i>
					<div class="d-inline">
						<h3>Add New User</h3>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class=" breadcrumb breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="index.html"><i class="feather icon-user"></i></a>
						</li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>reader">User</a></li>
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
											<?php if(isset($user['profile_pic']) && $user['profile_pic']){?>
												<img src="<?php echo base_url() . $user['profile_pic']?>" style="width: 100%;height: 100%;"/>
											<?php }else{?>
												<i class="fas fa-user" style="font-size: 200px;"></i>
											<?php }?>
										</div>	
									</div>
									<span class="btn btn-primary btn-round upload">Upload <i class="fas fa-upload"></i></span>
									<input type="file" id="browser" accept="image/*" style="display: none;"/>
								</div>
								<div class="col-xl-6 col-md-12" style="margin-left: auto;">
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">User Name</label>
										<div class="col-md-12 col-xl-8">
											<input type="text" class="form-control" name="username" required="" value="<?php echo isset($user['username'])?$user['username']:'';?>">
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">Email</label>
										<div class="col-md-12 col-xl-8">
											<input type="text" class="form-control" name="email" required  value="<?php echo isset($user['email'])?$user['email']:'';?>">
											<span class="messages"></span>
										</div>
									</div>	
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">Password</label>
										<div class="col-md-12 col-xl-8">
											<input type="password" class="form-control" name="password">
											<span class="messages"></span>
										</div>
									</div>	
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">Confirm Password</label>
										<div class="col-md-12 col-xl-8">
											<input type="password" class="form-control" name="confirm_password">
											<span class="messages"></span>
										</div>
									</div>									
								</div>
							</div>
							<?php 
								$age_group = array(16,25);
								if(isset($user['age_group']))
								{
									$age_group = explode('~', $user['age_group']);
								}
							?>
							<div class="row" style="margin-top: 30px;">
								<div class="col-xl-4  col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Age Group</label>
										<div class="col-xl-3 col-md-5">
											<input type="number" class="form-control" name="age_from" value="<?php echo $age_group[0];?>" />
										</div>
										<div class="col-xl-1 col-md-2" style="text-align: center;">~</div>
										<div class="col-xl-3 col-md-5">
											<input type="number" class="form-control" name="age_to" value="<?php echo $age_group[1];?>"/>
										</div>
										<span class="messages"></span>
									</div>
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Gender</label>
										<div class="form-radio col-xl-8 col-md-12">
											<div class="radio radio-inline">
												<label>
													<input type="radio" name="gender" checked="checked" value="male">
													<i class="helper"></i>Male
												</label>
											</div>
											<div class="radio radio-inline">
												<label>
													<input type="radio" name="gender" value="female">
													<i class="helper"></i>FeMale
												</label>
											</div>
										</div>
									</div>
								</div>
								<?php 
									$phonecode = '+'; $mobilenumber = "";
									if(isset($user['country']))
									{
										foreach ($countries as $key => $country) {
											if($user['country'] == $country['code'])
											{
												$phonecode = '+' . $country['phonecode'];
												$phone_num_array = explode($phonecode, $user['phone_number']);

												if(count($phone_num_array) > 0)
												{
													$mobilenumber = $phone_num_array[count($phone_num_array) - 1];
												}
												
												break;
											}
										}
									}
								?>
								<div class="col-xl-4 col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Country</label>
										<div class="col-xl-8 col-md-12">
											<select class="form-control" name="country" required>
												<option value="">Select Country</option>
												<?php foreach($countries as $country){?>
												<option value="<?php echo $country['code'];?>" <?php echo (isset($user['country']) && $user['country'] == $country['code'])?'selected':'';?>><?php echo $country['name'];?></option>
												<?php }?>
											</select>
											<span class="messages"></span>
										</div>
									</div>
									<div class="row">
										<label class="col-md-12 col-xl-4">Phone Number</label>
										<div class="col-md-12 col-xl-8">
											<div class="input-group">
												<span class="input-group-prepend">
													<label class="input-group-text" id="phone_code"><?php echo $phonecode;?></label>
												</span>
												<input type="text" class="form-control" name="phone_number" required value="<?php echo $mobilenumber;?>">
											</div>
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">City</label>
										<div class="col-xl-8 col-md-12">
											<input type="text" class="form-control" name="city" required value="<?php echo isset($user['city'])?$user['city']:'';?>"/>
											<span class="messages"></span>
										</div>
									</div>
								</div>
								<div class="col-xl-4 col-md-12">
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">Language</label>
										<div class="col-xl-8 col-md-12">
											<select class="form-control" name="language" required>
												<option value="en" <?php echo (isset($user['language']) && $user['language'] == 'en')?'selected':''?>>English</option>
												<option value="ar" <?php echo (isset($user['language']) && $user['language'] == 'ar')?'selected':''?>>Arabic</option>
											</select>
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-xl-4 col-md-12">User Type</label>
										<div class="col-xl-8 col-md-12">
											<select class="form-control" name="user_type" required>
												<option value="writer" <?php echo (isset($user['user_type']) && $user['user_type'] == 'writer')?'selected':''?>>Writer</option>
												<option value="admin" <?php echo (isset($user['user_type']) && $user['user_type'] == 'admin')?'selected':''?>>Admin</option>
												<option value="reader" <?php echo (isset($user['user_type']) && $user['user_type'] == 'reader')?'selected':''?>>Reader</option>
											</select>
											<span class="messages"></span>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-md-12 col-xl-4">DOB</label>
										<div class="col-md-12 col-xl-8">
											<input type="text" class="form-control" name="dob" required value="<?php echo isset($user['dob'])?$user['dob']:'';?>">
											<span class="messages"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-xl-2 col-md-4">Short Bio</label>
								<div class="col-xl-10 col-md-8">
									<textarea class="form-control" name="short_bio"><?php echo isset($user['short_bio'])?$user['short_bio']:'';?></textarea>
								</div>
							</div>
							<div class="row form-group">
								<button class="btn btn-primary submit_reader" style="margin-left: auto;margin-right: 15px;" attr_id="<?php echo isset($user['id'])?$user['id']:''?>">Submit</button>
							</div>