<!---- Sidebar with Icons & Working Active Highlight ---->
<?php
$current_url = uri_string(); // Full current URL path like 'admin/intern-report'
$base_url = base_url('admin/');
$this->load->helper('sidebardata_helper');
$alldata = get_permission();

$mapping_role_data = $alldata[0] ?? [];
$master_menu = $alldata[1] ?? [];
$master_sub_menu = $alldata[2] ?? [];
$master_sub_sub_menu = $alldata[3] ?? [];
$rid = $this->session->userdata('admin_role');

$submenu = [];
$subsubmenu = [];
$menuid = [];
?>

<style>
    .side-menu__item.active,
    .slide-item.active {
        color: #fbc434 !important;
        /* background: #fbc434 !important; */
        /* border-radius: 0 60px 60px 0;
        box-shadow: 0 7px 12px 0 var(--primary02); */
    }
</style>

<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="<?= base_url('admin-dashboard'); ?>">
                <img src="<?= $base_url; ?>assets/images/brand/cry-yellowlogo.png" class="header-brand-img desktop-logo" alt="logo">
                <img src="<?= $base_url; ?>assets/images/brand/cry-yellowlogo.png" class="header-brand-img toggle-logo" alt="logo">
                <img src="<?= $base_url; ?>assets/images/brand/cry-yellowlogo.png" class="header-brand-img light-logo" alt="logo">
                <img src="<?= $base_url; ?>assets/images/brand/cry-yellowlogo.png" class="header-brand-img light-logo1" alt="logo">
            </a>
        </div>

        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>

            <ul class="side-menu">
                <li class="sub-category"><h3>Main</h3></li>

                <!-- Dashboard -->
                <li class="slide">
                    <a class="side-menu__item <?= (strpos($current_url, 'admin-dashboard') !== false) ? 'active' : ''; ?>" 
                        href="<?= base_url('admin-dashboard'); ?>">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- ✅ Dynamic Menu from DB -->
                <?php
                foreach ($mapping_role_data as $menudata) {
                    $menu = explode('&&', $menudata['menu_master_id']);
                    foreach ($menu as $menuBlock) {
                        $menu_data = explode('|', $menuBlock);
                        if (!empty($menu_data[0])) {
                            $menuid[] = $menu_data[0];
                        }
                        foreach ($menu_data as $item) {
                            $sub = explode('$', $item);
                            if (!empty($sub[0]) && !empty($sub[1])) {
                                if (empty($sub[2])) {
                                    $submenu[] = $item;
                                } else {
                                    $subsubmenu[] = $item;
                                }
                            }
                        }
                    }
                }

                foreach ($menuid as $mid) {
                    $menu_detail = $this->Crud_modal->all_data_select(
                        'menu_description,menu_route_name',
                        'master_menu',
                        "menu_id = '$mid'",
                        'menu_id ASC'
                    );

                    if (!empty($menu_detail)) {
                        $menu_route = trim($menu_detail[0]['menu_route_name']);
                        $isActive = (strpos($current_url, $menu_route) !== false) ? 'active' : '';
                ?>
                        <li class="slide">
                            <a class="side-menu__item <?= $isActive; ?>" data-bs-toggle="slide"
                                href="<?= ($menu_route == '#') ? '#' : base_url($menu_route); ?>">
                                <i class="side-menu__icon fe fe-database"></i>
                                <span class="side-menu__label"><?= $menu_detail[0]['menu_description']; ?></span>
                                <i class="angle fa fa-angle-right"></i>
                            </a>

                            <ul class="slide-menu">
                                <?php
                                foreach ($submenu as $subItem) {
                                    $submenuid = explode('$', $subItem);
                                    if ($submenuid[0] == $mid) {
                                        $sid = $submenuid[1];
                                        $sub_menu_detail = $this->Crud_modal->all_data_select(
                                            'sub_menu_route,sub_menu_description',
                                            'master_sub_menu',
                                            "sub_menu_id = '$sid' and menu_id = '$mid'",
                                            'sub_menu_id ASC'
                                        );
                                        if (!empty($sub_menu_detail)) {
                                            $sub_route = trim($sub_menu_detail[0]['sub_menu_route']);
                                            $subActive = (strpos($current_url, $sub_route) !== false) ? 'active' : '';
                                ?>
                                            <li>
                                                <a href="<?= base_url($sub_route); ?>" 
                                                   class="slide-item <?= $subActive; ?>">
                                                    <?= $sub_menu_detail[0]['sub_menu_description']; ?>
                                                </a>
                                            </li>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                <?php
                    }
                }
                ?>

                <!-- Program Volunteer -->
                <li class="slide">
                    <a class="side-menu__item <?= (strpos($current_url, 'program') !== false) ? 'active' : ''; ?>" 
                        data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-briefcase"></i>
                        <span class="side-menu__label">Program Volunteer</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?= base_url('program-list'); ?>" class="slide-item">Add Program</a></li>
                        <li><a href="<?= base_url('share-link'); ?>" class="slide-item">Share Link</a></li>
                        <li><a href="<?= base_url('volunteer-list'); ?>" class="slide-item">Volunteer List</a></li>
                        <li><a href="<?= base_url('issue-certificate'); ?>" class="slide-item">Issue Certificate</a></li>
                    </ul>
                </li>

                <!-- Transfer Request -->
                <li class="slide">
                    <a class="side-menu__item <?= (strpos($current_url, 'transfer') !== false) ? 'active' : ''; ?>" 
                        data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-shuffle"></i>
                        <span class="side-menu__label">Transfer Request</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?= base_url('voleentur-transfer-table'); ?>" class="slide-item">Volunteer Transfer Request</a></li>
                        <li><a href="<?= base_url('other_region_volunteer'); ?>" class="slide-item">Other Region Volunteer</a></li>
                        <li><a href="<?= base_url('transfer-table'); ?>" class="slide-item">Intern Transfer Request</a></li>
                        <li><a href="<?= base_url('other_region_intern'); ?>" class="slide-item">Other Region Intern</a></li>
                    </ul>
                </li>

                <!-- Volunteer Report Section -->
                <li class="slide">
                    <a class="side-menu__item <?= (strpos($current_url, 'volunteer') !== false) ? 'active' : ''; ?>" 
                        data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-bar-chart"></i>
                        <span class="side-menu__label">Volunteer Section Report</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?= base_url('pre-registration-volunteer-report'); ?>" class="slide-item">Pre Registration</a></li>
                        <li><a href="<?= base_url('post-registration-volunteer-report'); ?>" class="slide-item">Post Registration</a></li>
                        <li><a href="<?= base_url('onboard-volunteer'); ?>" class="slide-item">Onboard Volunteer</a></li>
                        <li><a href="<?= base_url('volunteer-task-report'); ?>" class="slide-item">Task Report</a></li>
                        <li><a href="<?= base_url('volunteer-assign-task'); ?>" class="slide-item">Assign Task Report</a></li>
                        <li><a href="<?= base_url('volunteer-certificate-report'); ?>" class="slide-item">Certificate Report</a></li>
                        <li><a href="<?= base_url('volunteer-self-task-daily-report'); ?>" class="slide-item">Self Task Report</a></li>
                        <li><a href="<?= base_url('volunteer-transfer-report'); ?>" class="slide-item">Transfer Report</a></li>
                    </ul>
                </li>

                <!-- Intern Report Section -->
                <li class="slide">
                    <a class="side-menu__item <?= (strpos($current_url, 'intern') !== false) ? 'active' : ''; ?>" 
                        data-bs-toggle="slide" href="javascript:void(0);">
                        <i class="side-menu__icon fe fe-user-check"></i>
                        <span class="side-menu__label">Intern Section Report</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?= base_url('pre-registration-intern-report'); ?>" class="slide-item">Pre Registration</a></li>
                        <li><a href="<?= base_url('feedback-report'); ?>" class="slide-item">Feedback Report</a></li>
                        <li><a href="<?= base_url('intern-task-report'); ?>" class="slide-item">Task Report</a></li>
                        <li><a href="<?= base_url('intern-assign-task-report'); ?>" class="slide-item">Assign Task Report</a></li>
                        <li><a href="<?= base_url('sent-certificate'); ?>" class="slide-item">Certificate Report</a></li>
                        <li><a href="<?= base_url('intern-transfer-report'); ?>" class="slide-item">Transfer Report</a></li>
                    </ul>
                </li>
            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </aside>
</div>
