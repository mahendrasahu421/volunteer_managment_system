<div class="main-content app-content mt-0">
	<div class="side-app">

		<!-- CONTAINER -->
		<div class="main-container container-fluid">

			<!-- PAGE-HEADER -->
			<div class="page-header">
				<div>
					<h1 class="page-title">
						User Profile</h1>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="admin-dashboard">Home</a></li>
						<!-- <li class="breadcrumb-item "><a href="javascript:void(0);"> Dashboards
							</a></li> -->
						<li class="breadcrumb-item active text-warning" aria-current="page">
							Edit Profile</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-xl-12">
					<div class="card">
						<div class="card-header bg-warning">
							Update Your Profile</h3>
						</div>
						<div class="card-body">
							<form class="needs-validation" action="<?php echo base_url(); ?>update_profile" method="post" name="form" id="form" novalidate>
								<div class="form-row">
									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold">First Name</label>
										<input type="text" class="form-control" value="<?php echo $volunteerDetails[0]['first_name']; ?>" required name="first_name">
									</div>
									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold">Last Name</label>
										<input type="text" class="form-control" value="<?php echo $volunteerDetails[0]['last_name']; ?>" required name="last_name">
									</div>
									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold"> Enter Mobile Number</label>
										<input type="text" class="form-control" placeholder="Mobile number" value="<?php echo $volunteerDetails[0]['mobile']; ?>" required name="mobile">
									</div>
									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold"> Enter Email</label>
										<input type="text" class="form-control" placeholder="Email" value="<?php echo $volunteerDetails[0]['email']; ?>" required name="email">
									</div>

									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold">Present Address(House no & Street)</label>
										<input type="text" class="form-control" placeholder="" value="<?php echo $volunteerDetails[0]['present_address']; ?>" required name="present_address">
									</div>
									<div class="form-group col-md-6 mb-0">
										<label class="form-label fw-bold">Permanent Address(House no & Street)</label>
										<input type="text" class="form-control" placeholder="" value="<?php echo $volunteerDetails[0]['permanent_address']; ?>" required name="permanent_address">
									</div>


									<button class="btn btn-warning mt-5" type="submit">Update</button>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>