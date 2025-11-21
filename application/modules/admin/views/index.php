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
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-semibold">
                <i class="fa fa-filter me-2"></i> Dashboard Filter
            </h5>
        </div>

        <div class="card-body">
            <form action="<?php echo base_url() ?>admin-dashboard" method="post" id="dashboard-from">
                <div class="row g-3 align-items-end">

                    <!-- Region -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Region</label>
                        <?php 
                            $regionId = $this->session->userdata('region_id'); 
                            $role = $this->session->userdata('role_id');
                        ?>
                        <select class="form-control select2-show-search form-select" name="region_id" id="region_id">
                            <option disabled value="">Select Region</option>
                            <option value="99" 
                                <?php if ($regionId == '99') echo 'selected'; ?> 
                                <?php if ($role != 1) echo 'disabled'; ?>>
                                All
                            </option>
                            <?php foreach ($regions as $rd) { ?>
                                <option value="<?php echo $rd['region_id']; ?>"
                                    <?php if ($regionId == $rd['region_id']) echo 'selected'; ?>
                                    <?php if ($role != 1 && $regionId != $rd['region_id']) echo 'disabled'; ?>>
                                    <?php echo $rd['region_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- State -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">State</label>
                        <select class="form-control select2-show-search form-select" name="state_name" id="state_name">
                            <option value="">Select State</option>
                            <?php foreach ($states as $sd) { ?>
                                <option value="<?php echo $sd['state_id']; ?>" <?php echo $state == $sd['state_id'] ? "selected" : ""; ?>>
                                    <?php echo $sd['state_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- City -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">City</label>
                        <select class="form-control select2-show-search form-select" id="city_name" name="city_name">
                            <option value="">Select City</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Start Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa fa-calendar"></i></span>
                           <input type="date" name="start_new" class="form-control"
       value="<?php echo isset($date_from) ? $date_from : date('Y-m-d', strtotime('-30 days')); ?>">
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">End Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa fa-calendar"></i></span>
                           <input type="date" name="end_new" class="form-control"
       value="<?php echo isset($date_to) ? $date_to : date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="col-md-2 text-center">
                        <button class="btn btn-warning w-100 fw-semibold mt-2">
                            <i class="fa fa-search me-2"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


        <style>
    /* ==== Dashboard Card UI Enhancements ==== */
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        background: linear-gradient(135deg, #fff, #f8f9fa);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
        transition: 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(15deg) scale(1.1);
    }

    .stat-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #555;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #222;
        margin: 8px 0;
        animation: countUp 1.2s ease-in-out;
    }

    .stat-footer {
        font-size: 0.9rem;
        color: #777;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="row g-4 mt-3">
    

    <!-- Total Interns -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Total Interns</div>
                    <div class="stat-number internsmonthwise internsstatewise internsstatecitywise">
                        <?php echo $dashboardValue['total']; ?>
                    </div>
                
                </div>
                <div class="stat-icon bg-danger">
                    <i class="fe fe-rocket"></i>
                </div>
            </div>
        </div>
    </div>
<!-- Total Volunteer -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Total Volunteer</div>
                    <div class="stat-number active_volunteers"><?php echo $dashboardValuevol['total']; ?></div>
                   
                </div>
                <div class="stat-icon bg-primary">
                    <i class="fe fe-users"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Volunteer Task -->
    <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Volunteer Task</div>
                    <div class="stat-number"><?php echo $totalTaskvol['totsltaskVolunteer']; ?></div>
                    
                </div>
                <div class="stat-icon bg-success">
                    <i class="fe fe-clipboard"></i>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Interns Task -->
    <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="stat-card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-title">Interns Task</div>
                    <div class="stat-number"><?php echo $totalTask['totsltaskIntern']; ?></div>
                   
                </div>
                <div class="stat-icon bg-warning">
                    <i class="fe fe-briefcase"></i>
                </div>
            </div>
        </div>
    </div> -->
</div>

<script>
    // Simple count-up animation
    document.querySelectorAll('.stat-number').forEach(el => {
        const target = +el.innerText;
        el.innerText = '0';
        let count = 0;
        const update = setInterval(() => {
            count += Math.ceil(target / 60);
            if (count >= target) {
                el.innerText = target;
                clearInterval(update);
            } else {
                el.innerText = count;
            }
        }, 20);
    });
</script>


            <style>
  .intern-dashboard {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 25px 30px;
    font-family: "Poppins", sans-serif;
  }
  .intern-dashboard h4 {
    color: #222;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
  }
  .intern-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 10px;
  }
  .stat-box {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
  }
  .stat-box:hover {
    background: #ffeeba;
    transform: translateY(-4px);
  }
  .stat-box i {
    font-size: 30px;
    margin-bottom: 8px;
  }
  .stat-number {
    font-size: 26px;
    font-weight: 700;
    color: #111;
  }
  .stat-label {
    color: #555;
    font-size: 14px;
  }
</style>

<div class="intern-dashboard mt-3">
  <h4><i class="fa fa-users text-warning"></i> Internship Dashboard Overview</h4>

  <div class="intern-stats">
    <div class="stat-box">
      <i class="fa fa-user text-primary"></i>
      <div class="stat-number"><?php echo $dashboardValue['total']; ?></div>
      <div class="stat-label">Total Interns</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-male text-info"></i>
      <div class="stat-number"><?php echo $dashboardValue['male']; ?></div>
      <div class="stat-label">Male</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-female text-danger"></i>
      <div class="stat-number"><?php echo $dashboardValue['female']; ?></div>
      <div class="stat-label">Female</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-transgender text-secondary"></i>
      <div class="stat-number"><?php echo $dashboardValue['others']; ?></div>
      <div class="stat-label">Others</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-file text-dark"></i>
      <div class="stat-number"><?php echo $dashboardValue['total']; ?></div>
      <div class="stat-label">Total Applications</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-clock text-warning"></i>
      <div class="stat-number"><?php echo $pendingInterns['pendingApplication']; ?></div>
      <div class="stat-label">Pending Applications</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-check text-success"></i>
      <div class="stat-number"><?php echo $stillInters['activeApplication']; ?></div>
      <div class="stat-label">Active / Drop Off</div>
    </div>

    <div class="stat-box">
      <i class="fa fa-certificate text-primary"></i>
      <div class="stat-number"><?php echo $certificateInters['certifictaeIntern']; ?></div>
      <div class="stat-label">Finished Tenure</div>
    </div>
  </div>
</div>


           <div class="container mt-4">
  <div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header text-white fw-bold text-center" style="background-color:#FBC434;">
      Volunteer Dashboard
    </div>
    <div class="card-body">
      <div class="row text-center">

        <!-- Total Volunteer -->
        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-primary mb-0"><?php echo $dashboardValuevol['total']; ?></h3>
            <p class="mb-0">Total Volunteers</p>
          </div>
        </div>

        <!-- Male Volunteer -->
        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-info mb-0"><i class="fa fa-male"></i> <?php echo $dashboardValuevol['1']; ?></h3>
            <p class="mb-0">Male Volunteers</p>
          </div>
        </div>

        <!-- Female Volunteer -->
        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-danger mb-0"><i class="fa fa-female"></i> <?php echo $dashboardValuevol['2']; ?></h3>
            <p class="mb-0">Female Volunteers</p>
          </div>
        </div>

        <!-- Others Volunteer -->
        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-warning mb-0"><i class="fa fa-transgender"></i> <?php echo $dashboardValuevol['3']; ?></h3>
            <p class="mb-0">Others Volunteers</p>
          </div>
        </div>

        <!-- Pending / Active -->
        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-secondary mb-0"><?php echo $pendingvolunteersvol['pendingApplicationvol']; ?></h3>
            <p class="mb-0">Pending Applications</p>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="p-3 bg-light rounded-3 shadow-sm hover-card">
            <h3 class="fw-bold text-success mb-0"><?php echo $stillvolunteer['activeApplicationvol']; ?></h3>
            <p class="mb-0">Active Volunteers</p>
          </div>
        </div>

      </div>

      <!-- Certificates -->
      <div class="mt-4">
        <h5 class="fw-bold mb-3 text-center text-dark">Issued Certificates</h5>
        <div class="row text-center">
          <div class="col-md-3 mb-2"><div class="badge bg-bronze p-3 rounded-3">Bronze</div></div>
          <div class="col-md-3 mb-2"><div class="badge bg-silver p-3 rounded-3">Silver</div></div>
          <div class="col-md-3 mb-2"><div class="badge bg-gold p-3 rounded-3">Gold</div></div>
          <div class="col-md-3 mb-2"><div class="badge bg-dark text-white p-3 rounded-3">Platinum</div></div>
        </div>
      </div>
    </div>
  </div>
    </div>
  </div>
</div>

<style>
.hover-card {
  transition: all 0.3s ease-in-out;
}
.hover-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}
.bg-bronze {
  background-color: #cd7f32;
  color: white;
}
.bg-silver {
  background-color: #c0c0c0;
  color: black;
}
.bg-gold {
  background-color: #ffd700;
  color: black;
}
</style>


           <div class="row mt-5">
  <div class="col-lg-12">
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0">
          <i class="fa fa-users me-2"></i> Pending Volunteer Registration
        </h3>
      </div>

      <!-- Filter Section -->
      <div class="card-body border-bottom bg-light py-3">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h5 class="mb-0 text-dark fw-semibold"><i class="fa fa-filter me-2 text-danger"></i>Search Filters</h5>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <input type="text" class="form-control rounded-start" placeholder="Search volunteer...">
              <button class="btn btn-warning text-white rounded-end" type="button">Go!</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="bg-light text-dark">
              <tr>
                <th>Sn. No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Date of Birth</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; foreach ($volunteer as $key => $value) {
                $encode_userID = rtrim(strtr(base64_encode($value['volunteer_id']), "+/", "-_"), "=");
              ?>
              <tr class="table-row">
                <td><?php echo $i; ?></td>
                <td><?php echo $value['first_name'] . ' ' . $value['last_name']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['mobile']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($value['date_of_birth'])); ?></td>
                <td class="text-center">
                  <a href="<?php echo base_url(); ?>enquiry" class="btn btn-sm btn-outline-warning rounded-pill fw-semibold">
                    <i class="fa fa-eye me-1"></i> View
                  </a>
                </td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.table-row:hover {
  background-color: #fff9e6 !important;
  transition: background-color 0.3s ease-in-out;
}
.btn-outline-warning:hover {
  background-color: #ffc107;
  color: #fff !important;
}
.card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
}
</style>

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