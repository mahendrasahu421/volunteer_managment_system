<style>
    #basic-addon2 {
        width: 100px;
        height: 40px;
    }
</style>
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Final Submission Report</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Final Submission Report</li>
                    </ol>
                </div>
            </div>
            <?php if ($this->session->userdata('data_message')) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successfull!</strong> Submission Report Has Been Inserted.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $this->session->unset_userdata('data_message');
            } ?>
            <div class="card">
                <form autocomplete="off" method="post" action="<?php echo base_url() ?>insert_submission_report"
                    enctype="multipart/form-data">
                    <div class="card-header bg-warning">
                        <h3 class="card-title text-white">Add Submission Report</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Task <span
                                        class="text-danger">*</span></label>
                                <?php foreach ($assign_taskIntern as $task) { ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="tasktitle[]"
                                            value="<?php echo $task['task_id']; ?>" required>
                                        <label class="form-check-label"><?php echo $task['task_title']; ?></label>
                                    </div>
                                <?php } ?>
                                <?php if (empty($assign_taskIntern)) { ?>
                                    <p class="text-danger">No Task Available</p>
                                <?php } ?>
                                <?php echo form_error('tasktitle[]', '<div class="error text-danger">', '</div>'); ?>
                            </div>


                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Write Project
                                    Description <span style="color:red; font-size:20px;">*</span>
                                    <small><b>(Enter Max 500 character)</b>
                                        <p>Characters remaining: <span id="charCount">500</span></p>
                                    </small></label>
                                <textarea class="form-control" placeholder="How Could it be Improved" rows="3"
                                    name="projectDescription" id="myTextarea" required></textarea>
                            </div>
                            <b>To upload files more than 15MB or video you can use your google drive to upload heavy
                                files and share the link here with full access.
                            </b>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-form-label"><b>Add Report, Images, Documents,
                                            etc. </b>
                                        <span style="color:red; font-size:20px;">*</span>
                                        <div class="field_wrapper">
                                            <input type="file" class="form-control img profileImageFormForTask" required
                                                name="attecment[]" id="#img" accept="" multiple />
                                            <label for="#"></label>

                                        </div>

                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary add_button"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                </div>

                            </div>


                        </div>

                        <br>

                        <?php
                        if (empty($lastIddata)) { ?>
                            <div>
                                <div class="col-md-12">
                                    <h2>Submit Feedback</h2>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Name of the Department you interned
                                        in (mark the primary one in terms of time spent if you worked with more than one).
                                        CHECK WITH YOUR MENTOR IF YOU ARE UNSURE WHICH DEPARTMENT YOU WERE A PART OF<span
                                            style="color:red; font-size:20px;">*</span></small></label>
                                    <select class="form-control select2" id="exampleFormControlSelect1"
                                        name="name_of_theDepartment" required>
                                        <!-- <option value="" selected disabled>Name & Address of the Institution (If Applicable)</option> -->
                                        <option value="VE">VE- Volunteer Engagement </option>
                                        <option value="DS">Programs</option>
                                        <option value="GM">Grant Management </option>
                                        <option value="RG">RG- Resource Generation</option>
                                        <option value="PRAD/MA">Research and Knowledge Exchange</option>
                                        <option value="Communications">Communications</option>
                                        <option value="People and Culture">People and Culture</option>
                                        <option value="BZ/Admin">BZ/Admin</option>
                                        <option value="GRM/Planning">GRM/Planning</option>
                                        <option value="Finance">Finance</option>
                                        <option value="IT">IT</option>
                                        <option value="others">Others</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Which Course are you currently
                                        pursuing ?
                                        <span style="color:red; font-size:20px;">*</span></small></label>
                                    <select class="form-control select2" id="exampleFormControlSelect1"
                                        name="subjectPursuing" required>
                                        <option value="" selected disabled>Which Course are you currently pursuing ?
                                        </option>
                                        <option value="Law">Law</option>
                                        <option value="Economics/statistics/Mathematics">Economics/statistics/Mathematics
                                        </option>
                                        <option value="MBA">MBA</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Mass media/journalism">Mass media/journalism</option>
                                        <option value="Design/ Graphics/ multimedia">Design/ Graphics/ multimedia</option>
                                        <option value="Pure Science">Pure Science</option>
                                        <option value="Humanities">Humanities</option>
                                        <option value="Social work">Social work</option>
                                        <option value="Language">Language</option>
                                        <option value="BBA/BCA">MCA/BCA</option>
                                        <option value="Commerce">Commerce</option>
                                        <option value="others">Others</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label"> Which VE region were you a part of ?

                                        <span style="color:red; font-size:20px;">*</span></small></label>
                                    <select class="form-control select2" id="exampleFormControlSelect1" name="whichvaregion"
                                        required>
                                        <option value="" selected disabled>Which VE Region were you a part of ?
                                        </option>
                                        <option value="VE East Region ">VE East Region </option>
                                        <option value="VE North Region ">VE North Region </option>
                                        <option value="VE West ">VE West </option>
                                        <option value="VE South ">VE South </option>
                                        <option value="HO">HO </option>


                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Name of your CRY Mentor
                                        <input type="hidden" name="submissionassign_task"
                                            value="<?php echo $assign_taskIntern[0]['keyword']; ?>" />
                                        <span style="color:red; font-size:20px;">*</span></label>
                                    <input type="text" class="form-control" name="mentorsname" value=""
                                        id="dailyReportTimeIn" placeholder="Name of your CRY Mentor" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Name & address of your academic
                                        institution (write NA if not applicable)”
                                        <span style="color:red; font-size:20px;">*</span></label>
                                    <input type="text" class="form-control" name="intern_institution" value=""
                                        id="dailyReportTimeIn" placeholder="Name & address of your academic institution"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">City of Internship (choose online if
                                        you
                                        worked from remote)
                                        <span style="color:red; font-size:20px;">*</span></small></label>
                                    <select class="form-control select2" id="exampleFormControlSelect1"
                                        name="cityInternship" required>
                                        <option value="" selected disabled>City of Internship</option>
                                        <option value="delhi">Delhi</option>
                                        <option value="mumbai">Mumbai</option>
                                        <option value="Kolkata">Kolkata</option>
                                        <option value="bengaluru">Bengaluru</option>
                                        <option value="Pune">Pune</option>
                                        <option value="hyderabad">Hyderabad</option>
                                        <option value="Online">Online</option>


                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Nature of assignment (choose the
                                        primary
                                        theme if you handled more than one)
                                        <span style="color:red; font-size:20px;">*</span></small></label>
                                    <select class="form-control select2 form-select" name="natureofAssignment[]" multiple
                                        required id="natureofAssignment">
                                        <option disabled value="">Select KeyWord</option>
                                        <?php foreach ($skills as $skillsData) { ?>
                                            <option value="<?php echo $skillsData['skill_id']; ?>">
                                                <?php echo $skillsData['skill_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>





                    </div>
                    <div class="col-md-12">
                        <?php if (empty($lastIddata)) { ?>

                            <button id="submit" name="submit" value="submit" class="btn btn-warning pull-right mb-3 mt-5"
                                <?php if (empty($assign_taskIntern))
                                    echo 'disabled'; ?>>
                                Next
                            </button>
                        <?php } else { ?>
                            <?php if (empty($assign_taskIntern)) { ?>
                                <p class="text-danger">No Task Available</p>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary mt-2" <?php if (empty($assign_taskIntern))
                                echo 'disabled'; ?>>
                                Submit
                            </button>
                        <?php } ?>
                    </div>


            </div>
        </div>
        </form>

    </div>
</div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#natureofAssignment').on('change', function () {
            var selectedOptions = $('#natureofAssignment').val();

            if (selectedOptions.length > 2) {
                alert('You can only select a maximum of 2 options.');
                // Remove the last selected option
                $(this).val($(this).val().slice(0, -1));
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#myTextarea').on('input', function () {
            var maxLength = 500;
            var currentLength = $(this).val().length;
            var remainingLength = maxLength - currentLength;
            $('#charCount').text(remainingLength);
            if (remainingLength < 0) {
                $(this).val($(this).val().substring(0, maxLength));
                $('#charCount').text(0);
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".profileImageFormForTask").on('change', function () {
            var fileInput = $(this);
            var files = fileInput[0].files;
            var fileSizeLimit = 2 * 1024 * 1024; // 2MB in bytes

            // Check file size for each selected file
            for (var i = 0; i < files.length; i++) {
                var fileSize = files[i].size;

                if (fileSize > fileSizeLimit) {
                    fileInput.val(''); // Clear the file input field
                    alert('File size should not exceed 2MB');
                    break;
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#Others_assignment').css('display', 'none');
        $('#assignment').change(function () {
            let assignment = $('#assignment').val();
            if (assignment == 'other') {
                $('#Others_assignment').css('display', 'block');
            } else {
                $('#Others_assignment').css('display', 'none');
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML =
            '<div class="addblockclick"><br>  <input type="file" name="attecment[]" accept=".pdf" value="" placeholder="Phone"/> <a href="javascript:void(0);" class="remove_button profileImageFormForTask">X</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function () {

            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function (e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>