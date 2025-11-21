<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        Profile</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('intern-dashbord') ?>">Home</a></li>
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
                        <!-- <div class="card-header bg-warning">
                            Update Your Profile</h3>
                        </div> -->
                        <div class="card-body">
                            <form class="needs-validation" action="<?php echo base_url(); ?>intern-update-profile"
                                method="post" name="form" id="form" novalidate>
                                <div class="form-row">
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold"> Name</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $empdata[0]['emp_name']; ?>" required name="first_name">
                                    </div>

                                    <!-- <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Age</label>
                                        <div class="input-group mb-4">
                                            <?php if ($empdata['date_of_birth'] == "0000-00-00") {
                                                $dob = "";
                                            } else {
                                                $dob = date('d/m/Y', strtotime($empdata['date_of_birth']));
                                            } ?>
                                            <input type="text" class="form-control" value="<?php echo $dob; ?>" name="dob" id="dob" required autocomplete="off">
                                        </div>
                                        <span id="lblError" style="color:Red"><?php echo $this->session->flashdata('dob_error'); ?></span>
                                    </div> -->

                                    <div class="form-group col-md-6 mb-0 select-dropdown">
                                        <label class="form-label fw-bold">Gender</label>
                                        <select class="form-control" data-placeholder="" name="gender">
                                            <option <?php if ($empdata[0]['emp_gender'] == 1) {
                                                echo 'selected';
                                            } ?>   value="1" <?php echo $empdata[0]['emp_gender']; ?>>Male</option>
                                            <option <?php if ($empdata[0]['emp_gender'] == 2) {
                                                echo 'selected';
                                            } ?>   value="2" <?php echo $empdata[0]['emp_gender']; ?>>Female</option>
                                            <option <?php if ($empdata[0]['emp_gender'] == 3) {
                                                echo 'sselected';
                                            } ?>   value="3" <?php echo $empdata[0]['emp_gender']; ?>>Transgender</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold"> Enter Email</label>
                                        <input type="email" class="form-control" placeholder="Email" readonly
                                            value="<?php echo $empdata[0]['emp_email']; ?>" required name="email">
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold"> Enter Mobile Number</label>
                                        <input type="text" class="form-control" placeholder="Mobile number" readonly
                                            value="<?php echo $empdata[0]['emp_contact']; ?>" required name="mobile">
                                    </div>

                            </form>
                            <div class="card-header bg-warning mt-5">
                                <a href="<?php echo base_url('admin-change-pwd') ?>"> Change Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>