<div class="modal fade profile-details" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title " id="exampleModalLabel">
                    Profile Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body row" id="profile_details" style="height:480px; overflow:scroll">
            </div>
            <div class="modal-footer bg-default">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <div>
                    <h1 class="page-title">
                        Applied Candidates</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard">Home</a></li>
                        <li class="breadcrumb-item active text-warning" aria-current="page">Applied Candidates</li>
                    </ol>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="<?php echo base_url() ?>applied-candidates" method="post" id="form">
                            <div class="card-header">
                            <div class="col-md-3">
                                <?php 
                                $regionId = $this->session->userdata('region_id'); 
                                $role = $this->session->userdata('role_id'); // Get role_id
                                ?>
                                
                                <label>Select Region</label> 
                                <i class="fa fa-info magic">
                                    <span class="magictext">Use this tab only if you wish to see region specific candidates</span>
                                </i>

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


                                <div class="col-md-2">
                                    <lable>Select State</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Use this tab only if you wish to see state specific candidates</span></i>
                                    <select class="form-control select2-show-search form-select" name="state_name" id="state_name">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $sd) { ?>
                                            <option value="<?php echo $sd['state_id']; ?>" <?php echo $state == $sd['state_id'] ? "selected" : ""; ?>>
                                                <?php echo $sd['state_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <lable>Select Status</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Select Status</span></i> <select class="form-control select2-show-search form-select" name="candidate_staus" id="candidate_staus">
                                        <option value="">Select Status</option>
                                        <option value="1">Onboarding-Candidate</option>
                                        <option value="2">Shortlisted</option>
                                        <option value="3">Interview Scheduled</option>
                                        <option value="11">Interview Ongoing</option>
                                        <option value="5">Interview Cleared</option>
                                        <option value="6">Sent Offer Letter</option>
                                        <option value="7">Registraion Completed</option>
                                        <option value="8">CRY intern</option>
                                        <option value="0">Candidate Rejected</option>

                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <lable>Select start date</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Select start date</span></i>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                        <input class="form-control fc-datepicker" name="start_new" value="<?php echo date("m/d/Y", strtotime($date_from)) ?>" required placeholder="To" id="toDate" type="text">
                                    </div>
                                </div>
                                <strong style="font-size: 15px; font:900">To</strong>
                                <div class="col-lg-2">
                                    <lable>Select end date</lable> &nbsp;<i class="fa fa-info magic"><span class="magictext">Select end date</span></i>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                        <input class="form-control fc-datepicker" name="end_new" value="<?php echo date("m/d/Y", strtotime($date_to)) ?>" required placeholder="From" id="fromDate" type="text">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group  p-0">
                                        <button type="submit" name="submit" id="searchData" class="input-group-text btn btn-warning">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="appliedCandidatesTable" class="display nowrap" style="width:100%">
                                    <thead class="bg-gray-light">
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Request Date</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Skill</th>
                                            <th>State</th>
                                            <th>Districts</th>
                                            <th>View CV</th>
                                            <th>More</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>



<script>
    function fetch_details(id, display_id) {
        //alert(id);
        $('#' + display_id).html(
            '<div class="text-center" style="color:red;margin:10 auto;"><i class="fa fa-spinner fa-pulse fa-4x"></i><p>Fetching Data</p></div>'
        );
        var request = $.ajax({
            url: '<?php echo base_url("fetch-user-info-intern"); ?>',
            method: "POST",
            data: {
                intern_id: id
            },
            success: function(results) {
                $('#' + display_id).html(results);
            }
        });
    }
</script>
<script>
    $(window).on('load', function() {
        var appliedCandidatesTable = $('#appliedCandidatesTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0, 8]
            }],
            ajax: {
                url: '<?php echo base_url("applied-candidates-list"); ?>',
                type: 'POST',
                data: function(data) {
                    $.each($('#form').serializeArray(), function(index, field) {
                        data[field.name] = field.value;
                    });
                }
            }
        });

        $('#form').on('submit', function(event) {
            event.preventDefault();
            appliedCandidatesTable.ajax.reload();
        });
    });
</script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

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
<!-- <script>
$(document).ready(function() {
    let region_id = $('#region_id').val();
    // alert(region_id);
    if (region_id != null) {
        $('#region_id option:not(:selected)').attr('disabled', true);
    }

});
</script> -->
