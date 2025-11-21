<?php

use SebastianBergmann\Exporter\Exporter;

ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Intern_report extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        // if ($this->session->userdata('userID')) {
        //     if ($this->session->userdata('roleID') == 2) {
        //         echo '<script>window.location.href = "' . base_url() . 'dashboard"</script>';
        //     } else {
        //     }
        // } else {
        //     echo '<script>window.location.href = "' . base_url() . 'login"</script>';
        // }
        $CI = &get_instance();
        $CI->load->library('Get_library');
        $this->load->library('upload');
        $this->load->library('csvimport');
        //$this->load->library("PHPExcel");
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->model('crud/Crud_modal');
        $this->load->model('curl/Curl_model');
        $this->load->model('users/User_model');
        $this->load->model('admin/Admin_model');
        $this->load->library('Phpmailer');
        $this->load->library('Fpdf_gen');

        date_default_timezone_set('Asia/Kolkata');
    }


    public function pre_registration_intern_report()
    {
        try {
            if ($this->session->userdata('emp_id') != 'NULL' && $this->session->userdata('emp_id') != '') {
                //    print_r($_POST);exit; //
                $this->session->set_userdata($this->input->post());
                $regions = $this->input->post('region_id') != '' ? $this->input->post('region_id') : $this->session->userdata('region_id');
                $state = $this->input->post('state_name') != '' ? $this->input->post('state_name') : $this->session->userdata('state_name');
                $status = $this->input->post('status') != '' ? $this->input->post('status') : $this->session->userdata('status');
                $fromDate = $this->input->post('date_form') != '' ? $this->input->post('date_form') : $this->session->userdata('date_form');
                $toDate = $this->input->post('date_to') != '' ? $this->input->post('date_to') : $this->session->userdata('date_to');
                $records = $this->input->post('records') != '' ? $this->input->post('records') : ($this->session->userdata('records') != '' ? $this->session->userdata('records') : 10);
                if ($regions != "" && $state != "" && $status != "" && $fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['status'] = $status;
                    $data['regions'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '" and int.state_id="' . $state . '" and int.status="' . $status . '" ';
                } elseif ($regions != "" && $status != "" && $fromDate != "" && $toDate != "") {
                    if ($regions == '99') {
                        $date1 = $this->input->post('date_form');
                        $date2 = $this->input->post('date_to');
                        $data['status'] = $status;
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['states'] = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '" AND int.status="' . $status . '"';
                    } else {
                        $regions = $this->input->post('region_id');
                        $status = $this->input->post('status');
                        $states = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $date1 = $this->input->post('date_form');
                        $date2 = $this->input->post('date_to');
                        $data['status'] = $status;
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $where = "int.creation_date>='" . $fromDate . "' AND int.creation_date<='" . $toDate . "' AND int.state_id IN ($stateIds) AND int.status = '" . $status . "'";
                    }
                } elseif ($regions != "" && $state != "" && $fromDate != "" && $toDate != "") {

                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['status'] = '';
                    $data['regions'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '" and int.state_id="' . $state . '" ';
                } else if ($this->input->post('region_id') != "") {
                    $regionId = $this->input->post('region_id');
                    if ($regionId == '99') {
                        $date1 = $this->input->post('date_form');
                        $date2 = $this->input->post('date_to');
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '" AND int.status!=99';
                    } else {
                        $regionId = $this->input->post('region_id');
                        $states = $this->Crud_modal->all_data_select(
                            'state_id',
                            'states',
                            "region_id='$regionId'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $date1 = $this->input->post('date_form');
                        $date2 = $this->input->post('date_to');
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $where = "int.creation_date>='" . $fromDate . "' AND int.creation_date<='" . $toDate . "' AND int.state_id IN ($stateIds)";
                    }
                } elseif ($status != "" && $fromDate != "" && $toDate != "") {

                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['status'] = $status;
                    $data['regions'] = '';
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '" and int.status="' . $status . '" ';
                } elseif ($fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '"';
                } else {

                    $toDate = date('Y-m-d');
                    $fromDate = date('Y-m-d', strtotime('-30 days'));
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.creation_date>="' . $fromDate . '" and int.creation_date<="' . $toDate . '"';
                }

                $data['selectedIntern'] = $selectedIntern = $this->Admin_model->intern_pre_registration_report($where);
               
                //    echo json_encode($data['selectedIntern']);exit;
                $data['allRecord'] = $this->Admin_model->All_record_intern_pre_registration_report();

                $config = array();
                $config["base_url"] = base_url('pre-registration-intern-report');
                $config["total_rows"] = count($selectedIntern);
                $config["per_page"] = $records;
                $config['uri_protocol'] = 'AUTO';
                $config['enable_query_strings'] = TRUE;
                $config['reuse_query_string'] = TRUE;
                $config['num_links'] = 4;
                $config['cur_tag_open'] = '&nbsp;<a class="current">';
                $config['cur_tag_close'] = '</a>';
                $config['next_link'] = 'Next';
                $config['prev_link'] = 'Previous';
                $this->pagination->initialize($config);
                $page = $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
                $str_links = $this->pagination->create_links();
                $data["links"] = explode('&nbsp;', $str_links);
                $data['intern'] = $this->Admin_model->All_intern_pre_registration_report($config["per_page"], $page, $where);

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('pre-registration-intern-report', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }


    public function shortlisted_intern()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));

                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=2)";
                        $data['intern'] = $this->Admin_model->intern_pre_registration_report($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));

                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=2)";
                        $data['intern'] = $this->Admin_model->intern_pre_registration_report($where);
                    }
                }
                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('shortlisted-intern', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    public function post_registration_intern_report()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));

                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=6)";
                        $data['intern'] = $this->Admin_model->intern_pre_registration_report($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));

                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=6)";
                        $data['intern'] = $this->Admin_model->intern_pre_registration_report($where);
                    }
                }
                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('post-registration-intern-report', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function all_onboard_intern()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));
                    $where = 'i.status =7';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "" && $this->input->post('region_id') != "") {
                        $data['state'] = $state_name = $this->input->post('state_name');
                        $data['region_id'] = $region_id = $this->input->post('region_id');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        //$data['region_id'] = $region_id;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=7)";
                        $data['intern'] = $this->Admin_model->intern_enquiry_Data($where);
                        // echo "<pre>";
                        // print_r($data['volunteer']);exit;
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));
                    $where = 'i.status =7';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('state_name') != "") {
                        $data['state'] = $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and i.state_id=" . $state_name . "  and (i.status=7)";
                        $data['intern'] = $this->Admin_model->intern_enquiry_Data($where);
                    }
                }

                $data['email_templates'] = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=4');
                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('all-onboard-intern', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function intern_assign_task_report()
    {

        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));
                    // $where = 'status =1';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('taskType') != "") {
                        $taskType = $this->input->post('taskType');
                        $taskName = $this->input->post('taskName');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['assigned_date'] = $date1;
                        $data['assigned_date'] = $date2;
                        $data['taskType'] = $taskType;
                        $where = "assigned_date>='" . $date_from . "' and assigned_date<='" . $date_to . "' AND ias.intern_task_id=" . $taskName . "  and (ias.status=1)";
                        $data['internDetails'] = $this->Admin_model->assign_task_intern_taskType($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-7 days'));

                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" && $this->input->post('taskType') != "") {
                        $taskType = $this->input->post('taskType');
                        $taskName = $this->input->post('taskName');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['assigned_date'] = $date1;
                        $data['assigned_date'] = $date2;
                        $data['taskType'] = $taskType;
                        $where = "assigned_date>='" . $date_from . "' and assigned_date<='" . $date_to . "' AND ias.intern_task_id=" . $taskName . "  and (ias.status=1)";
                        $data['internDetails'] = $this->Admin_model->assign_task_intern_taskType($where);
                    }
                }
                $data['taskType'] = $this->Crud_modal->fetch_all_data('*', 'task_type', 'status = 1');
                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('intern-assign-task-report', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function intern_certificate_report()
    {
        try {
            if ($this->session->userdata('emp_id') != 'NULL' && $this->session->userdata('emp_id') != '') {
                // echo "<pre>";
                // print_r($_POST);die;
                $this->session->set_userdata($this->input->post());
                $regions = $this->input->post('cregion_id') != '' ? $this->input->post('cregion_id') : $this->session->userdata('cregion_id');
                $state = $this->input->post('cstate_name') != '' ? $this->input->post('cstate_name') : $this->session->userdata('cstate_name');
                $fromDate = $this->input->post('cdate_form') != '' ? $this->input->post('cdate_form') : $this->session->userdata('cdate_form');
                $toDate = $this->input->post('cdate_to') != '' ? $this->input->post('cdate_to') : $this->session->userdata('cdate_to');
                $records = $this->input->post('crecords') != '' ? $this->input->post('crecords') : ($this->session->userdata('crecords') != '' ? $this->session->userdata('crecords') : 10);
                if ($regions != "" && $state != "" && $fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regionId'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" and int.state_id="' . $state . '" ';
                } elseif ($regions != "" && $fromDate != "" && $toDate != "") {
                    if ($regions == '99') {
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $data['states'] = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                    } else {
                        $states = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $where = "int.modification_date>='" . $fromDate . "' AND int.modification_date<='" . $toDate . "' AND int.state_id IN ($stateIds)";
                    }
                } elseif ($regions != "" && $state != "" && $fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regionId'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" and int.state_id="' . $state . '" ';
                } else if ($this->input->post('region_id') != "") {
                    if ($regionId == '99') {
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                    } else {
                        $states = $this->Crud_modal->all_data_select(
                            'state_id',
                            'states',
                            "region_id='$regionId'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regions'] = $regions;
                        $where = "int.modification_date>='" . $fromDate . "' AND int.modification_date<='" . $toDate . "' AND int.state_id IN ($stateIds)";
                    }
                } elseif ($fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regions'] = '';
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" ';
                } elseif ($fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                } else {
                    $toDate = date('Y-m-d');
                    $fromDate = date('Y-m-d', strtotime('-30 days'));
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                }

                $data['selectedIntern'] = $selectedIntern = $this->Admin_model->intern_certificate_report_export($where);
                $data['allRecord'] = $this->Admin_model->intern_certificate_report_export_all();

                $config = array();
                $config["base_url"] = base_url('sent-certificate');
                $config["total_rows"] = count($selectedIntern);
                $config["per_page"] = $records;
                $config['uri_protocol'] = 'AUTO';
                $config['enable_query_strings'] = TRUE;
                $config['reuse_query_string'] = TRUE;
                $config['num_links'] = 4;
                $config['cur_tag_open'] = '&nbsp;<a class="current">';
                $config['cur_tag_close'] = '</a>';
                $config['next_link'] = 'Next';
                $config['prev_link'] = 'Previous';
                $this->pagination->initialize($config);
                $page = $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
                $str_links = $this->pagination->create_links();
                $data["links"] = explode('&nbsp;', $str_links);
                $data['intern'] = $this->Admin_model->intern_certificate_report($config["per_page"], $page, $where);

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('sent-certificate', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function get_data()
    {
        $data = $this->db->get('')->result_array();
        return $data;
    }

    public function export_excel()
    {
        // Load PHPExcel library
        $this->load->library('PHPExcel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set the active worksheet to the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Retrieve data from database
        $data = $this->get_data();

        // Add column headers
        $col = 'A';
        foreach ($data[0] as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue($col . '1', $key);
            $col++;
        }

        // Add data rows
        $row = 2;
        foreach ($data as $rowData) {
            $col = 'A';
            foreach ($rowData as $cellData) {
                $objPHPExcel->getActiveSheet()->setCellValue($col . $row, $cellData);
                $col++;
            }
            $row++;
        }

        // Set filename and download as Excel file
        $filename = 'data.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function export_pre_registration_intern_report()
    {
        $empId = $this->session->userdata('role_id');
        if (empty($empId)) {
            redirect(base_url('login'), 'refresh');
            return;
        }

        // ✅ Admin (ID = 1) => All records
        if ((int) $empId === 1) {
            $records = $this->Admin_model->All_record_intern_pre_registration_report();
        } else {
            // ✅ Regional Manager => filter by region's states
            $region = $this->session->userdata('region_id');

            $states = $this->Crud_modal->all_data_select(
                'state_id',
                'states',
                "region_id='$region'",
                'state_name ASC'
            );

            $stateIds = array_column($states, 'state_id');

            if (empty($stateIds)) {
                $records = [];
            } else {
                // Create WHERE condition for states
                $stateIdsStr = '"' . implode('","', $stateIds) . '"';
                $where = "int.state_id IN ($stateIdsStr)";

                $records = $this->Admin_model->All_record_intern_pre_registration_report($where);
            }
        }

        // ✅ Normalize
        if (!is_array($records)) {
            $records = [];
        }

        // ✅ Prepare CSV filename
        $filename = "Intern_PreRegistration_" . date('Y-m-d_H-i-s') . ".csv";

        // ✅ Send headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

        if (!empty($records)) {
            $header = array_keys($records[0]);
            fputcsv($output, $header);

            foreach ($records as $row) {
                $line = [];
                foreach ($header as $col) {
                    $line[] = isset($row[$col]) ? $row[$col] : '';
                }
                fputcsv($output, $line);
            }
        } else {
            $defaultHeader = ['FirstName', 'Lastname', 'Email', 'Mobile', 'State', 'City', 'RegistrationDate', 'Status'];
            fputcsv($output, $defaultHeader);
        }

        fclose($output);
        exit;
    }
    public function export_feedback_intern_report()
    {
        $empId = $this->session->userdata('role_id');
        if (empty($empId)) {
            redirect(base_url('login'), 'refresh');
            return;
        }

        // ✅ Admin (ID = 1) => All records
        if ((int) $empId === 1) {
            $records = $this->Admin_model->intern_feedback_report_export_all();
        } else {
            // ✅ Regional Manager => filter by region's states
            $region = $this->session->userdata('region_id');

            $states = $this->Crud_modal->all_data_select(
                'state_id',
                'states',
                "region_id='$region'",
                'state_name ASC'
            );

            $stateIds = array_column($states, 'state_id');

            if (empty($stateIds)) {
                $records = [];
            } else {
                // Create WHERE condition for states
                $stateIdsStr = '"' . implode('","', $stateIds) . '"';
                $where = "int.state_id IN ($stateIdsStr)";

                $records = $this->Admin_model->intern_feedback_report_export_all($where);
            }
        }

        // ✅ Normalize
        if (!is_array($records)) {
            $records = [];
        }

        // ✅ Prepare CSV filename
        $filename = "Intern_feedback_" . date('Y-m-d_H-i-s') . ".csv";

        // ✅ Send headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

        if (!empty($records)) {
            $header = array_keys($records[0]);
            fputcsv($output, $header);

            foreach ($records as $row) {
                $line = [];
                foreach ($header as $col) {
                    $line[] = isset($row[$col]) ? $row[$col] : '';
                }
                fputcsv($output, $line);
            }
        } else {
            $defaultHeader = ['FirstName', 'Lastname', 'Email', 'Mobile', 'State', 'City', 'RegistrationDate', 'Status'];
            fputcsv($output, $defaultHeader);
        }

        fclose($output);
        exit;
    }
    public function export_sent_certificate_intern_report()
    {
        $empId = $this->session->userdata('role_id');
        if (empty($empId)) {
            redirect(base_url('login'), 'refresh');
            return;
        }

        // ✅ Admin (ID = 1) => All records
        if ((int) $empId === 1) {
            $records = $this->Admin_model->intern_certificate_report_export_all();
        } else {
            // ✅ Regional Manager => filter by region's states
            $region = $this->session->userdata('region_id');

            $states = $this->Crud_modal->all_data_select(
                'state_id',
                'states',
                "region_id='$region'",
                'state_name ASC'
            );

            $stateIds = array_column($states, 'state_id');

            if (empty($stateIds)) {
                $records = [];
            } else {
                // Create WHERE condition for states
                $stateIdsStr = '"' . implode('","', $stateIds) . '"';
                $where = "int.state_id IN ($stateIdsStr)";

                $records = $this->Admin_model->intern_certificate_report_export_all($where);
            }
        }

        // ✅ Normalize
        if (!is_array($records)) {
            $records = [];
        }

        // ✅ Prepare CSV filename
        $filename = "Intern_sent_certificate_" . date('Y-m-d_H-i-s') . ".csv";

        // ✅ Send headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

        if (!empty($records)) {
            $header = array_keys($records[0]);
            fputcsv($output, $header);

            foreach ($records as $row) {
                $line = [];
                foreach ($header as $col) {
                    $line[] = isset($row[$col]) ? $row[$col] : '';
                }
                fputcsv($output, $line);
            }
        } else {
            $defaultHeader = ['FirstName', 'Lastname', 'Email', 'Mobile', 'State', 'City', 'RegistrationDate', 'Status'];
            fputcsv($output, $defaultHeader);
        }

        fclose($output);
        exit;
    }


    public function feedback_report()
    {
        try {
            if ($this->session->userdata('emp_id') != 'NULL' && $this->session->userdata('emp_id') != '') {
                // echo "<pre>";
                // print_r($_POST);die;
                $this->session->set_userdata($this->input->post());
                $regions = $this->input->post('cregion_id') != '' ? $this->input->post('cregion_id') : $this->session->userdata('cregion_id');
                $state = $this->input->post('cstate_name') != '' ? $this->input->post('cstate_name') : $this->session->userdata('cstate_name');
                $fromDate = $this->input->post('cdate_form') != '' ? $this->input->post('cdate_form') : $this->session->userdata('cdate_form');
                $toDate = $this->input->post('cdate_to') != '' ? $this->input->post('cdate_to') : $this->session->userdata('cdate_to');
                $records = $this->input->post('crecords') != '' ? $this->input->post('crecords') : ($this->session->userdata('crecords') != '' ? $this->session->userdata('crecords') : 10);
                if ($regions != "" && $state != "" && $fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regionId'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" and int.state_id="' . $state . '" ';
                } elseif ($regions != "" && $fromDate != "" && $toDate != "") {
                    if ($regions == '99') {
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $data['states'] = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                    } else {
                        $states = $this->Crud_modal->all_data_select(
                            'state_id,state_name',
                            'states',
                            "region_id='$regions'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $where = "int.modification_date>='" . $fromDate . "' AND int.modification_date<='" . $toDate . "' AND int.state_id IN ($stateIds)";
                    }
                } elseif ($regions != "" && $state != "" && $fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regionId'] = $regions;
                    $data['state'] = $state;
                    $data['records'] = $records;
                    $data['states'] = $this->Crud_modal->all_data_select(
                        'state_id,state_name',
                        'states',
                        "region_id='$regions'",
                        'state_name ASC'
                    );
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" and int.state_id="' . $state . '" ';
                } else if ($this->input->post('region_id') != "") {
                    if ($regionId == '99') {
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regionId'] = $regions;
                        $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                    } else {
                        $states = $this->Crud_modal->all_data_select(
                            'state_id',
                            'states',
                            "region_id='$regionId'",
                            'state_name ASC'
                        );
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $data['toDate'] = $toDate;
                        $data['fromDate'] = $fromDate;
                        $data['regions'] = $regions;
                        $where = "int.modification_date>='" . $fromDate . "' AND int.modification_date<='" . $toDate . "' AND int.state_id IN ($stateIds)";
                    }
                } elseif ($fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['regions'] = '';
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '" ';
                } elseif ($fromDate != "" && $toDate != "") {
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                } else {
                    $toDate = date('Y-m-d');
                    $fromDate = date('Y-m-d', strtotime('-30 days'));
                    $data['toDate'] = $toDate;
                    $data['fromDate'] = $fromDate;
                    $data['state'] = '';
                    $data['records'] = $records;
                    $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                    $where = 'int.modification_date>="' . $fromDate . '" and int.modification_date<="' . $toDate . '"';
                }

                $data['selectedIntern'] = $selectedIntern = $this->Admin_model->intern_feedback_report_export($where);
                $data['allRecord'] = $this->Admin_model->intern_feedback_report_export_all();

                $config = array();
                $config["base_url"] = base_url('feedback-report');
                $config["total_rows"] = count($selectedIntern);
                $config["per_page"] = $records;
                $config['uri_protocol'] = 'AUTO';
                $config['enable_query_strings'] = TRUE;
                $config['reuse_query_string'] = TRUE;
                $config['num_links'] = 4;
                $config['cur_tag_open'] = '&nbsp;<a class="current">';
                $config['cur_tag_close'] = '</a>';
                $config['next_link'] = 'Next';
                $config['prev_link'] = 'Previous';
                $this->pagination->initialize($config);
                $page = $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
                $str_links = $this->pagination->create_links();
                $data["links"] = explode('&nbsp;', $str_links);
                $data['feedbackReport'] = $this->Admin_model->intern_feedback_report($config["per_page"], $page, $where);

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');
                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('feedback-report', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

}

