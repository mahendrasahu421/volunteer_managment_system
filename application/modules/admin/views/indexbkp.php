<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">

                <h1 class="page-title">Dashboard Analytics</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>admin-dashboard">Home</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Dashboard Analytics</li>
                </ol>
            </div>

            <div class="row">
                <form action="<?php echo base_url() ?>admin-dashboard" method="post" id="dashboard-from">
                    <div class="row">
                        <div class="col-sm-12 col-md-2 col-lg-6 col-xl-2">
                            <div class="card">
                                <div class="card-body p-4">
                                    <?php 
                                $regionId = $this->session->userdata('region_id'); 
                                $role = $this->session->userdata('role_id'); // Get role_id
                                ?>
                                  <select class="form-control select2-show-search form-select" name="region_id" id="region_id">
                                    <option disabled value="">Select Region</option>
                                    
                                    <!-- 'All' option visible only for admin -->
                                    <option value="99" 
                                        <?php if ($regionId == '99') echo 'selected'; ?> 
                                        <?php if ($role != 1) echo 'disabled'; ?>> <!-- Disable 'All' for non-admin -->
                                        All
                                    </option>

                                    <?php foreach ($regions as $rd) { ?>
                                        <option value="<?php echo $rd['region_id']; ?>"
                                            <?php if ($regionId == $rd['region_id']) echo 'selected'; ?>
                                            <?php 
                                            // Disable regions for non-admin users
                                            if ($role != 1 && $regionId != $rd['region_id']) echo 'disabled'; 
                                            ?>>
                                            <?php echo $rd['region_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                        </div><!-- COL END -->
                        <div class="col-sm-12 col-md-2 col-lg-6 col-xl-2">
                            <div class="card">
                                <div class="card-body p-4">
                                    <select class="form-control select2-show-search form-select" name="state_name" id="state_name">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $sd) { ?>
                                            <option value="<?php echo $sd['state_id']; ?>" <?php echo $state == $sd['state_id'] ? "selected" : ""; ?>>
                                                <?php echo $sd['state_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- COL END -->

                        <div class="col-sm-12 col-md-2 col-lg-6 col-xl-2">
                            <div class="card">
                                <div class="card-body p-4">
                                    <select class="form-control select2-show-search form-select" id="city_name" name="city_name">
                                        <option value=""> Select City</option>

                                    </select>
                                </div>
                            </div>
                        </div><!-- COL END -->
                        <div class="col-lg-2">
                            <lable>Select start date</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Select start date</span></i>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                <input class="form-control fc-datepicker" name="start_new" value="<?php echo date("m/d/Y", strtotime($date_from)) ?>" required placeholder="To" id="toDate" type="text">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <lable>Select end date</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Select end date</span></i>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                <input class="form-control fc-datepicker" name="end_new" value="<?php echo date("m/d/Y", strtotime($date_to)) ?>" required placeholder="From" id="fromDate" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-1 col-lg-6 col-xl-1">

                            <div class="card-body p-4">
                                <button class="btn btn-warning">Search</button>
                            </div>

                        </div><!-- COL END -->


                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-2 number-font">Total Volunteer</h5>
                                    <h3 class="mb-2 number-font active_volunteers"><?php echo $dashboardValuevol['total']; ?></h3>
                                    <p class="text-muted mb-0">
                                        <span class="text-primary"><i class="fa fa-chevron-circle-up text-primary me-1"></i>
                                        </span> Till Date
                                    </p>
                                </div>
                                <div class="col col-auto">
                                    <div class="counter-icon bg-primary-gradient box-shadow-primary brround ms-auto">
                                        <i class="fe fe-trending-up text-white mb-5 "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-2 number-font">Total Interns</h5>
                                    <h3 class="mb-2 number-font internsmonthwise internsstatewise internsstatecitywise"><?php echo $dashboardValue['total']; ?></h3>
                                    <p class="text-muted mb-0">
                                        <span class="text-secondary"><i class="fa fa-chevron-circle-up text-secondary me-1"></i>
                                        </span> Till Date
                                    </p>
                                </div>
                                <div class="col col-auto">
                                    <div class="counter-icon bg-danger-gradient box-shadow-danger brround  ms-auto">
                                        <i class="icon icon-rocket text-white mb-5 "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-2 number-font">Volunteer Task</h5>
                                    <h3 class="mb-2 number-font"><?php echo $totalTaskvol['totsltaskVolunteer']; ?></h3>
                                    <p class="text-muted mb-0">
                                        <span class="text-success"><i class="fa fa-chevron-circle-down text-success me-1"></i>
                                        </span> Till Date
                                    </p>
                                </div>
                                <div class="col col-auto">
                                    <div class="counter-icon bg-secondary-gradient box-shadow-secondary brround ms-auto">
                                        <i class="fe fe-dollar-sign text-white mb-5 "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-2 number-font">Interns Task</h5>
                                    <h3 class="mb-2 number-font"><?php echo $totalTask['totsltaskIntern']; ?></h3>
                                    <p class="text-muted mb-0">
                                        <span class="text-danger"><i class="fa fa-chevron-circle-down text-danger me-1"></i>
                                        </span> Till Date
                                    </p>
                                </div>
                                <div class="col col-auto">
                                    <div class="counter-icon bg-success-gradient box-shadow-success brround  ms-auto">
                                        <i class="fe fe-briefcase text-white mb-5 "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <table id="example" class="display bg-whit" cellspacing="0" width="100%">

                    <th colspan="15" style="background-color: #FBC434; padding:12px;">Interns

                    </th>
                    <tr style="background-color: #ffffe6; ">
                        <td rowspan="9" colspan="6">
                            <div>
                                <div class="row">

                                    <div class="col-8">
                                        <div class="card-body p-4">

                                            <h3 class="mb-2 fw-normal mt-2 ">
                                                <?php echo $dashboardValue['total']; ?> </h3>
                                            <h5 class="fw-normal mb-0">Total Interns</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-4 mt-4">
                                        <h3 class="mb-2 fw-normal mt-2 ">
                                            <i class="fa fa-male "><?php echo $dashboardValue['1']; ?></i>
                                        </h3>
                                        <h5 class="fw-normal mb-0">Male</h5>
                                    </div>
                                    <div class="col-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-2 fw-normal mt-2 ">
                                                <i class="fa fa-female "><?php echo $dashboardValue['2']; ?></i>
                                            </h3>
                                            <h5 class="fw-normal mb-0">Female</h5>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4">
                                        <h3 class="mb-2 fw-normal mt-2 ">
                                            <i class="fa fa-transgender "><?php echo $dashboardValue['3']; ?></i>
                                        </h3>
                                        <h5 class="fw-normal mb-0">Others</h5>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <th class=" magic">Total Application
                            <hr><span class="magictext">Interns Applications received (till date)</span>
                        </th>
                        <th class=" magic">Pending Application
                            <hr><span class="magictext">Interns Pending Application (till date)</span>
                        </th>
                        <th class=" magic">Active / Drop off
                            <hr><span class="magictext">Onborded Interns</span>
                        </th>

                        <th class=" magic">Male
                            <hr><span class="magictext">Interns Onborded male</span>
                        </th>
                        <th class=" magic">Female
                            <hr><span class="magictext">Interns Onborded female</span>
                        </th>
                        <th class=" magic">Others
                            <hr><span class="magictext">Interns Onborded Others</span>
                        </th>
                        <hr>
                        </th>
                    </tr>
                    <tr style="background-color: #ffffe6;">
                        <td><?php echo $dashboardValue['total']; ?>
                            <hr>
                        <td>
                            <?php echo $pendingInterns['pendingApplication']; ?>
                            <hr>

                        </td>
                        <td>
                            <?php echo $stillInters['activeApplication']; ?>
                            <hr>
                        </td>

                        <td><?php echo $dashboardValue['1']; ?>
                            <hr>
                        </td>
                        <td><?php echo $dashboardValue['2']; ?>
                            <hr>
                        </td>
                        <td><?php echo $dashboardValue['3']; ?>
                            <hr>
                        </td>
                    </tr>

                    <th style="background-color: #ffffe6;" colspan="6">Finished Tenure
                        <hr>
                    </th>
                    <tr style="background-color: #ffffe6;">

                        <th colspan="9">
                            <?php echo $certificateInters['certifictaeIntern']; ?>
                            <hr>
                        </th>
                    </tr>
                </table>


            </div>

            <div class="row mt-2">
                <table id="example" class="display bg-white " cellspacing="0" width="100%">
                    <tr>
                        <th colspan="15" style="background-color: #FBC434;">Volunteer
                        </th>
                    </tr>
                    <tr style="background-color: #e6fff2;">
                        <td rowspan="12" colspan="4">
                            <div>
                                <div class="row ">
                                    <div class="col-8">
                                        <div class="card-body p-4">

                                            <h3 class="mb-2 fw-normal mt-2 "><?php echo $dashboardValuevol['total']; ?>
                                            </h3>
                                            <h5 class="fw-normal mb-0">Total Volunteer <i class="fa fa-info magic"><span class="magictext">Onboarded
                                                        Volunteer</span></i></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">

                                    <div class="col-4 mt-4">
                                        <h3 class="mb-2 fw-normal mt-2 ">
                                            <i class="fa fa-female ">
                                            </i> <?php echo $dashboardValuevol['1']; ?>
                                        </h3>
                                        <h5 class="fw-normal mb-0 ">Total Volunteer <i class="fa fa-info magic"><span class="magictext">Onboarded
                                                    Male volunteer</span></i></h5>
                                    </div>
                                    <div class="col-4">
                                        <div class="card-body p-4">
                                            <h3 class="mb-2 fw-normal mt-2 ">
                                                <i class="fa fa-male ">
                                                </i> <?php echo $dashboardValuevol['2']; ?>
                                            </h3>
                                            <h5 class="fw-normal mb-0 ">Total Volunteer <i class="fa fa-info magic"><span class="magictext">Onboarded
                                                        female volunteer</span></i></h5>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4">
                                        <h3 class="mb-2 fw-normal mt-2 ">
                                            <i class="fa fa-transgender ">
                                            </i> <?php echo $dashboardValuevol['3']; ?>
                                        </h3>
                                        <h5 class="fw-normal mb-0 ">Total Volunteer <i class="fa fa-info magic"><span class="magictext">Onboarded
                                                    Others volunteer</span></i></h5>
                                    </div>

                                </div>
                            </div>
                        </td>
                        <th class=" magic ">Total Application <span class="magictext">Applications received
                                (till date)</span></th>
                        <th class=" magic">Pending Application <span class="magictext">Pending Application
                                (till date)</span></th>
                        <th class=" magic">Active<span class="magictext">Onborded Volunteer</span></th>

                        <th class=" magic">Male <span class="magictext">Onborded male</span></th>
                        <th class=" magic">Female <span class="magictext">Onborded female</span></th>
                        <th class=" magic">Others</th>
                        <!-- <th class=" magic"></span></th> -->
                    </tr>
                    <tr style="background-color: #e6fff2;">
                        <td><?php echo $dashboardValuevol['total']; ?></td>
                        <td> <?php echo $pendingvolunteersvol['pendingApplicationvol']; ?>
                        </td>
                        <td><?php echo $stillvolunteer['activeApplicationvol']; ?></td>

                        <td><?php echo $dashboardValuevol['1']; ?> </td>
                        <td><?php echo $dashboardValuevol['2']; ?></td>
                        <td><?php echo $dashboardValuevol['3']; ?></td>
                        <!-- <td class="female-count"></td> -->
                    </tr>

                    <th colspan="7" style="background-color: #e6fff2;">Issue Certificate</th>
                    <tr style="background-color: #e6fff2;">

                        <th>Bronze</th>
                        <th class=" countCertificate">Silver</th>
                        <th class=" countCertificate">Gold</th>
                        <th class="countCertificate">Platinum</th>
                        <th class=" countCertificate"></th>
                        <th class=" countCertificate"></th>
                        <th class=" countCertificate"></th>


                    </tr>
                    <tr style="background-color: #e6fff2;">

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>


            </div>

            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h3 class="card-title text-white">Pending Volunteer Registration</h3>
                        </div>
                        <div class="mb-0 bg-default">
                            <div class="card-header bg-danger-light">
                                <h4 class="card-title col-md-8"><i class="fa fa-filter me-2"></i> Search Filters</h4>
                                <div class="input-group col-md-4 p-0">
                                    <input type="text" class="form-control " placeholder="Search for...">
                                    <span class="input-group-text btn btn-warning">Go!</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="table-responsive ">
                                <table class="table table-bordered text-nowrap border-bottom  w-100">
                                    <thead>
                                        <tr class="bg-gray-light">
                                            <th>Sn. No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Date of Birth</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($volunteer as $key => $value) {
                                            $encode_userID = rtrim(strtr(base64_encode($value['volunteer_id']), "+/", "-_"), "=");
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $value['first_name'] . ' ' . $value['last_name']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['mobile']; ?></td>
                                                <td><?php echo $value['date_of_birth']; ?></td>
                                                <td><a href="<?php echo base_url(); ?>enquiry"><span class="badge bg-warning  me-1 mb-1 mt-1">Enquiry
                                                            Volunteer</span></a></td>


                                            </tr>
                                        <?php $i++;
                                        } ?>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#region_id").change(function() {
            var region_id = $(this).val();
            //alert(region_id);
            datastr = {
                region_id: region_id
            };
            $.ajax({
                url: '<?php echo base_url() ?>get-states-admin',
                type: 'post',
                data: datastr,
                success: function(response) {
                    $("#state_name").html(response);
                    $('select').selectpicker('refresh');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
   
        $("#state_name").change(function() {
            var state_name = $(this).val();
            //alert(region_id);
            datastr = {
                state_name: state_name
            };

            $.ajax({
                url: '<?php echo base_url() ?>get-city-by-task',
                type: 'post',
                data: datastr,
                success: function(response) {
                    $("#city_name").html(response);
                    // $('select').selectpicker('refresh');
                }
            });
        });

    });
</script>