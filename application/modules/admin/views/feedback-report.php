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
<div class="modal fade daily-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-uppercase fw-bold">Submission Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="daily-report">
            </div>
        </div>
    </div>
</div>
<div class="main-content app-content mt-0">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Feedback Report</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>admin-dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Feedback Report</li>
                    </ol>
                </div>
                <div class="ms-auto pageheader-btn" id="flip">
                    <a href="javascript:void(0);"></a>
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="<?php echo base_url() ?>feedback-report" method="post">
                            <div class="card-header">
                                <div class="col-md-2">
                                    <select class="form-control select2-show-search form-select" name="cregion_id"
                                        id="region_id">
                                        <option value="">Select Region</option>
                                        <option value="99" <?php if ($regionId == 99) {
                                            echo "selected";
                                        } ?>>All</option>
                                        <?php foreach ($regions as $rd) { ?>
                                            <option value="<?php echo $rd['region_id']; ?>" <?php if ($regionId == $rd['region_id']) {
                                                   echo "selected";
                                               } ?>><?php echo $rd['region_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="cstate_name" id="state_name"
                                        class="form-control select2-show-search form-select">
                                        <option value="">All State</option>
                                        <?php foreach ($states as $sd) { ?>
                                            <option value="<?php echo $sd['state_id']; ?>" <?php echo ($state == $sd['state_id']) ? 'selected' : ''; ?>>
                                                <?php echo $sd['state_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" name="cdate_form" id="date_from" value="<?php echo $fromDate; ?>"
                                        class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <input type="date" name="cdate_to" id="date_to" value="<?php echo $toDate; ?>"
                                        class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <select name="crecords" class="form-control select2-show-search form-select">
                                        <option value="10" <?php echo $records == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="20" <?php echo $records == 20 ? 'selected' : '' ?>>20</option>
                                        <option value="50" <?php echo $records == 50 ? 'selected' : '' ?>>50</option>
                                        <option value="100" <?php echo $records == 100 ? 'selected' : '' ?>>100</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" name="submit" id="implementFilter" value="Filter"
                                        class="btn btn-warning form-control">
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="export" class="btn btn-success form-control"><i
                                                class="fa fa-download"></i> Export Filter Data</button>
                                    </div>
                                </div>
                                <div class="col-md-8"></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <a href="<?php echo base_url() ?>export-all-feedback-intern-report"><button
                                                type="button" id="exportAlll"
                                                class="btn btn-success form-control">Export All</i></button></a>
                                        <!-- <textarea id="allData" -->
                                            <!-- style="display:none;"><?php echo base64_encode(json_encode($allRecord, JSON_UNESCAPED_UNICODE)); ?></textarea> -->

                                        <textarea id="selectedIntern"
                                            style="display:none;"><?php echo base64_encode(json_encode($selectedIntern, JSON_UNESCAPED_UNICODE)); ?></textarea>



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

                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>

                                            <th>View Report</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($feedbackReport as $feedback) {
                                            $intern_id = $feedback['intern_id'];
                                            $encoded_id = rtrim(strtr(base64_encode($intern_id), '+/', '-_'), '='); ?>
                                            <tr>
                                                <td><?php echo ++$page; ?></td>
                                                <td><?php echo $feedback['first_name'] . ' ' . $feedback['last_name']; ?>
                                                </td>
                                                <td><?php echo $feedback['email']; ?></td>
                                                <td><?php echo $feedback['mobile']; ?></td>


                                                <td>
                                                    <li><a
                                                            href="<?php echo base_url() ?>view_rating/<?php echo $encoded_id; ?>">View
                                                            FeedBack</a></li>
                                                </td>
                                                <!-- <td> Action </td> -->
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
<script>
    $('#export').on('click', function (e) {
        e.preventDefault();
        let encodedData = $("#selectedIntern").val();
        let jsonString = atob(encodedData);  // decode base64 string
        try {
            let data = JSON.parse(jsonString);
            JSONToCSVConvertor(data, "Interns FeedBack Data", true);
        } catch (e) {
            console.error("Invalid JSON string", e);
            alert("Data export failed due to invalid data format.");
        }
    });

    // Export All button click
    document.getElementById("exportAll").addEventListener("click", function () {
        let base64Data = document.getElementById("allData").value.trim();

        // Step 1: Base64 decode
        let decodedData = atob(base64Data);

        // Step 2: JSON parse
        let jsonData = JSON.parse(decodedData);

        console.log(jsonData); // Ab yeh sahi array/object dega

        // Yaha se aap JSONToCSVConvertor ya apna export function call kar sakte ho
        JSONToCSVConvertor(jsonData, "Export_All", true);
    });

</script>
<script>
    $(document).ready(function () {
        $("#region_id").change(function () {
            var region_id = $(this).val();
            //alert(region_id);
            datastr = {
                region_id: region_id
            };

            $.ajax({
                url: '<?php echo base_url() ?>get-states-admin',
                type: 'post',
                data: datastr,
                success: function (response) {
                    $("#state_name").html(response);
                    // $('select').selectpicker('refresh');
                }
            });
        });

    });
</script>