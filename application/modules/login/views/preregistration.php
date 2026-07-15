<?php $base_url = base_url() . 'admin_assets/'; ?>
<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Zanex – Bootstrap  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin, dashboard, dashboard ui, admin dashboard template, admin panel dashboard, admin panel html, admin panel html template, admin panel template, admin ui templates, administrative templates, best admin dashboard, best admin templates, bootstrap 4 admin template, bootstrap admin dashboard, bootstrap admin panel, html css admin templates, html5 admin template, premium bootstrap templates, responsive admin template, template admin bootstrap 4, themeforest html">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon"
        href="<?php echo base_url('admin/'); ?>assets/images/brand/favicon.png"" />

  <!-- TITLE -->
  <title>CRY : VMS</title>

  <!-- BOOTSTRAP CSS -->
  <link id=" style" href="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap/css/bootstrap.min.css"
        rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="<?php echo base_url('admin/'); ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url('admin/'); ?>assets/css/dark-style.css" rel="stylesheet" />
    <link href="<?php echo base_url('admin/'); ?>assets/css/skin-modes.css" rel="stylesheet" />
    <link href="<?php echo base_url('admin/'); ?>assets/css/transparent-style.css" rel="stylesheet" />
    <!-- <link href="<?php echo base_url('admin/'); ?>assets/css/animated.css" rel="stylesheet" /> -->

    <!--- FONT-ICONS CSS -->
    <link href="<?php echo base_url('admin/'); ?>assets/css/icons.css" rel="stylesheet" />
    <!-- <link type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <!-- <link type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet"> -->

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="<?php echo base_url('admin/'); ?>assets/colors/color1.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    select.form-control:not([size]):not([multiple]) {
        height: 3.375rem;
    }

    .login100-form {
        width: 573px;

    }

    @media (max-width: 992px) {
        .login100-form {
            width: 100%;
        }
    }

    .login100-form {
        /* width: 320px; */
    }


    .form-label {
        display: block;
        margin-bottom: 0.375rem;
        font-weight: 500;
        font-size: 1.40rem;
        margin-top: 9px;
    }

    .error {
        width: 100%;
        text-align: left;
        color: red;
    }

    #calendar_details_b2c,
    #calendar_details_b2b {
        display: none;
    }

    .select2-container .select2-selection--single {
        height: 3.375rem !important;
    }

    /* Disabled button styling */
    button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* File validation error styling */
    .file-error {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<body>
    <!-- BACKGROUND-IMAGE -->
    <div class="bg-warning">
        <!-- GLOABAL LOADER -->
        <div id="global-loader">
            <img src="<?php echo base_url('users/'); ?>assets/images/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /GLOABAL LOADER -->

        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto">

                    <div class="text-center mt-5">
                        <img src="<?php echo base_url('users/'); ?>assets/images/brand/cry-yellowlogo.png"
                            style="border-radius: 10px;" class="" alt="">
                    </div>
                </div>
                <div class="col col-login mx-auto">
                    <!-- <div class="text-center">
            <img src="<?php echo base_url('admin/') ?>assets/images/brand/logo.png" class="header-brand-img" alt="">
          </div> -->
                </div>
                <style>
                    #resend {
                        margin-top: 23px;
                        margin-left: -25px;
                        ;
                    }

                    #verifyMail {
                        margin-top: 23px;
                    }
                </style>
                <div class="container-login100">
                    <div class="wrap-login100 p-0">
                        <div class="card-header">
                            <span class="login100-form-title"><b>Application Form</b></span>
                        </div>


                        <!-- <?php echo $this->session->flashdata('master_insert_message'); ?> -->
                        <div class="card-body">
                            <form class="login100-form validate-form needs-validation" id="sform" method="post"
                                action="<?php echo base_url(); ?>insert_preregistration_data"
                                enctype="multipart/form-data" novalidate>
                                <section id="emailSection" style="display:block;">
                                    <div class="row">
                                        <input type="hidden" id="mailotp" name="cotp">
                                        <div class="form-group col-md-12 mb-0">
                                            <label for="looking_for">Looking for <sup class="fs-3"
                                                    style="color: red;">*</sup></label>
                                            <select class="form-select select2 form-control" id="looking_for"
                                                name="looking_for" required>
                                                <!-- <option selected disabled value="">Looking for...</option> -->
                                                <!-- <option value="volunteering">Volunteering</option> -->
                                                <option value="internship">Internship</option>
                                            </select>
                                            <div class="invalid-feedback">Please select Looking for</div>
                                        </div>

                                        <div class="form-group col-md-12 mb-0">
                                            <label class="form-label fw-bold">Enter Email (OTP Sent on your
                                                Mail) <sup class="fs-3" style="color: red;">*</sup></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Enter Email" required>
                                            <p id="error-message" style="color: red;"></p>

                                        </div>

                                        <div class="col-lg-6 mb-0 Otp">
                                            <label class="form-label fw-bold">Enter OTP </label>
                                            <div class="">
                                                <input class="form-control" id="enterOtp" name="otp"
                                                    placeholder="Enter OTP" maxlength="4">
                                            </div>
                                            <b><span class="mt-2">(Please check your SPAM incase you do not find it in
                                                    your inbox) </span>
                                                <span>OTP Valid for 10 min.</span></b>
                                        </div>

                                        <div class="col-lg-3 mb-0 Otp">
                                            <label class="form-label fw-bold"></label>
                                            <div class="" id="verifyMail">
                                                <span class="btn btn-info">Verify Mail</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-3  resendOtp">
                                            <label class="form-label fw-bold"></label>
                                            <div class="pe-3">
                                                <span id="resend" class="btn btn-info">Resend OTP</span>
                                            </div>

                                        </div>
                                        <span id="countdown" class="mt-5 text-primary"></span>

                                        <div class="form-group col-md-12 mt-3">
                                            <button type="button" class="btn btn-warning" id="genrateOTP">Generate
                                                OTP</button>
                                        </div>
                                    </div>


                                </section>


                                <section id="detailFormsection" style="display:none;">

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">First Name <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <input type="text" id="first_name" name="first_name"
                                            class="form-control txtNumeric" placeholder="First Name" required>
                                        <div class="invalid-feedback">Please Enter First Name</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Last Name <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <input type="text" id="last_name" name="last_name"
                                            class="form-control txtNumeric" placeholder="Last Name" required>
                                        <div class="invalid-feedback">Please Enter Last Name</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Date of Birth <sup class="fs-3"
                                                style="color: red;">*</sup></label>

                                        <input type="text" class="form-control" placeholder="Date of Birth" name="dob"
                                            id="dob" required autocomplete="off">

                                        <span id="lblError"
                                            style="color:Red"><?php echo $this->session->flashdata('dob_error'); ?></span>
                                        <div class="invalid-feedback">Please Enter Date of Birth</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Gender <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2 form-select" id="validationCustom04"
                                            name="gender" data-placeholder="Select Gender" required>
                                            <option value="">Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                            <option value="3">Prefer not to say</option>
                                        </select>
                                        <div class="invalid-feedback">Please select Gender</div>
                                    </div>

                                    <div class="form-group col-md-12 mb-0">
                                        <label class="form-label fw-bold">Enter Mobile Number <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <input type="tel" class="form-control"
                                            onkeypress="return /^-?[0-9]*$/.test(this.value+event.key)" minlength="10"
                                            maxlength="13" required name="mobile_number" placeholder="Mobile number"
                                            required id="mobile">
                                        <div class="invalid-feedback">Please Enter Mobile Number </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-0 select-dropdown1" id="">
                                        <label class="form-label fw-bold">Internship Type <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2 form-select" name="internshipType"
                                            data-placeholder="Internship Type" id="internshipType">

                                            <?php foreach ($taskType as $taskTypedata) { ?>
                                                <option value="<?php echo $taskTypedata['task_type_id']; ?>">
                                                    <?php echo $taskTypedata['task_type']; ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                        <span><b>please note offline and Hybrid internships are available only
                                                in Delhi, Mumbai, Kolkata, Bengaluru, please choose for these
                                                options</b></span>
                                        <div class="invalid-feedback">Please Select Type</div>
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Choose Country <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2-show-search" name="county" id="country_id"
                                            data-placeholder="Choose Country" required>
                                            <option selected disabled value="">Choose Countries</option>
                                            <?php foreach ($countries as $countrydata) { ?>
                                                <option value="<?php echo $countrydata['country_id']; ?>">
                                                    <?php echo $countrydata['Name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">Please select Country</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Current State <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2-show-search" name="state_id" id="state_name"
                                            data-placeholder="Current State" required>
                                            <option value="">Current State</option>

                                        </select>
                                        <div class="invalid-feedback">Please select State</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Current District/city/town/village
                                            (Resident/studying/work) <sup class="fs-3" style="color: red;">*</sup>
                                        </label>
                                        <select class="form-control select2-show-search" name="city_name" id="city_name"
                                            data-placeholder="Current Districts" required>
                                            <option value="">Current Districts </option>
                                        </select>
                                        <div class="invalid-feedback">Please select Districts</div>
                                    </div>

                                    <div class="form-group col-md-6 mb-0">
                                        <label class="form-label fw-bold">Choose Occupation <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2-show-search" name="occupation"
                                            id="occupation" data-placeholder="Choose Occupation..." required>
                                            <option selected disabled value="">Choose Occupation...</option>
                                            <?php foreach ($intoccupation as $occupationData) { ?>
                                                <option value="<?php echo $occupationData['occupation_id']; ?>">
                                                    <?php echo $occupationData['occupation_name']; ?>
                                                </option>

                                            <?php } ?>
                                        </select>

                                        <div class="invalid-feedback">Please select Occupation</div>
                                    </div>

                                    <div class="form-group col-md-12 mb-0 select-dropdown">
                                        <label class="form-label fw-bold">Type Of Volunteering <sup class="fs-3"
                                                style="color: red;">*</sup></label>

                                        <select class="form-control select2" name="volunteering_type"
                                            data-placeholder="Volunteer Type" id="volunteering_type">
                                            <option value="">Select Type Of...</option>
                                            <?php foreach ($taskType as $taskTypedata) { ?>
                                                <option value="<?php echo $taskTypedata['task_type_id']; ?>">
                                                    <?php echo $taskTypedata['task_type']; ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">Please select Volunteering Type</div>
                                    </div>

                                    <div class="form-group col-md-12 mb-0 select-dropdown">

                                        <label class="form-label fw-bold">Volunteership Skills <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2 form-select" name="skill_id[]" multiple
                                            required id="skill_id">
                                            <?php foreach ($skills as $skillsData) { ?>
                                                <option value="<?php echo $skillsData['skill_id']; ?>">
                                                    <?php echo $skillsData['skill_name']; ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">Please select Volunteership Skills</div>

                                    </div>

                                    <div class="form-group col-md-12 mb-0" id="otheroccupation">
                                        <label class="form-label fw-bold">Enter Other Occupation </label>
                                        <input type="text" class="form-control about this Opportunityl mt-2"
                                            name="otheroccupation" id="" placeholder="Enter Other Occupation">
                                        <div class="invalid-feedback">Please select Volunteering Type</div>
                                    </div>

                                    <div class="form-group col-md-12 mb-0">
                                        <label class="form-label fw-bold" for="where_know_opportunity">Where did you get
                                            to know about this Opportunity <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2-show-search" name="where_know_opportunity"
                                            id="where_know_opportunity" data-placeholder="Current Opportunity" required>
                                            <option selected disabled value="">Where did you get to know about this
                                                Opportunity</option>
                                            <?php foreach ($opportunity as $opportunityData) { ?>
                                                <option value="<?php echo $opportunityData['opportunity_id']; ?>">
                                                    <?php echo $opportunityData['opportunity_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">Please select an opportunity</div>
                                    </div>

                                    <div class="form-group col-md-12 mb-0" id="other_opportunity">
                                        <label class="form-label fw-bold">Other Where did you get to know about this
                                            Opportunity</label>
                                        <input type="text" class="form-control form-select about this Opportunityl mt-2"
                                            name="other_opportunity" placeholder="Enter Other Opportunity">
                                        <div class="invalid-feedback">Please select Opportunity</div>
                                    </div>



                                    <div class="form-group col-md-12 mb-0 select-dropdown1" id="">
                                        <label class="form-label fw-bold">Internship Duration <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2 form-select" name="internshipDeruation"
                                            data-placeholder="Internship Duration" id="internSkill_id">
                                            <option selected disabled value=""> Select Internship Duration</option>
                                            <?php for ($i = 4; $i <= 12; $i++) {
                                                if ($i % 2 === 0) { // check if the current number is even
                                                    echo '<option value="' . $i . '">' . $i . ' Weeks</option>';
                                                }
                                            } ?>
                                        </select>
                                        <div class="invalid-feedback">Please Select Duration</div>
                                    </div>
                                    <div class="form-group col-md-12 mb-0 select-dropdown1" id="">
                                        <label class="form-label fw-bold">Skills you posses <sup class="fs-3"
                                                style="color: red;">*</sup></label>
                                        <select class="form-control select2 form-select" name="skill_id[]" multiple
                                            required id="skill_id">
                                            <?php foreach ($skills as $skillsData) { ?>
                                                <option value="<?php echo $skillsData['skill_id']; ?>">
                                                    <?php echo $skillsData['skill_name']; ?>
                                                </option>

                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">Please Select Skills</div>
                                        <span><b>Please select 3 skills you are best at.</b></span>
                                    </div>

                                    <div class="form-group col-md-12 mb-0 select-dropdown1" id="">
                                        <div class="form-group" id="cv">
                                            <label class="form-label fw-bold">Upload Your CV <sup class="fs-3"
                                                    style="color: red;">*</sup><small><b>(Only PDF, Max
                                                        2MB)</b></small></label>
                                            <input type="file" name="Uploade_file" id="file" class="form-control"
                                                accept=".pdf" aria-label="file example" required>
                                            <span style="color: red; font-size: 12px; display: block; margin-top: 5px;"
                                                id="file_error"></span>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 mb-0" id="textarea1">
                                        <div class="">
                                            <label class="form-label fw-bold">Mention past volunteering and Internships
                                                you may have done? <sup class="fs-3" style="color: red;">*</sup></label>
                                            <textarea required class="form-control mb-4 myTextarea" name="mention_past"
                                                id="pastVolunteering" placeholder="Max 250 Character "
                                                rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-0" id="textarea2">
                                        <label class="form-label fw-bold">What you aim to value add on if chosen for an
                                            Internship with CRY ? <sup class="fs-3" style="color: red;">*</sup></label>
                                        <div class="">
                                            <textarea required class="form-control mb-4 myTextarea" name="whatyou_aim"
                                                id="youAim" placeholder="Max 250 Character" rows="3"></textarea>
                                        </div>
                                    </div>


                                    <div class="container-login100-form-btn">
                                        <button type="submit" name="preregistration" id="preregistration"
                                            class="login100-form-btn btn-warning">
                                            Submit
                                        </button>
                                    </div>

                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File validation - 2MB limit
        document.getElementById('file').addEventListener('change', function (e) {
            const file = this.files[0];
            const errorSpan = document.getElementById('file_error');
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes

            if (file) {
                // Check file type
                if (file.type !== 'application/pdf') {
                    errorSpan.innerHTML = '❌ Only PDF files are allowed!';
                    this.value = ''; // Clear the file input
                    this.classList.add('is-invalid');
                    return false;
                }

                // Check file size (2MB limit)
                if (file.size > maxSize) {
                    errorSpan.innerHTML = '❌ File size should not exceed 2MB! Your file size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB';
                    this.value = ''; // Clear the file input
                    this.classList.add('is-invalid');
                    return false;
                } else {
                    errorSpan.innerHTML = '✓ File is valid (PDF, ' + (file.size / 1024).toFixed(2) + 'KB)';
                    errorSpan.style.color = 'green';
                    this.classList.remove('is-invalid');
                    return true;
                }
            }
        });
    </script>

    <script>
        // Disable submit button on form submission to prevent double submission
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('sform');
            const submitBtn = document.getElementById('preregistration');
            const fileInput = document.getElementById('file');

            if (form && submitBtn) {
                form.addEventListener('submit', function (e) {
                    // Check file size again before submission
                    const file = fileInput.files[0];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (file) {
                        if (file.size > maxSize) {
                            e.preventDefault();
                            document.getElementById('file_error').innerHTML = '❌ File size should not exceed 2MB!';
                            document.getElementById('file_error').style.color = 'red';
                            alert('Please upload a file smaller than 2MB');
                            return false;
                        }
                        if (file.type !== 'application/pdf') {
                            e.preventDefault();
                            document.getElementById('file_error').innerHTML = '❌ Only PDF files are allowed!';
                            document.getElementById('file_error').style.color = 'red';
                            alert('Please upload only PDF files');
                            return false;
                        }
                    }

                    // Check if form is valid before disabling button
                    if (form.checkValidity()) {
                        // Disable the submit button
                        submitBtn.disabled = true;
                        // Change button text to show processing
                        submitBtn.innerHTML = 'Submitting... <i class="fa fa-spinner fa-spin"></i>';
                        submitBtn.style.opacity = '0.6';
                        submitBtn.style.cursor = 'not-allowed';
                    }
                });
            }
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"
        type="text/css" />
    <script>
        // Assuming you have included jQuery library
        $("#mobile").change(function () {
            let volType = $('#looking_for').val();
            if (volType == 'volunteering') {
                let mobile = $("#mobile").val();
                if (mobile !== "") {
                    datastr = {
                        mobile: mobile
                    };
                    $.ajax({
                        url: '<?php echo base_url() ?>volunteer-mobile-ajaxCheck',
                        type: 'post',
                        data: datastr,
                        success: function (response) {
                            if (response == 1) {
                                alert('Mobile already exists');
                                $("#mobile").val('');
                            }
                        }
                    });
                } else {
                    alert('Please enter mobile');
                }
            } else {
                let mobile = $("#mobile").val();
                if (mobile !== "") {
                    datastr = {
                        mobile: mobile
                    };
                    $.ajax({
                        url: '<?php echo base_url() ?>mobile-ajaxCheck',
                        type: 'post',
                        data: datastr,
                        success: function (response) {
                            if (response == 1) {
                                alert('Mobile already exists');
                                $("#mobile").val('');
                            }

                        }
                    });
                } else {
                    alert('Please enter mobile');
                }
            }


        });
    </script>


    <script>
        $(document).ready(function () {
            $('#resend').click(function () {
                var email = $('#email').val();
                var datastr = {
                    VOLUNTEEREMAIL: email
                };
                jQuery.ajax({
                    url: '<?php echo base_url(); ?>email-ajax-check',
                    type: 'post',
                    data: datastr,
                    success: function (data) {
                        //alert(data);	
                        if (data == 1) {
                            $('.email-verify-error').text('Email Already exits!');
                            $('#email').val('');
                            setTimeout(function () {
                                $('.email-verify-error').text('');
                            }, 4000);
                            $('#email').focus();
                            return false;

                        } else {
                            $('.enterOtp').show();
                            jQuery.ajax({
                                url: '<?php echo base_url(); ?>create-emailOtp',
                                type: 'post',
                                data: datastr,
                                success: function (data) {
                                    var trimStr = $.trim(data);
                                    //  alert(trimStr);
                                    //console.log(trimStr);
                                    $('#mailotp').val(trimStr);
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>


    <script>
        function validate() {
            $("#file_error").html("");
            $(".demoInputBox").css("border-color", "#F0F0F0");
            var fileInput = document.getElementById('file');
            var file = fileInput.files[0];
            var fileSizeLimit = 2 * 1024 * 1024; // 2MB in bytes
            if (!file) {
                $("#file_error").html("Please select a file");
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else if (file.type !== 'application/pdf') {
                fileInput.value = '';
                $("#file_error").html("Only PDF files are allowed");
                $('#file').attr('required', 'required');
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else if (file.size > fileSizeLimit) {
                fileInput.value = ''; // Clear the file input field
                $("#file_error").html("File size should not exceed 2MB");
                $('#file').attr('required', 'required');
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.myTextarea').on('input', function () {
                var maxLength = 250;
                var currentLength = $(this).val().length;
                var remainingLength = maxLength - currentLength;
                $('.charCount').text(remainingLength);
                if (remainingLength < 0) {
                    $(this).val($(this).val().substring(0, maxLength));
                    $('.charCount').text(0);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            $('#other_opportunity').hide();
            $('#where_know_opportunity').change(function () {

                let where_know_opportunity = $('#where_know_opportunity').val();

                if (where_know_opportunity == 8) {
                    $('#other_opportunity').show();
                } else {
                    $('#other_opportunity').hide();
                }

            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#verifyMail').on('click', function () {
                var otp = $('#mailotp').val();
                var cotp = $('#enterOtp').val();
                if (otp == cotp) {
                    $("#emailSection").css("display", "none");
                    $("#detailFormsection").css("display", "block");
                } else if (cotp == " " && otp == " ") {
                    alert('Please enter otp');
                    return false;
                } else {
                    alert('OTP not matched');
                    return false;
                }
            });
        });
    </script>

    <script>
        // Wait for the document to load
        document.addEventListener("DOMContentLoaded", function () {
            // Get the input element by its ID
            var inputElement = document.getElementById("mailotp");

            // Function to remove the value
            function removeValue() {
                inputElement.value = ""; // Set the value to an empty string
            }

            // Call the function initially
            removeValue();

            // Set an interval to call the function every 10 minutes (600,000 milliseconds)
            setInterval(removeValue, 600000);
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#otheroccupation').hide();
            $('#occupation').change(function () {
                let occupation = $('#occupation').val();
                if (occupation == 11) {
                    $('#otheroccupation').show();
                } else {
                    $('#otheroccupation').hide();
                }
            });

        });
    </script>

    <script>
        var count = 30; // Set the countdown timer to 30 seconds
        var countdownElem = document.getElementById("countdown"); // Get the countdown element
        var resendBtn = document.getElementById("resend"); // Get the resend button element
        document.getElementById('resend').style.display = 'none';

        function startCountdown() {
            countdownElem.innerHTML = "Resend OTP " + count + " sec";
            count--;
            if (count < 0) {
                clearTimeout(timer);
                countdownElem.innerHTML = "";
                resendBtn.style.display = "inline-block";
            } else {
                var timer = setTimeout(startCountdown, 1000);
            }
        }

        function resendOtp() {
            // Disable the resend button
            resendBtn.style.display = "none";
            count = 30;
            startCountdown();
            // Add your code to resend the OTP here
        }

        $(document).ready(function () {
            $('.Otp').hide();
            $('.resendOtp').hide();

            $('#genrateOTP').click(function () {
                let email = $('#email').val();
                var looking_for = $('#looking_for').val();
                var errorMessageElement = document.getElementById("error-message");

                // Email validation using regular expression
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    errorMessageElement.textContent = "Invalid email format";
                    return;
                }

                // Check if email has ".com" or ".org"
                var atIndex = email.indexOf('@');
                var dotIndex = email.lastIndexOf('.');
                var domain = email.substring(atIndex + 1, dotIndex);
                var endsWithDotCom = domain.toLowerCase() === 'com';
                var endsWithDotOrg = domain.toLowerCase() === 'org';

                if (endsWithDotCom || endsWithDotOrg) {
                    errorMessageElement.textContent = 'Email should not have ".com" or ".org"';
                    return;
                }

                if (email === "" && looking_for === "") {
                    errorMessageElement.textContent = "All fields are required";
                    return;
                } else if (email == "") {
                    errorMessageElement.textContent = "Please enter an email";
                    return;
                } else if (looking_for === "") {
                    errorMessageElement.textContent = "Please select what you are looking for";
                    return;
                } else {
                    errorMessageElement.textContent = ""; // Clear the error message
                }

                $('.email-verify-error').empty(); // Clear any previous error messages

                var datastr = {
                    VOLUNTEEREMAIL: email,
                    SINGLE: looking_for,
                };

                $.ajax({
                    url: '<?php echo base_url(); ?>email-ajax-check',
                    type: 'post',
                    data: datastr,
                    success: function (data) {
                        if (data == 1) {
                            alert('Email Already exits!');
                            $('#email').val('');
                            $('.email-verify-error').text('Email Already exists!');
                            $('#email').focus();
                            return false;
                        } else {
                            // Make the email field read-only
                            $('#email').prop('readonly', true);

                            $('.Otp').show();
                            $('.resendOtp').show();
                            $('#genrateOTP').hide();
                            $('#mailotp').val('');

                            // Start the countdown timer
                            startCountdown();

                            $.ajax({
                                url: '<?php echo base_url(); ?>create-emailOtp',
                                type: 'post',
                                data: datastr,
                                success: function (data) {
                                    var trimStr = $.trim(data);
                                    $('#mailotp').val(trimStr);
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function validate() {
            $("#file_error").html("");
            $(".demoInputBox").css("border-color", "#F0F0F0");
            var fileInput = document.getElementById('file');
            var file = fileInput.files[0];
            var fileSizeLimit = 2 * 1024 * 1024; // 2MB in bytes

            if (!file) {
                $("#file_error").html("Please select a file");
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else if (file.type !== 'application/pdf') {
                fileInput.value = '';
                $("#file_error").html("Only PDF files are allowed");
                $('#file').attr('required', 'required');
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else if (file.size > fileSizeLimit) {
                fileInput.value = ''; // Clear the file input field
                $("#file_error").html("File size should not exceed 2MB");
                $('#file').attr('required', 'required');
                $(".demoInputBox").css("border-color", "red");
                return false;
            } else {
                return true;
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            function handleLookingForChange() {
                let volunteerValue = $('#looking_for').val();
                if (volunteerValue == 'volunteering') {
                    $('.select-dropdown').show();
                    $('.select-dropdown1').hide();
                    $('#textarea1').hide();
                    $('#textarea2').hide();
                } else if (volunteerValue == 'internship') {
                    if (confirm(
                        'In an internship, we expect minimum 4-5 hours of work, for at least 4 consecutive weeks. Are you sure you would like to apply? \n Please note that CRY internship is unpaid.'
                    )) {
                        $('.select-dropdown').hide();
                        $('.select-dropdown1').show();
                        $('#textarea1').show();
                        $('#textarea2').show();
                    } else {
                        // User cancelled confirmation
                        $(location).attr('href', '#simple');
                        $('.select-dropdown').hide();
                    }
                } else {
                    $('.select-dropdown').hide();
                    $('.select-dropdown1').hide();
                    $('#textarea1').hide();
                    $('#textarea2').hide();
                }
            }

            // Call on page load
            handleLookingForChange();

            // Call on change event
            $('#looking_for').change(function () {
                handleLookingForChange();
            });

            $(".multiple").select2({
                placeholder: "Select a programming language",
                allowClear: true,
                maximumSelectionLength: 8
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            function checkVolunteeringType() {
                let volunteeringType = $('#looking_for').val();
                if (volunteeringType == 'internship') {
                    $('#skill_id').removeAttr("required");
                    // $('#internSkill_id').attr("required", true); // you commented this out, fix if needed
                    $('#where_know_opportunity').removeAttr("required");
                    $('#inputState').removeAttr("required");
                    $('#file').attr("required", true);
                } else {
                    // If you want, reset the requirements if not internship
                    $('#skill_id').attr("required", true);
                    // $('#internSkill_id').removeAttr("required");
                    $('#where_know_opportunity').attr("required", true);
                    $('#inputState').attr("required", true);
                    $('#file').removeAttr("required");
                }
            }

            // Run on page load
            checkVolunteeringType();

            // Run on change event
            $("#looking_for").change(function () {
                checkVolunteeringType();
            });
        });
    </script>



    <script type="text/javascript">
        $(function () {
            $('.txtNumeric').keydown(function (e) {
                if (e.ctrlKey || e.altKey) {
                    e.preventDefault();
                } else {
                    var key = e.keyCode;
                    if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >=
                        65 && key <= 90))) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

    <script>
        function reloadThePage() {
            window.location.reload();
        }
    </script>

    <script type='text/javascript'>
        var secondsBeforeExpire = 120;
        var timer = setInterval(function () {
            if (secondsBeforeExpire <= 0) {
                clearInterval(timer);
                $("#resend").prop('disabled', false);
                $("#time-remaining").hide();
            } else {
                secondsBeforeExpire--;
                $("#time-remaining").text(secondsBeforeExpire + "sec.");
            }
        }, 1000);
    </script>

    <!-- JQUERY JS -->
    <script>
        $(document).ready(function () {
            $("#internshipType").change(function () {
                var internshipType = $(this).val();
                var country_id = $('#country_id').val();
                datastr = {
                    country_id: country_id,
                    internshipType: internshipType
                };

                $.ajax({
                    url: '<?php echo base_url() ?>get-states',
                    type: 'post',
                    data: datastr,
                    success: function (response) {
                        $("#state_name").html(response);
                        $('select').selectpicker('refresh');
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            $("#country_id").change(function () {
                var country_id = $(this).val();
                var internshipType = $('#internshipType').val();
                datastr = {
                    country_id: country_id,
                    internshipType: internshipType
                };

                $.ajax({
                    url: '<?php echo base_url() ?>get-states',
                    type: 'post',
                    data: datastr,
                    success: function (response) {
                        $("#state_name").html(response);
                        $('select').selectpicker('refresh');
                    }
                });
            });

        });
    </script>


    <script>
        $(document).ready(function () {
            $("#state_name").change(function () {

                var state_id = $(this).val();
                var internshipType = $('#internshipType').val();
                // alert(state_id);
                datastr = {
                    state_id: state_id,
                    internshipType: internshipType
                };

                $.ajax({
                    url: '<?php echo base_url() ?>get-city',
                    type: 'post',
                    data: datastr,
                    success: function (response) {
                        $("#city_name").html(response);
                        $('select').selectpicker('refresh');
                    }
                });
            });

        });
    </script>

    <script>
        $(function () {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                // showOn: 'button',
                buttonImageOnly: false,
                buttonImage: '<?php echo base_url() ?>web/images/calendar.gif',
                dateFormat: 'dd-mm-yy',
                yearRange: '1900:+0',
                onSelect: function (dateString, txtDate) {
                    ValidateDOB(dateString);
                }
            });
        });

        function ValidateDOB(dateString) {
            var lblError = $("#lblError");
            var parts = dateString.split("-");
            var dtDOB = new Date(parts[1] + "-" + parts[0] + "-" + parts[2]);
            var dtCurrent = new Date();
            lblError.html("Eligibility 13 years ONLY.")
            if (dtCurrent.getFullYear() - dtDOB.getFullYear() < 13) {
                $('#dob').val('');
                return false;
            }

            if (dtCurrent.getFullYear() - dtDOB.getFullYear() == 13) {
                if (dtCurrent.getMonth() < dtDOB.getMonth()) {
                    $('#dob').val('');
                    return false;
                }
                if (dtCurrent.getMonth() == dtDOB.getMonth()) {
                    if (dtCurrent.getDate() < dtDOB.getDate()) {
                        $('#dob').val('');
                        return false;
                    }
                }
            }
            lblError.html("");
            return true;
        }
    </script>



    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    <script src="<?php echo base_url('admin/'); ?>assets/js/jquery.min.js"></script>

    <!-- BOOTSTRAP JS -->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>


    <!-- INTERNAL SELECT2 JS -->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/wysiwyag/jquery.richtext.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/wysiwyag/wysiwyag.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/quill/quill.min.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/js/themeColors.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/js/custom.js"></script>
    <!-----------select js-------------->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fileuploads/js/fileupload.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fileuploads/js/file-upload.js"></script>
    <!-- FILE UPLOADES JS -->
    <!-- INTERNAL File-Uploads Js-->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.fileupload.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/fancyuploder/fancy-uploader.js"></script>

    <!-- SELECT2 JS -->
      

    <!-- BOOTSTRAP-DATERANGEPICKER JS -->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- INTERNAL Bootstrap-Datepicker js-->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

    <!-- INTERNAL Sumoselect js-->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/sumoselect/jquery.sumoselect.js"></script>

    <!-- TIMEPICKER JS -->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/time-picker/jquery.timepicker.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/time-picker/toggles.min.js"></script>

    <!-- INTERNAL intlTelInput js-->
    <!-- <script src="<?php echo base_url('admin/'); ?>assets/plugins/intl-tel-input-master/intlTelInput.js"></script> -->
    <!-- <script src="<?php echo base_url('admin/'); ?>assets/plugins/intl-tel-input-master/country-select.js"></script> -->


    <!-- INTERNAL multi js-->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/multi/multi.min.js"></script>

    <!-- DATEPICKER JS -->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/date-picker/date-picker.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/date-picker/jquery-ui.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/input-mask/jquery.maskedinput.js"></script>

    <!-- MULTI SELECT JS-->
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/multipleselect/multiple-select.js"></script>
    <script src="<?php echo base_url('admin/'); ?>assets/plugins/multipleselect/multi-select.js"></script>

    <!-- FORMELEMENTS JS -->
    <!-- <script src="<?php echo base_url('admin/'); ?>assets/js/formelementadvnced.js"></script> -->
    <script src="<?php echo base_url('admin/'); ?>assets/js/form-elements.js"></script>



</body>

</html>