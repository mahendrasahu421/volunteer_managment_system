<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Hr_proccess extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        
        $CI = &get_instance();
        $CI->load->library('Get_library');
        $this->load->library('upload');
        $this->load->library('csvimport');
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

    public function shortlist_mail()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $intern_id = $this->input->post('intern_id');
            $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name,email", "interns", "intern_id='$intern_id'");
            $data['first_name'] = $user_data['first_name'];
            $data['last_name'] = $user_data['last_name'];
            $data['user_email'] = $user_data['email'];
            if ($this->Admin_model->shortlist_mail($data)) {
                $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '2']);
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function not_shortlist_mail()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $intern_id = $this->input->post('intern_id');
            $user_data = $this->Crud_modal->fetch_single_data("first_name,email", "interns", "intern_id='$intern_id'");
            $data['first_name'] = $user_data['first_name'];
            $data['last_name'] = $user_data['last_name'];
            $data['user_email'] = $user_data['email'];
            if ($this->Admin_model->not_shortlist_mail($data)) {
                $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '0']);
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function shortlist_status_update()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $intern_id = $this->input->post('intern_id');
            $status = $this->input->post('status');
            if ($status == 0) {
                if ($this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '0'])) {
                    echo true;
                } else {
                    echo false;
                }
            } else if ($status == 2) {
                if ($this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '2'])) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }

    function get_same_day_schedule_user_count()
    {
        $date = date("Y-m-d", strtotime($this->input->post('date_value')));
        echo $this->Crud_modal->check_numrow("interview_schedule_detail", "schedule_date_time like '%$date%'");
    }

    public function save_interview_schedule_data()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            if ($this->input->post('schedule_id') == '') {
                $data['mode'] = $this->input->post('mode');
                $data['hr_description'] = $this->input->post('hr_description');
                $data['schedule_date_time'] = date("Y-m-d H:i:s", strtotime($this->input->post('schedule_date') . ' ' . $this->input->post('schedule_time')));
                if ($data['mode'] == "Face to Face") {
                    $data['venue'] = $this->input->post('venue');
                }
                $intern_id = $this->input->post('intern_id');
                $data['round'] = $this->input->post('round');
                $data['intern_id'] = $intern_id;
                $data['created_date'] = date("Y-m-d H:i:s");
                $data['created_by'] = $this->session->userdata('emp_id');

                $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '3']);
                $this->Crud_modal->data_insert("interview_schedule_detail", $data);
            } else {
                $data['mode'] = $this->input->post('mode');
                $data['hr_description'] = $this->input->post('hr_description');
                $data['schedule_date_time'] = date("Y-m-d H:i:s", strtotime($this->input->post('schedule_date') . ' ' . $this->input->post('schedule_time')));
                if ($data['mode'] == "Face to Face") {
                    $data['venue'] = $this->input->post('venue');
                }
                $data['round'] = intval($this->input->post('round')) - 1;
                $data['intern_id'] = $this->input->post('intern_id');
                $data['created_date'] = date("Y-m-d H:i:s");
                $data['created_by'] = $this->session->userdata('emp_id');
                $schedule_id = $this->input->post('schedule_id');

                $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '3']);
                $this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", $data);
            }
            echo true;
        }
    }

    function clear_interview()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $data['round_status'] = $this->input->post('status');
            $data['comment'] = $this->input->post('comment');
            $schedule_id = $this->input->post('schedule_id');
            $intern_id = $this->input->post('intern_id');
            $date2 = date("Y-m-d");
            
            $where = array('intern_id' => $intern_id);
            $fields = array('status' => 5, 'modification_date' => $date2);
            $this->Curl_model->update_data('interns', $fields, $where);
            
            if ($this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", ['job_process_step' => '4-0'])) {
                if ($this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", $data)) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }

    function ongoing_interview()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $intern_id = $this->uri->segment(2);
            $data['round_status'] = $this->input->post('status');
            $data['comment'] = $this->input->post('comment');
            $schedule_id = $this->input->post('schedule_id');
            $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", ['status' => '4']);
            if ($this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", $data)) {
                $data1['intern_id'] = $this->input->post('intern_id');
                $data1['round'] = $this->input->post('round');
                $data1['created_by'] = $this->session->userdata('emp_id');
                $data1['created_date'] = date("Y-m-d H:i:s");
                if ($this->Crud_modal->data_insert("interview_schedule_detail", $data1)) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }

    function reject_interview()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $val = $this->input->post('intern_id');
            $data['comment'] = $this->input->post('comment');
            $schedule_id = $this->input->post('schedule_id');

            // Update intern status
            $this->Crud_modal->update_data("intern_id='$val'", "interns", ['status' => '0']);

            // Fetch intern email/name for mail
            $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name,email", "interns", "intern_id='$val'");
            $mailData['first_name'] = $user_data['first_name'];
            $mailData['last_name'] = $user_data['last_name'];
            $mailData['user_email'] = $user_data['email'];
            $mailData['comment'] = $data['comment'];

            if ($this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", ['job_process_step' => '3-1'])) {
                if ($this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", $data)) {
                    // Trigger reject mail
                    $sent = $this->Admin_model->intern_reject_mail($mailData);
                    echo $sent ? true : false;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }

    function update_job_schedule_data()
{
    if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
        $val = $this->input->post('intern_id');
        $schedule_id = $this->input->post('schedule_id');
        
        // Get user data
        $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name, email", "interns", "intern_id='$val'");
        $udata['first_name'] = $user_data['first_name'];
        $udata['last_name'] = $user_data['last_name'];
        $udata['user_email'] = $user_data['email'];
        
        // Get OLD schedule data before update (for email)
        $old_schedule = $this->Crud_modal->fetch_single_data("*", "interview_schedule_detail", "schedule_id='$schedule_id'");
        
        // Prepare new data
        $data['mode'] = $this->input->post('mode');
        $data['schedule_date_time'] = date("Y-m-d H:i:s", strtotime($this->input->post('schedule_date') . ' ' . $this->input->post('schedule_time')));
        if ($data['mode'] == "Face to Face") {
            $data['venue'] = $this->input->post('venue');
        }
        $data['comment'] = $this->input->post('comment');
        $data['round'] = intval($this->input->post('round'));
        $data['intern_id'] = $this->input->post('intern_id');
        $data['modified_date'] = date("Y-m-d H:i:s");
        $data['modified_by'] = $this->session->userdata('emp_id');
        $data['round_status'] = 4;
        
        // UPDATE existing row (not insert new)
        if (!empty($schedule_id)) {
            $update_result = $this->Crud_modal->update_data("schedule_id='$schedule_id'", "interview_schedule_detail", $data);
            
            if ($update_result) {
                // Update intern status
                $this->Crud_modal->update_data("intern_id='$val'", "interns", ['status' => '11']);
                
                // Prepare email data with OLD and NEW details
                $udata['old_mode'] = $old_schedule['mode'];
                $udata['old_venue'] = $old_schedule['venue'];
                $udata['old_schedule_date'] = date("Y-m-d", strtotime($old_schedule['schedule_date_time']));
                $udata['old_schedule_time'] = date("H:i:s", strtotime($old_schedule['schedule_date_time']));
                
                $udata['new_mode'] = $data['mode'];
                $udata['new_venue'] = isset($data['venue']) ? $data['venue'] : '';
                $udata['new_schedule_date'] = $this->input->post('schedule_date');
                $udata['new_schedule_time'] = $this->input->post('schedule_time');
                
                $udata['adminEmail'] = $this->session->userdata('emp_email');
                $udata['hr_description'] = $this->input->post('hr_description') ?? '';
                
                // Send postpone email with both old and new details
                $sent = $this->Admin_model->reschedule_mail_to_user($udata);
                echo $sent ? true : false;
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    }
}

    function mail_interview_data()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $data['adminEmail'] = $this->session->userdata('emp_email');
            $round = intval($this->input->post('round'));
            $intern_id = $this->input->post('intern_id');
            $interview_status = $this->input->post('interview_status');
            $data_action = $this->input->post('data_action');
            
            $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name, email ", "interns", "intern_id='$intern_id'");
            
            $data['mode'] = $this->input->post('mode');
            $data['schedule_date'] = $this->input->post('schedule_date');
            $data['schedule_time'] = $this->input->post('schedule_time');
            $data['venue'] = $this->input->post('venue');
            $data['hr_description'] = $this->input->post('hr_description');
            $data['comment'] = $this->input->post('comment');
            $data['first_name'] = $user_data['first_name'];
            $data['last_name'] = $user_data['last_name'];
            $data['user_email'] = $user_data['email'];
            
            // For reschedule mail - get old schedule data
            if ($data_action == 'interview_reschedule_mail') {
                $prev_round = $round - 1;
                $old_schedule = $this->Crud_modal->fetchdata_with_limit(
                    "*", 
                    "interview_schedule_detail", 
                    "intern_id='$intern_id' AND round = '$prev_round'", 
                    "schedule_id desc", 
                    1
                );
                
                if (empty($old_schedule)) {
                    $old_schedule = $this->Crud_modal->fetchdata_with_limit(
                        "*", 
                        "interview_reschedule", 
                        "intern_id='$intern_id'", 
                        "reschedule_id desc", 
                        1
                    );
                }
                
                if (!empty($old_schedule)) {
                    $old_datetime = $old_schedule[0]['schedule_date_time'];
                    if (isset($old_schedule[0]['reschedule_date_time']) && $old_schedule[0]['reschedule_date_time'] != '0000-00-00 00:00:00') {
                        $old_datetime = $old_schedule[0]['reschedule_date_time'];
                    }
                    
                    $data['old_schedule_date'] = date("Y-m-d", strtotime($old_datetime));
                    $data['old_schedule_time'] = date("H:i:s", strtotime($old_datetime));
                    $data['old_mode'] = $old_schedule[0]['mode'];
                    $data['old_venue'] = isset($old_schedule[0]['venue']) ? $old_schedule[0]['venue'] : '';
                } else {
                    $data['old_schedule_date'] = date("Y-m-d");
                    $data['old_schedule_time'] = date("H:i:s");
                    $data['old_mode'] = 'Not Available';
                    $data['old_venue'] = 'Not Available';
                }
            }
            
            if ($data_action == 'interview_reschedule_mail') {
                if ($this->Admin_model->reschedule_mail_to_user($data)) {
                    echo true;
                } else {
                    echo false;
                }
            } else if ($data_action == 'interview_clear_mail') {
                if ($this->Admin_model->interview_clear_mail($data)) {
                    echo true;
                } else {
                    echo false;
                }
            } else if ($data_action == 'interview_ongoing_mail') {
                if ($this->Admin_model->interview_ongoing_mail($data)) {
                    echo true;
                } else {
                    echo false;
                }
            } else if ($data_action == 'intern_reject_mail') {
                if ($this->Admin_model->intern_reject_mail($data)) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                if ($this->Admin_model->schedule_mail_to_user($data)) {
                    echo true;
                } else {
                    echo false;
                }
            }
        }
    }

    public function offer_lattersend_orientation_emails()
    {
        $intern_id = $this->input->post('intern_id');
        $intern_email = $this->input->post('intern_email');
        $emialcontent = $this->input->post('emialcontent');

        $decoded = html_entity_decode($emialcontent, ENT_QUOTES, 'UTF-8');
        $cleaned = str_replace("\xc2\xa0", ' ', $decoded);
        $cleaned = str_replace('&nbsp;', ' ', $cleaned);
        $cleaned = strip_tags($cleaned);

        $where = 'intern_id = "' . $intern_id . '" AND email = "' . $intern_email . '"';
        $emailData = array('offer_latter_email' => trim($cleaned));
        $this->Crud_modal->update_data($where, 'interns', $emailData);
    }

    function interview_final_mail()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $intern_id = $this->input->post('intern_id');
            $date2 = date("Y-m-d");
            $where = array('intern_id' => $intern_id);
            $fields = array('status' => 5, 'modification_date' => $date2);
            $this->Curl_model->update_data('interns', $fields, $where);
            
            $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name,email", "interns", "intern_id='$intern_id'");
            $data['first_name'] = $user_data['first_name'];
            $data['last_name'] = $user_data['last_name'];
            $data['user_email'] = $user_data['email'];
            
            if ($this->Admin_model->interview_final_mail($data)) {
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function update_offer_latter()
    {
        try {
            $inter_id = $this->input->post('intern_id');
            $offerLatter_update_date = $this->input->post('offerLatter_update_date');
            $internshipType = $this->input->post('internshipType');
            $internship_durations = $this->input->post('internship_durations');
            $where = 'intern_id = "' . $inter_id . '"';
            $update_intershiopjoiningData = array(
                'joining_date' => $offerLatter_update_date,
                'internshipType' => $internshipType,
                'internshipDeruation' => $internship_durations,
            );
            if ($this->Crud_modal->update_data($where, 'interns', $update_intershiopjoiningData)) {
                echo 1;
            } else {
                return 2;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    function send_offer_to_user()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
            $config['upload_path'] = './uploads/offer_letter/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2000;
            $config['file_name'] = date("dmYhis") . '-' . $_FILES['offer_letter']['name'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('offer_letter')) {
                $data1 = $this->upload->data();
                $full_path = $data1['full_path'];
                $file_name = $data1['file_name'];
                $data['offer_letter'] = $data1['file_name'];
                $data['job_process_step'] = '5-0';
                $data['status'] = '5';
                $intern_id = $this->input->post('intern_id');
                $enc_intern = rtrim(strtr(base64_encode($intern_id), "+/", "-_"), "=");
                $url = base_url('post-registration-intern/' . $enc_intern);
                $this->Crud_modal->update_data("intern_id='$intern_id'", "interns", $data);
                $user_data = $this->Crud_modal->fetch_single_data("first_name,last_name,email", "interns", "intern_id='$intern_id'");
                $data['first_name'] = $user_data['first_name'];
                $data['last_name'] = $user_data['last_name'];
                $data['email'] = $user_data['email'];
                if ($this->Admin_model->send_offer_letter($full_path, $file_name, $data, $url)) {
                    echo true;
                } else {
                    echo false;
                }
            } else {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            }
        }
    }

    public function send_offer_letter($internemailData)
    {
        $offerEmailFormat = $internemailData['offer_latter_email'];
        $date = date('d-m-Y');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);
        $pdf->Image(base_url() . 'uploads/MumbaiOffice_certificate.png', 10, 8, 185);
        $pdf->SetY(38.6);
        $pdf->SetX(147);
        $pdf->Cell(10, 5, $date, 0, 'R');
        $pdf->SetY(60);
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->multiCell(170, 4, strip_tags($offerEmailFormat), 5);
        $path = 'offeremail/' . rand() . '.pdf';
        $pdf->Output($path, 'F');
        return $path;
    }

    public function view_offer_letter()
    {
        $intern_id = $this->uri->segment(2);
        $val = base64_decode(str_pad(strtr($intern_id, '-_', '+/'), strlen($intern_id) % 4, '=', STR_PAD_RIGHT));
        $where = 'intern_id = "' . $val . '"';
        $internemailData = $this->Crud_modal->fetch_single_data('*', 'interns', $where);
        $offerEmailFormat = $internemailData['offer_latter_email'];
        $date = date('d-m-Y');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image(base_url() . 'uploads/MumbaiOffice_certificate.png', 1, 1, 208.5);
        $pdf->SetY(34.6);
        $pdf->SetX(158);
        $pdf->Cell(15, 8, $date, 0, 'R');
        $pdf->SetY(35);
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->multiCell(170, 4, strip_tags($offerEmailFormat), 5);
        $pdf->Output();
    }

    public function send_offerLetter_emails()
    {
        $adminMail = $this->session->userdata('emp_email');
        $intern_id = $this->uri->segment(2);
        $val = base64_decode(str_pad(strtr($intern_id, '-_', '+/'), strlen($intern_id) % 4, '=', STR_PAD_RIGHT));
        $where = 'intern_id = "' . $val . '"';
        $internemailData = $this->Crud_modal->fetch_single_data('first_name,last_name,email,offer_latter_email', 'interns', $where);
        $data['first_name'] = $internemailData['first_name'];
        $data['last_name'] = $internemailData['last_name'];
        $this->Crud_modal->update_data("intern_id='$val'", "interns", ['status' => '6']);
        $internEmail = $internemailData['email'];
        $data['url'] = base_url('') . 'post-registration-intern/' . $intern_id;
        $to = $internEmail;
        $att = $this->send_offer_letter($internemailData);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "noreply@crymail.org";
        $mail->Password = "^%n7wh#m7_2k";
        $mail->setFrom('noreply@crymail.org');
        $mail->AddAttachment($att);
        $mail->AddAddress($to);
        $mail->addBCC("mahendra.s@neuralinfo.org");
        $mail->addBCC($adminMail);
        $mail->FromName = 'CRY VE Team';
        $mail->IsHTML(true);
        $mail->Subject = 'CRY Internship Confirmation Letter';
        $mail->Body = $this->load->view('admin/offer_letter_email', $data, true);
        if (!$mail->Send()) {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            redirect(base_url() . 'hr-process/' . $intern_id);
        }
    }

    function confirm_joining()
    {
        if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
			$adminMail = $this->session->userdata('emp_email');
            $creation_date = date('Y-m-d');
            $intern_id = $this->input->post("intern_id");
            $intern = $this->Crud_modal->fetch_single_data('*', 'interns', "intern_id=$intern_id");
            $data['first_name'] = $intern['first_name'];
            $data['last_name'] = $intern['last_name'];
            $val = rtrim(strtr(base64_encode($intern['intern_id']), '+/', '-_'), '=');
            $data['url'] = base_url('') . 'intern-login';
            $timestamp = time();
            $data['password'] = "Int" . $timestamp;
            $password = $data['password'];
            $data['email'] = $intern['email'];
            $to = $intern['email'];
            
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = "noreply@crymail.org";
            $mail->Password = "^%n7wh#m7_2k";
            $mail->setFrom('noreply@crymail.org');
            $mail->AddAddress($to);
            $mail->addBCC("mahendra.s@neuralinfo.org");
			$mail->addBCC($adminMail);
            $mail->FromName = 'CRY VE Team';
            $mail->IsHTML(true);
            $mail->Subject = 'You are now a CRY Intern!';
            $mail->Body = $this->load->view('admin/joining_letter', $data, TRUE);
            if (!$mail->Send()) {
                echo "Message could not be sent. <p>";
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $this->Admin_model->intern_count_send_maillogincredational($intern_id, $creation_date, $password);
            }
        }
    }
}