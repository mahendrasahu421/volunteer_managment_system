<?php

use SebastianBergmann\Exporter\Exporter;

ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class volunteer extends MY_Controller
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

    public function enquiry()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                // $this->session->set_userdata($this->input->post());
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =1 OR v.status =2';
                    if ($this->input->post('start_new') != ""  && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "" && $this->input->post('region_id') != "") {
                        $data['state'] =  $state_name = $this->input->post('state_name');
                        $data['region_id'] =  $region_id = $this->input->post('region_id');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "v.creation_date>='" . $date_from . "' and v.creation_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status=1 OR v.status=2)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        if ($regionId == '99') {
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['creation_date'] = $date1;
                            $data['creation_date'] = $date2;
                            $where = "v.creation_date>='" . $date_from . "' and v.creation_date<='" . $date_to . "' AND v.status!=99";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        } else {
                            $regionId = $this->input->post('region_id');
                            $states = $this->Crud_modal->all_data_select(
                                'state_id',
                                'states',
                                "region_id='$regionId'",
                                'state_name ASC'
                            );
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['creation_date'] = $date1;
                            $data['creation_date'] = $date2;
                            $where = "v.creation_date>='" . $date_from . "' AND v.creation_date<='" . $date_to . "' AND v.state_id IN ($stateIds)  AND v.status != 8";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        }
                    } else if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['state_name'] = $state_name;
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.creation_date >= "' . $fromDate . '" AND v.creation_date <= "' . $toDate . '" AND v.state_id = "' . $state_name . '"';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else {
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.creation_date >= "' . $fromDate . '" AND v.creation_date <= "' . $toDate . '"';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =1 OR v.status =2';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $data['state'] =   $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "creation_date>='" . $date_from . "' and creation_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status=1 OR v.status=2)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$regionId'", 'state_name ASC');
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['creation_date'] = $date1;
                        $data['creation_date'] = $date2;

                        $where = "creation_date >= '$date_from' AND creation_date <= '$date_to' AND (v.status = 1 OR v.status = 2) AND v.state_id in ($stateIds)";

                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                }

                $data['email_templates'] = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=4');

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');

                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('enquiry', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function ragistration_volunteer()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                // $this->session->set_userdata($this->input->post());
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =2 OR v.status =3';
                    if ($this->input->post('start_new') != ""  && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "" && $this->input->post('region_id') != "") {
                        $data['state'] =  $state_name = $this->input->post('state_name');
                        $data['region_id'] =  $region_id = $this->input->post('region_id');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['modification_date'] = $date1;
                        $data['modification_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "v.modification_date>='" . $date_from . "' and v.modification_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status=2 OR v.status=3)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        if ($regionId == '99') {
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['modification_date'] = $date1;
                            $data['modification_date'] = $date2;
                            $where = "v.modification_date>='" . $date_from . "' and v.modification_date<='" . $date_to . "' AND v.status=2 OR v.status = 3";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        } else {
                            $regionId = $this->input->post('region_id');
                            $states = $this->Crud_modal->all_data_select(
                                'state_id',
                                'states',
                                "region_id='$regionId'",
                                'state_name ASC'
                            );
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['modification_date'] = $date1;
                            $data['modification_date'] = $date2;
                            $where = "v.modification_date>='" . $date_from . "' AND v.modification_date<='" . $date_to . "' AND v.state_id IN ($stateIds)  AND v.status = 2 OR v.status=3";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        }
                    } else if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['state_name'] = $state_name;
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.modification_date >= "' . $fromDate . '" AND v.modification_date <= "' . $toDate . '" AND v.state_id = "' . $state_name . '"';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else {
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.modification_date >= "' . $fromDate . '" AND v.modification_date <= "' . $toDate . '" AND v.status=2 OR v.status=3';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =2 OR v.status =3';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $data['state'] =   $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['modification_date'] = $date1;
                        $data['modification_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "modification_date>='" . $date_from . "' and modification_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status=2 OR v.status=3)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$regionId'", 'state_name ASC');
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['modification_date'] = $date1;
                        $data['modification_date'] = $date2;

                        $where = "modification_date >= '$date_from' AND modification_date <= '$date_to' AND (v.status = 2 OR v.status = 3) AND v.state_id in ($stateIds)";

                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                }

                $data['email_templates'] = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=4');

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');

                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('ragistration-volunteer', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function volenteership()
    {
        try {
            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {
                // $this->session->set_userdata($this->input->post());
                $region = $this->session->userdata('region_id');
                $role = $this->session->userdata('role_id');
                if ($role == 1) {
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =4 OR v.status =5';
                    if ($this->input->post('start_new') != ""  && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "" && $this->input->post('region_id') != "") {
                        $data['state'] =  $state_name = $this->input->post('state_name');
                        $data['region_id'] =  $region_id = $this->input->post('region_id');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['post_Reg_com_date'] = $date1;
                        $data['post_Reg_com_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "v.post_Reg_com_date>='" . $date_from . "' and v.post_Reg_com_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status = 4 OR v.status=5)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        if ($regionId == '99') {
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['post_Reg_com_date'] = $date1;
                            $data['post_Reg_com_date'] = $date2;
                            $where = "v.post_Reg_com_date>='" . $date_from . "' and v.post_Reg_com_date<='" . $date_to . "' AND v.status=4 OR v.status = 5";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        } else {
                            $regionId = $this->input->post('region_id');
                            $states = $this->Crud_modal->all_data_select(
                                'state_id',
                                'states',
                                "region_id='$regionId'",
                                'state_name ASC'
                            );
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $date1 = $this->input->post('start_new');
                            $date2 = $this->input->post('end_new');
                            $data['date_from'] = $date_from = date("Y-m-d", strtotime($date1));
                            $data['date_to'] =     $date_to = date("Y-m-d", strtotime($date2));
                            $data['post_Reg_com_date'] = $date1;
                            $data['post_Reg_com_date'] = $date2;
                            $where = "v.post_Reg_com_date>='" . $date_from . "' AND v.post_Reg_com_date<='" . $date_to . "' AND v.state_id IN ($stateIds)  AND v.status = 4 OR v.status=5";
                            $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                        }
                    } else if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $state_name = $this->input->post('state_name');
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['state_name'] = $state_name;
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.post_Reg_com_date >= "' . $fromDate . '" AND v.post_Reg_com_date <= "' . $toDate . '" AND v.state_id = "' . $state_name . '"';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else {
                        $toDate = date('Y-m-d');
                        $fromDate = date('Y-m-d', strtotime('-15 days'));
                        $data['start_new'] = $toDate;
                        $data['end_new'] = $fromDate;
                        $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
                        $where = 'v.post_Reg_com_date >= "' . $fromDate . '" AND v.post_Reg_com_date <= "' . $toDate . '" AND v.status=4 OR v.status=5';
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                } else {
                    $data['rname'] = $this->Curl_model->fetch_single_data('region_name,state_id', 'regions', array('region_id' => $region));
                    $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', 'region_id=' . $region);
                    $date2 = $data['date_to'] = date("Y-m-d");
                    $data['date_from'] = date("Y-m-d", strtotime($date2 . '-30 days'));
                    $where = 'v.status =4 OR v.status =5';
                    if ($this->input->post('start_new') != "" && $this->input->post('end_new') != "" &&  $this->input->post('state_name') != "") {
                        $data['state'] =   $state_name = $this->input->post('state_name');
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['post_Reg_com_date'] = $date1;
                        $data['post_Reg_com_date'] = $date2;
                        $data['state_name'] = $state_name;
                        $where = "post_Reg_com_date>='" . $date_from . "' and post_Reg_com_date<='" . $date_to . "' and v.state_id=" . $state_name . "  and (v.status=4 OR v.status=5)";
                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    } else if ($this->input->post('region_id') != "") {
                        $regionId = $this->input->post('region_id');
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$regionId'", 'state_name ASC');
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $date1 = $this->input->post('start_new');
                        $date2 = $this->input->post('end_new');
                        $date_from = date("Y-m-d", strtotime($date1));
                        $date_to = date("Y-m-d", strtotime($date2 . '+1 days'));
                        $data['post_Reg_com_date'] = $date1;
                        $data['post_Reg_com_date'] = $date2;

                        $where = "post_Reg_com_date >= '$date_from' AND post_Reg_com_date <= '$date_to' AND (v.status = 4 OR v.status = 5) AND v.state_id in ($stateIds)";

                        $data['volunteer'] = $this->Admin_model->volunteer_enquiry_Data($where);
                    }
                }

                $data['email_templates'] = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=4');

                $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');

                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('volenteership', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
