<style>
    .card {
        position: relative;
        margin-bottom: 1.5rem;
        width: 100%;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"
    integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Intern List</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Intern List</li>
                    </ol>
                </div>
                <div class="ms-auto pageheader-btn" id="flip">
                    <a href="javascript:void(0);"></a>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="<?php echo base_url() ?>pre-registration-intern-report" method="post">
                            <div class="card-header">
                            <div class="col-md-2">
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
                                    <select class="form-control select2-show-search form-select" name="status"
                                        id="status">
                                        <option value="">Select Status</option>
                                        <option value="1" <?php echo ($status == "1") ? "selected" : ""; ?>>Pre
                                            Registration</option>
                                        <option value="2" <?php echo ($status == "2") ? "selected" : ""; ?>>Shortlisted
                                        </option>
                                        <option value="6" <?php echo ($status == "6") ? "selected" : ""; ?>>Sent
                                            confirmation letter</option>
                                        <option value="7" <?php echo ($status == "7") ? "selected" : ""; ?>>Post
                                            Registration Completed</option>
                                        <option value="8" <?php echo ($status == "8") ? "selected" : ""; ?>>Onboarded
                                            Intern</option>
                                    </select>

                                </div>

                                <div class="col-md-2">
                                    <input type="date" name="date_form" id="date_from" value="<?php echo $fromDate; ?>"
                                        class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="date" name="date_to" id="date_to" value="<?php echo $toDate; ?>"
                                        class="form-control">
                                </div>
                                <div class="col-md-1">
                                    <select name="records" class="form-control select2-show-search form-select">
                                        <option value="10" <?php echo $records == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="20" <?php echo $records == 20 ? 'selected' : '' ?>>20</option>
                                        <option value="50" <?php echo $records == 50 ? 'selected' : '' ?>>50</option>
                                        <option value="100" <?php echo $records == 100 ? 'selected' : '' ?>>100</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="submit" name="submit" id="implementFilter" value="Filter"
                                        class="btn btn-warning form-control">
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="export" class="btn btn-success form-control"><i
                                                class="fa fa-download"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-8"></div>
                               <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="exportAll" class="btn btn-success form-control">Export
                                            All</i></button>
                                    <textarea id="allData" style="display:none;"><?php echo base64_encode(json_encode($allRecord, JSON_UNESCAPED_UNICODE)); ?></textarea>
									
 <textarea id="exportData" style="display:none;"><?php echo base64_encode(json_encode($allRecord, JSON_UNESCAPED_UNICODE)); ?></textarea>


                                      
                                    </div>
									
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="myDataTable" class="table table-striped mydatatable">
                                    <thead>
                                        <tr class="bg-gray-light">
                                            <th>S.No.</th>
                                            <th>Registration Date</th>
                                            <th>Name</th>
                                            <th>Date Of Birth</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Gender</th>
                                            <th>State</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($intern as $in) { ?>
                                            <tr>
                                                <td><?php echo ++$page; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($in['creation_date'])); ?></td>
                                                <td><?php echo $in['first_name']; ?><?php echo $in['last_name']; ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($in['date_of_birth'])); ?></td>

                                                <td><?php echo $in['email']; ?></td>
                                                <td><?php echo $in['mobile']; ?></td>
                                                <td><?php echo $in['Gender']; ?></td>
                                                <td><?php echo $in['state_name']; ?></td>
                                                <td>
                                                    <span class="badge rounded-pill bg-info me-1 mb-1 mt-1">
                                                        <?php echo $this->Admin_model->check_report_status($in['status']); ?>

                                                    </span>

                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php foreach ($links as $link) { ?>
                                        <li><span class="pagi"><?php echo $link; ?></span></li>
                                    <?php } ?>
                                </ul>
                            </nav>
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
<style>
    .pagi a {
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $('#export').on('click', function (e) {
    e.preventDefault();
    let data = $("#exportData").val();

    // Agar ye data already JSON string hai to seedha use kar sakte ho
    JSONToCSVConvertor(data, "Interns Data", true);
});

$('#exportAll').on('click', function (e) {
    e.preventDefault();
    try {
        let base64Data = $("#allData").val();
        let jsonString = atob(base64Data);
        let data = JSON.parse(jsonString);
        JSONToCSVConvertor(JSON.stringify(data), "All Interns Data", true);
    } catch (error) {
        console.error("JSON parse error:", error);
        alert("Data export failed due to invalid data format.");
    }
});

</script>
<script>
    $(document).ready(function() {

        // Function to fetch states
        function fetchStates(region_id) {
            var datastr = {
                region_id: region_id
            };

            $.ajax({
                url: '<?php echo base_url() ?>get-states-admin',
                type: 'post',
                data: datastr,
                success: function(response) {
                    $("#state_name").html(response);
                    $('select').selectpicker('refresh');  // If you're using selectpicker
                }
            });
        }

        // Trigger AJAX on region change
        $("#region_id").change(function() {
            var region_id = $(this).val();
            fetchStates(region_id);
        });

        // Trigger AJAX on page load for the initial region_id (if any)
        var initialRegionId = $("#region_id").val();
        if (initialRegionId) {
            fetchStates(initialRegionId);
        }
    });
</script>