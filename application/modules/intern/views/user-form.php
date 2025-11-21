<div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        Intern Profile</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('intern-dashbord')?>">Home</a></li>
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
                            <form class="needs-validation" action="<?php echo base_url(); ?>intern-update-profile"
                                method="post" name="form" id="form" novalidate>
                                <div class="form-row">
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">First Name</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $internDetails[0]['first_name']; ?>" required
                                            name="first_name">
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Last Name</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $internDetails[0]['last_name']; ?>" required
                                            name="last_name">
                                    </div>

                                    <!-- <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Age</label>
                                        <div class="input-group mb-4">
                                            <?php if ($internDetails['date_of_birth'] == "0000-00-00") {
                                                $dob = "";
                                            } else {
                                                $dob = date('d/m/Y', strtotime($internDetails['date_of_birth']));
                                            } ?>
                                            <input type="text" class="form-control" value="<?php echo $dob; ?>" name="dob" id="dob" required autocomplete="off">
                                        </div>
                                        <span id="lblError" style="color:Red"><?php echo $this->session->flashdata('dob_error'); ?></span>
                                    </div> -->

                                    <div class="form-group col-md-6 mb-0 select-dropdown">
                                        <label class="form-label fw-bold">Gender</label>
                                        <select class="form-control" data-placeholder="" name="gender">
                                            <option <?php if ($internDetails[0]['gender'] == 1) {
                                                echo 'selected';
                                            } ?> value="1" <?php echo $internDetails[0]['gender']; ?>>Male</option>
                                            <option <?php if ($internDetails[0]['gender'] == 2) {
                                                echo 'selected';
                                            } ?> value="2" <?php echo $internDetails[0]['gender']; ?>>Female</option>
                                            <option <?php if ($internDetails[0]['gender'] == 3) {
                                                echo 'sselected';
                                            } ?> value="3" <?php echo $internDetails[0]['gender']; ?>>Transgender</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold"> Enter Email</label>
                                        <input type="email" class="form-control" placeholder="Email" readonly
                                            value="<?php echo $internDetails[0]['email']; ?>" required name="email">
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold"> Enter Mobile Number</label>
                                        <input type="text" class="form-control" placeholder="Mobile number" readonly
                                            value="<?php echo $internDetails[0]['mobile']; ?>" required name="mobile">
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">State Name</label>
                                        <select class="form-control select2-show-search form-select" name="state_name"
                                            id="state_name">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $sd) { ?>
                                                <option value="<?php echo $sd['state_id']; ?>" <?php echo $internDetails[0]['state_id'] == $sd['state_id'] ? "selected" : ""; ?>>
                                                    <?php echo $sd['state_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">district Name</label>
                                        <select class="form-control select2-show-search form-select" name="city_name"
                                            id="city_name">
                                            <option value="">Select district</option>
                                            <?php foreach ($city as $cd) { ?>
                                                <option value="<?php echo $cd['city_id']; ?>" <?php echo $internDetails[0]['city_id'] == $cd['city_id'] ? "selected" : ""; ?>>
                                                    <?php echo $cd['city_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <button class="btn btn-warning mt-5" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>