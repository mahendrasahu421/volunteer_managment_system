<style>
.card {
    position: relative;
    margin-bottom: 1.5rem;
    width: 100%;
}
#success_msg {
    color: black;
    margin-bottom: 15px;
    font-size: 20px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css"
    integrity="sha512-0nkKORjFgcyxv3HbE4rzFUlENUMNqic/EzDIeYCgsKa/nwqr2B91Vu/tNAu4Q0cBuG4Xe/D1f/freEci/7GDRA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Profile Details Modal -->
<div class="modal fade profile-details" id="exampleModal1" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profile Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>×</span></button>
            </div>
            <div class="modal-body row" id="profile_details"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="main-content app-content mt-0">
    <div class="side-app">
        <div class="main-container container-fluid">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Request for Certificate</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Request for Certificate</li>
                    </ol>
                </div>
                <div class="ms-auto pageheader-btn">
                    <div class="count-checkboxes-wrapper fs-6">
                        <span id="count-checked-checkboxes">0</span> checked
                    </div>
                </div>
            </div>

            <!-- Email Template Modal -->
            <!-- Modal -->
                   <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editUpdateModal" tabindex="-1" aria-labelledby="editUpdateModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUpdateModalLabel">Edit Email Content</h5>
              
            </div>
            <div class="modal-body">
                <form id="emailEditForm">
                    <input type="hidden" id="internId" name="internId">
                    <input type="hidden" id="emailContentValue" name="emailContentValue">

                    <div class="mb-3">
                        <textarea id="emailContent" name="emailContent" rows="15" class="form-control"></textarea>
                    </div>

                    <button type="submit" id="saveOfferLatter" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



            <input type="hidden" value="<?php echo $feedbackCertifecate[0]['email'];?>" id="interncertificateEmail">
            <p id="success_msg"></p>

            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="intern-request-certificate" method="post" id="form">
                            <div class="card-header d-flex flex-wrap gap-2">
                                <!-- Region Dropdown -->
                                <div class="col-md-3">
                                    <?php 
                                        $regionId = $this->session->userdata('region_id'); 
                                        $role = $this->session->userdata('role_id');
                                    ?>
                                    <select class="form-control select2-show-search" name="region_id" id="region_id">
                                        <option disabled value="">Select Region</option>
                                        <option value="99" <?php if ($regionId == '99') echo 'selected'; ?> <?php if ($role != 1) echo 'disabled'; ?>>All</option>
                                        <?php foreach ($regions as $rd) { ?>
                                            <option value="<?= $rd['region_id']; ?>"
                                                <?= ($regionId == $rd['region_id']) ? 'selected' : ''; ?>
                                                <?= ($role != 1 && $regionId != $rd['region_id']) ? 'disabled' : ''; ?>>
                                                <?= $rd['region_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-md-3">
                                    <select class="form-control select2-show-search" name="state_name" id="state_name">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $sd) { ?>
                                            <option value="<?= $sd['state_id']; ?>" <?= ($state == $sd['state_id']) ? "selected" : ""; ?>>
                                                <?= $sd['state_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Date Pickers -->
                                <div class="col-md-2">
                                    <input class="form-control fc-datepicker" name="start_new"
                                        value="<?= date("m/d/Y", strtotime($date_from)) ?>" required placeholder="From" type="text">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control fc-datepicker" name="end_new"
                                        value="<?= date("m/d/Y", strtotime($date_to)) ?>" required placeholder="To" type="text">
                                </div>

                                <!-- Search Button -->
                                <div class="col-md-2">
                                    <button type="submit" name="submit" id="searchData" class="btn btn-warning w-100">Search</button>
                                </div>
                            </div>
                        </form>

                        <!-- Certificate Table -->
                        <form method="post" action="send_orientation_emails" id="id-form">
                            <input type="hidden" id="ids" name="ids">
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="example" class="display" width="100%">
    <thead>
        <tr class="bg-gray-light">
            <th><input class="che" id="chkParent" type="checkbox"></th>
            <th>Reg. Date</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>State</th>
            <th>Districts</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feedbackCertifecate as $internData):
            $encoded_id = rtrim(strtr(base64_encode($internData['intern_id']), '+/', '-_'), '=');
        ?>
        <tr>
            <td><input class="che" value="<?= $internData['intern_id']; ?>" type="checkbox"></td>
            <td><?= date("d-m-Y", strtotime($internData['creation_date'])); ?></td>
            <td>
                <?= ucwords($internData['first_name'] . ' ' . $internData['last_name']); ?><br>
                <a href="#" data-bs-toggle="modal" data-bs-target=".profile-details"
                    onclick="fetch_details('<?= $encoded_id; ?>','profile_details');">
                    <small class="text-primary">(View Profile)</small></a>
            </td>
            <td><?= $internData['mobile']; ?></td>
            <td><?= $internData['state_name']; ?></td>
            <td><?= $internData['city_name']; ?></td>
            <td><?= $internData['email']; ?></td>
            <td>
                <!-- Edit And Update button -->
                <button 
                    type="button" 
                    class="btn btn-primary edit-update-btn"
                    data-id="<?= $internData['intern_id']; ?>"
                    data-content="<?= htmlspecialchars($internData['email_content'], ENT_QUOTES, 'UTF-8'); ?>"
                    data-bs-toggle="modal" 
                    data-bs-target="#editUpdateModal"
                    style="padding: 1% 2% 1% 2%;">
                    Edit And Update
                </button>

                <?php if(trim($internData['certificate_email']) == ""): ?>
                    <button class="btn btn-warning" disabled>Preview</button>
                    <button class="btn btn-info" disabled>Send Certificate</button>
                <?php else: ?>
                    <a href="<?= base_url("view_certificate/{$encoded_id}") ?>" class="btn btn-warning" target="_blank">Preview</a>
                    <?php if ($internData['status'] == 3): ?>
                        <a href="<?= base_url("send_certificate_on_mail/{$encoded_id}") ?>" class="btn btn-warning" target="_blank">Already Sent</a>
                    <?php else: ?>
                        <a href="<?= base_url("send_certificate_on_mail/{$encoded_id}") ?>" class="btn btn-info" target="_blank">Send Certificate</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                                    <input type="hidden" name="emailContentValue" id="emailContentValue">
                                </div>
                            </div>
                        </form>
                        <!-- <input type="hidden" id="offerInternId"> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    let ckeditorInstance = null;
    let emailContentToLoad = '';

    // Initialize CKEditor on page load
    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#emailContent'))
            .then(editor => {
                ckeditorInstance = editor;
            })
            .catch(error => {
                console.error('CKEditor init error:', error);
            });
    });

    // When edit button is clicked
    document.querySelectorAll('.edit-update-btn').forEach(button => {
        button.addEventListener('click', function () {
            const internId = this.getAttribute('data-id');
            const emailContent = this.getAttribute('data-content');
            
            const decoded = decodeHtml(emailContent);

            document.getElementById('internId').value = internId;
            document.getElementById('emailContentValue').value = decoded;

            emailContentToLoad = decoded;

            // Open modal
            const modal = new bootstrap.Modal(document.getElementById('editUpdateModal'));
            
            modal.show();
        });
    });

    // When modal is fully shown
    document.getElementById('editUpdateModal').addEventListener('shown.bs.modal', function () {
        setTimeout(() => {
            if (ckeditorInstance) {
                ckeditorInstance.setData(emailContentToLoad);
            }
        }, 200); // Small delay to allow modal to fully render
    });

    // Decode function
    function decodeHtml(html) {
        const txt = document.createElement('textarea');
        txt.innerHTML = html;
        return txt.value;
    }
</script>


<script>
    $('#saveOfferLatter').click(function(e) {
        e.preventDefault(); // Prevent default form submission

        var intern_id = $('#internId').val();
        var emialcontent = ckeditorInstance.getData(); // ✅ Get updated data from CKEditor
        // alert(emialcontent)
        console.log('intern_id:', intern_id);
        console.log('emailContent:', emialcontent);

        var datastr = {
            intern_id: intern_id,
            emialcontent: emialcontent
        };

        $.ajax({
            url: '<?php echo base_url() ?>update_certificate_data',
            type: 'post',
            data: datastr,
            success: function(response) {
                alert('Update Success');
                $('#editUpdateModal').modal('hide'); // Correct modal ID
                window.location.reload(true);
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
                console.log(xhr.responseText);
            }
        });
    });
</script>




<script>
function getId_sendmail(internEmail) {
    var intern_sendId = internEmail;
    var emailContentValue = $('#emailContentValue').val();

    if (emailContentValue == "") {
        alert('Please Check Mail Format');
        return false;
    }
    datastr = {
        intern_sendId: internEmail,
        emailContentValue: emailContentValue
    };

    $.ajax({
        url: '<?php echo base_url() ?>send_orientation_emails',
        type: 'post',
        data: datastr,
        success: function(response) {
            $('#success_msg').html('Orientation Mail Sent Successfully');

        }
    });

}
</script>

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
            // console.log(results);
            //alert(results);
            $('#' + display_id).html(results);

        }
    });
}
</script>

<script>
let example = $('#example').DataTable({
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }],
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    order: [
        [1, 'asc']
    ]
});
example.on("click", "th.select-checkbox", function() {
    if ($("th.select-checkbox").hasClass("selected")) {
        example.rows().deselect();
        $("th.select-checkbox").removeClass("selected");
    } else {
        example.rows().select();
        $("th.select-checkbox").addClass("selected");
    }
}).on("select deselect", function() {
    ("Some selection or deselection going on")
    if (example.rows({
            selected: true
        }).count() !== example.rows().count()) {
        $("th.select-checkbox").removeClass("selected");
    } else {
        $("th.select-checkbox").addClass("selected");
    }
});
</script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
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



<script>
$(document).on('click', '#submit3', function() {
    var matches = [];
    var table = $('#file-datatable').dataTable();
    var checkedcollection = table.$(".che:checked", {
        "page": "all"
    });
    checkedcollection.each(function(index, elem) {
        matches.push($(elem).val());
    });
    var AccountsJsonString = JSON.stringify(matches);
    console.log(AccountsJsonString);
    alert(AccountsJsonString);
    $('#ids').val(AccountsJsonString);
    $('#id-form').submit();
});
</script>

<script>
$(document).ready(function() {
    $('#chkParent').click(function() {
        var isChecked = $(this).prop("checked");
        $('#example tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
    });

    $('#example tr:has(td)').find('input[type="checkbox"]').click(function() {
        var isChecked = $(this).prop("checked");
        var isHeaderChecked = $("#chkParent").prop("checked");
        if (isChecked == false && isHeaderChecked)
            $("#chkParent").prop('checked', isChecked);
        else {
            $('#example tr:has(td)').find('input[type="checkbox"]').each(function() {
                if ($(this).prop("checked") == false)
                    isChecked = false;
            });
            console.log(isChecked);
            $("#chkParent").prop('checked', isChecked);
        }
    });
});


$(document).ready(function() {
    var $checkboxes = $('#id-form td input[type="checkbox"]');
    $checkboxes.change(function() {
        var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
        $('#count-checked-checkboxes').text(countCheckedCheckboxes);
        $('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
    });
});
</script>