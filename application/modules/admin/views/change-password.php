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
                            Change Password</li>
                    </ol>
                </div>
            </div>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-header bg-warning">
                            Change Password</h3>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" action="<?php echo base_url('update-password'); ?>"
                                method="post" name="form" id="form" novalidate>
                                <div class="form-row">
                                    <div class="form-group col-md-12 mb-0">
                                        <label class="form-label fw-bold">Current Password</label>
                                        <input type="password" class="form-control" name="old_password" required>
                                    </div>

                                    <div class="form-group col-md-12 mb-0">
                                        <label class="form-label fw-bold">New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>

                                    <div class="form-group col-md-12 mb-0">
                                        <label class="form-label fw-bold">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password" required>
                                    </div>

                                    <button class="btn btn-warning mt-5" type="submit">Submit</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>