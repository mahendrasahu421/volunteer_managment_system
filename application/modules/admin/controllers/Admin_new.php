<?php

use SebastianBergmann\Exporter\Exporter;

ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_new extends MY_Controller
{
    public $nama_tabel = 'dioceses';
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

    public function designation()
    {
        try {
            if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {
                $data['designation'] = $this->Crud_modal->fetch_all_data('*', 'designation', 'status=1');

                $this->load->view('temp/head');
                $this->load->view('temp/header', $data);
                $this->load->view('temp/sidebar');
                $this->load->view('designation', $data);
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function add_designation()
    {
        try {
            if ($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null) {

                $this->load->view('temp/head');
                $this->load->view('temp/header');
                $this->load->view('temp/sidebar');
                $this->load->view('add-designation');
                $this->load->view('temp/footer');
            } else {
                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function insert_designation_master()
    {

        try {

            $createdata = array(

                'des_name' => $this->input->post('designation_name'),

                'creation_date' => date('Y-m-d H:i:s'),

                'status' => $this->input->post('status'),

            );

            $this->Crud_modal->data_insert('designation', $createdata);

            $this->session->set_flashdata('designation_insert_message', '<div class="alert alert-info"><strong>Success!</strong> Designation has Inserted.</div>');

            redirect(base_url() . 'designation');
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function update_designation_master()
    {

        $des_id = $this->input->post('des_id');

        $designation_name = $this->input->post('designation_name');

        $status = $this->input->post('status');

        $update_data = array(

            'des_name' => $designation_name,

            'status' => $status,

            'modification_date' => date('Y-m-d')

        );



        $where = "des_id = '$des_id'";

        if ($this->Crud_modal->update_data($where, 'designation', $update_data)) {

            $this->session->set_flashdata('master_designation', '<div class="alert alert-warning"><strong>Success!</strong> Designation Data has Updated.</div>');

            redirect(base_url() . 'designation');
        } else {

            $this->session->set_flashdata('master_designation', '<div class="alert alert-danger"><strong>Failed!</strong> to Updated Data</div>');

            redirect(base_url() . 'designation');
        }
    }
    public function edit_designation()
    {

        try {

            if (($this->session->userdata('emp_id') != "" || $this->session->userdata('emp_id') != null)) {

                $des_id = $this->uri->segment(2);

                $val = base64_decode(str_pad(strtr($des_id, '-_', '+/'), strlen($des_id) % 4, '=', STR_PAD_RIGHT));

                $where = "des_id = '$val'";

                $data['pravasi_designation'] = $this->Crud_modal->all_data_select('*', 'designation', $where, 'des_id desc');


                $this->load->view('temp/head');

                $this->load->view('temp/header');

                $this->load->view('temp/sidebar');

                $this->load->view('edit-designation', $data);

                $this->load->view('temp/footer');
            } else {

                redirect(base_url() . 'login', 'refresh');
            }
        } catch (Exception $e) {

            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

     public function intern_request_certificate()
    {
        try {
            // Check session
            $empId = $this->session->userdata('emp_id');
            if (empty($empId)) {
                redirect(base_url('login'), 'refresh');
                return;
            }

            $region = $this->session->userdata('region_id');
            $role = $this->session->userdata('role_id');

            $data['regions'] = $this->Crud_modal->fetch_all_data('*', 'regions', 'region_status=1');

            // Default date range: last 7 days
            $date_to = date("Y-m-d");
            $date_from = date("Y-m-d", strtotime($date_to . ' -7 days'));

            // Inputs
            $inputStart = $this->input->post('start_new');
            $inputEnd = $this->input->post('end_new');
            $inputState = $this->input->post('state_name');
            $inputRegion = $this->input->post('region_id');

            // Normalize input dates
            if (!empty($inputStart)) {
                $date_from = date("Y-m-d", strtotime($inputStart));
            }
            if (!empty($inputEnd)) {
                $date_to = date("Y-m-d", strtotime($inputEnd . ' +1 day')); // to include end day
            }

            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;

            // Helper function to fetch skills string from skill IDs
            $fetchSkills = function ($skillIdsStr) {
                $skills = "";
                $skillIds = explode(",", $skillIdsStr);
                foreach ($skillIds as $skillId) {
                    $skill = $this->Crud_modal->fetch_single_data("skill_name", "skills", "skill_id='" . trim($skillId) . "'");
                    if ($skill) {
                        $skills .= $skill['skill_name'] . ", ";
                    }
                }
                return rtrim($skills, ", ");
            };

            // Build where clause & get interns based on role and inputs
            if ($role == 1) { // Role 1: Admin
                // If all filters are given
                if (!empty($inputStart) && !empty($inputEnd) && !empty($inputState) && !empty($inputRegion)) {
                    $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id = $inputState AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                }
                // Only region filter
                else if (!empty($inputRegion)) {
                    if ($inputRegion == '99') { // All regions
                        $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                    } else {
                        // Get states under this region
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$inputRegion'", 'state_name ASC');
                        if ($states) {
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                        } else {
                            $where = "1=0"; // No states, so no results
                        }
                    }
                }
                // Default last 7 days for admin
                else {
                    // All states under admin's region
                    $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$region'", 'state_name ASC');
                    if ($states) {
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                    } else {
                        $where = "1=0";
                    }
                }
            } else {
                // For other roles, similar logic but limited to session region
                $data['rname'] = $this->Crud_modal->fetch_single_data('region_name,state_id', 'regions', ['region_id' => $region]);
                $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', "region_id=$region");

                if (!empty($inputStart) && !empty($inputEnd) && !empty($inputState) && !empty($inputRegion)) {
                    $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id = $inputState AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                } else if (!empty($inputRegion)) {
                    if ($inputRegion == '99') {
                        $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                    } else {
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$inputRegion'", 'state_name ASC');
                        if ($states) {
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                        } else {
                            $where = "1=0";
                        }
                    }
                } else {
                    // Default last 30 days for other roles
                    $date_to = date('Y-m-d');
                    $date_from = date('Y-m-d', strtotime('-30 days'));
                    $data['date_from'] = $date_from;
                    $data['date_to'] = $date_to;

                    $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$region'", 'state_name ASC');
                    if ($states) {
                        $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                        $where = "fd.creation_date >= '$date_from' AND fd.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                    } else {
                        $where = "1=0";
                    }
                }
            }

            // Fetch certificates based on constructed where clause
            $data['feedbackCertifecate'] = $this->Admin_model->send_certificate_by_feedback($where, $empId, $role);

            // Prepare email template
            $emailTemplate = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=9');

              foreach ($data['feedbackCertifecate'] as $key => $intern) {
                // 🧠 Skill IDs and Names
                $skillIdStr = $intern['skill_id'] ?? ($intern['task_keyword'] ?? '');
                $skillsStr = $fetchSkills($skillIdStr);

                // 📅 Date Formatting
                $joiningDate = $intern['joining_date'];
                $durationWeeks = $intern['internshipDeruation'];
                $formattedJoiningDate = date('M jS Y', strtotime($joiningDate));
                $endTimestamp = strtotime("+{$durationWeeks} weeks", strtotime($joiningDate));
                $formattedEndDate = date('M jS Y', $endTimestamp);

                // ✍️ Signature Image
                $signatureImg = '<img src="' . base_url('/uploads/signature/' . $intern['signature']) . '" />';

                // 🚻 Gender-Based Terms
                $gender = $intern['gender'] ?? '1'; // Default to male
                switch ($gender) {
                    case '1': // Male
                        $genderCapital = 'He';
                        $genderText = 'he';
                        $genderObject = 'him';
                        $genderPossessive = 'his';
                        break;
                    case '2': // Female
                        $genderCapital = 'She';
                        $genderText = 'she';
                        $genderObject = 'her';
                        $genderPossessive = 'her';
                        break;
                    default: // Others
                        $genderCapital = 'They';
                        $genderText = 'they';
                        $genderObject = 'them';
                        $genderPossessive = 'their';
                        break;
                }

                // 📩 Email Template
                if (!empty($intern['certificate_email'])) {
                    $personalizedContent = $intern['certificate_email'];
                } else {
                    $emailTemplate = $this->Crud_modal->fetch_single_data('email_templates_id,body_content', 'email_templates', 'status=1 AND email_templates_id=9');
                    $personalizedContent = $emailTemplate['body_content'] ?? '';
                }

                // 🔄 Replace gender terms (case-sensitive, word-boundary safe)
                $replacements = [
                    '/\bHe\b/' => $genderCapital,
                    '/\bhe\b/' => $genderText,
                    '/\bShe\b/' => $genderCapital,
                    '/\bshe\b/' => $genderText,
                    '/\bThey\b/' => $genderCapital,
                    '/\bthey\b/' => $genderText,
                    '/\bhim\b/' => $genderObject,
                    '/\bHim\b/' => ucfirst($genderObject),
                    '/\bhis\b/' => $genderPossessive,
                    '/\bHis\b/' => ucfirst($genderPossessive),
                    '/\bher\b/' => $genderObject === 'her' ? 'her' : $genderPossessive,
                    '/\bHer\b/' => ucfirst($genderObject === 'her' ? 'her' : $genderPossessive),
                ];
                $personalizedContent = preg_replace(array_keys($replacements), array_values($replacements), $personalizedContent);

                // 🔄 Replace fixed terms with intern-specific values
                $searchArray = [
                    "Mr. Deepanshu Mittal",
                    "Hindi College, Delhi",
                    "Bitapi Baruah",
                    "Senior Manager",
                    "Deepanshu",
                    "Data Analysis and documentation",
                    "Volunteer Action- HO Team",
                    "March 21st",
                    "May 6th, 2022",
                    "signature"
                ];

                $replaceArray = [
                    $intern['first_name'] . " " . $intern['last_name'],
                    $intern['name_of_school'],
                    $intern['emp_name'],
                    $intern['des_name'],
                    $intern['first_name'] . " " . $intern['last_name'],
                    $skillsStr,
                    $intern['department_intern_in'],
                    $formattedJoiningDate,
                    $formattedEndDate,
                    $signatureImg
                ];

                $personalizedContent = str_replace($searchArray, $replaceArray, $personalizedContent);

                // 💾 Save personalized content
                $data['feedbackCertifecate'][$key]['email_content'] = $personalizedContent;
            }




            // Load views
            $this->load->view('temp/head');
            $this->load->view('temp/header', $data);
            $this->load->view('temp/sidebar');
            $this->load->view('intern-request-certificate', $data);
            $this->load->view('temp/footer');
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    
 public function update_certificate_data()
    {
        $intern_id = $this->input->post('intern_id');
        $intern_email = $this->input->post('intern_email'); // Note: aap ajax me ye bhej rahe ho ya nahi?
        $emialcontent = $this->input->post('emialcontent');

        // Debugging temporarily
        // var_dump($intern_id, $intern_email, $emialcontent); exit;

        $cleanContent = strip_tags($emialcontent);
        $cleanContent = str_replace('&nbsp;', ' ', $cleanContent);
        $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
        $cleanContent = trim($cleanContent);

        // Check agar intern_email mil raha hai ya nahi. Agar nahi mil raha to query fail hogi.
        if (empty($intern_email)) {
            // Agar ajax me email send nahi kar rahe ho, to ya to use na karo ya phir DB update me email hatao
            $where = ['intern_id' => $intern_id];
        } else {
            $where = ['intern_id' => $intern_id, 'email' => $intern_email];
        }

        $emailData = [
            'certificate_email' => $cleanContent,
        ];

        // Assuming Crud_modal->update_data accepts array for where
        $update = $this->Crud_modal->update_data($where, 'interns', $emailData);

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
    }
    public function view_certificate()
    {
        // Get employee ID from session
        $emp_id = $this->session->userdata('emp_id');
        $where1 = "emp_id = $emp_id";

        // Fetch employee details
        $data['empSing'] = $this->Admin_model->get_employye_details($where1);

        // Check if signature is empty
        $empsing = $data['empSing']['signature'];

        $emp_name = $data['empSing']['emp_name'];
        $des_name = $data['empSing']['des_name'];

        // Decode intern ID from URL
        $intern_id = $this->uri->segment(2);
        $val = base64_decode(str_pad(strtr($intern_id, '-_', '+/'), strlen($intern_id) % 4, '=', STR_PAD_RIGHT));

        // Fetch intern details from the database
        $where = 'intern_id = "' . $val . '"';
        $internemailData = $this->Crud_modal->fetch_single_data('*', 'interns', $where);

        // Check if intern data exists
        if (!$internemailData) {
            echo "Intern data not found.";
            return;
        }

        $offerEmailFormat = $internemailData['certificate_email'];
        $date = date('d-m-Y');
        $certificatehead = "TO WHOM IT MAY CONCERN";

        // Initialize FPDF for PDF generation
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);

        // Set image for certificate background
        $pdf->Image(base_url() . '/uploads/MumbaiOffice_certificate.png', 1, 1, 208.5);
		//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/uploads/MumbaiOffice_certificate.png', 1, 1, 208.5);
        // Set date on top-right
        $pdf->SetY(34.6);
        $pdf->SetX(158);
        $pdf->Cell(15, 8, $date, 0, 'R');

        // Set certificate heading
        $pdf->SetY(44.6);
        $pdf->SetX(70);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(15, 8, $certificatehead, 0, 'R');

        // Set font for body text
        $pdf->SetFont('Arial', '', 11);

        // Display the body text with multi-cell to handle line breaks
        $pdf->SetY(55);
        $pdf->Ln(5);
        $pdf->SetX(20);
        $text = $offerEmailFormat;
        $pdf->multiCell(170, 8, strip_tags($text));

        // Add signature image if available
        $signaturePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/signature/' . $empsing;
        
        if (file_exists($signaturePath)) {
            $pdf->SetX(20);
            $pdf->Cell(30, 70, $emp_name);
            $pdf->SetX(20);

            $pdf->Image($signaturePath, 8, 130, 60);

            $pdf->SetY(130);
            $pdf->SetX(20);
            $pdf->Cell(30, 70, $des_name);
            $path = 'certificate/' . rand() . '.pdf';
            $pdf->Output($path, 'F');
        } else {
            $pdf->SetY(158);
            $pdf->SetX(8);
            $pdf->Cell(60, 8, "Signature not available", 0, 0, 'C');
        }


        // Output the PDF
        $pdf->Output();
    }


    public function send_certificate_letter($internemailData)
    {
        $emp_id = $this->session->userdata('emp_id');
        $where1 = "emp_id = $emp_id";
        $data['empSing'] = $this->Admin_model->get_employye_details($where1);
        $empsing = $data['empSing']['signature'];

        if (empty($empsing)) {
            echo "<script>alert('Your Signature is not updated. Please contact your Admin.');</script>";
            return; // Exit the function if signature is missing
        }
        $emp_name = $data['empSing']['emp_name'];
        $des_name = $data['empSing']['des_name'];
        $empsing = $data['empSing']['signature'];
        $offerEmailFormat = $internemailData['certificate_email'];
        $date = date('d-m-Y');
        $certificatehead = "TO WHOM IT MAY CONCERN";
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);

        // $pdf->Image(base_url() . '/uploads/MumbaiOffice_certificate.png', 1, 1, 208.5);
        // $pdf->Image(base_url() . '/uploads/signature/' . $empsing . '', 8, 158, 60);
         $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/uploads/MumbaiOffice_certificate.png', 10, 8, 185);
        // $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/uploads/signature/' . $empsing . '', 8, 158, 60);
        $pdf->SetY(34.6);
        $pdf->SetX(158);
        $pdf->Cell(15, 8, $date, 0, 'R');
        // certificatehead
        $pdf->SetY(44.6);
        $pdf->SetX(70);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(15, 8, $certificatehead, 0, 'R');
        $pdf->SetFont('Arial', '', 11);
        // certificatehead
        $pdf->SetY(55);
        $pdf->Ln(5);
        $pdf->SetX(20);
        $pdf->multiCell(170, 8, strip_tags($offerEmailFormat), 5);
        $pdf->SetX(20);
        $pdf->Cell(30, 18, "Warm Regards");

        $x = $pdf->GetY();
        $pdf->Image(base_url() . '/uploads/signature/' . $empsing . '', 8, $x + 5, 60);

        $pdf->SetX(20);
        $pdf->Cell(30, 70, $emp_name);
        $pdf->SetX(20);
        $pdf->Cell(30, 80, $des_name);
        $path = 'certificate/' . rand() . '.pdf';
        $pdf->Output($path, 'F');
        return $path;
        $this->load->view('view_offer_letter');
    }

    public function send_certificate_on_mail()
    {
        $intern_id_encoded = $this->uri->segment(2);
        $intern_id = base64_decode(str_pad(strtr($intern_id_encoded, '-_', '+/'), strlen($intern_id_encoded) % 4, '=', STR_PAD_RIGHT));
        $where = 'intern_id = "' . $intern_id . '"';
        $internemailData = $this->Crud_modal->fetch_single_data('first_name,last_name,email,certificate_email', 'interns', $where);
        $data['first_name'] = $internemailData['first_name'];
        $data['last_name'] = $internemailData['last_name'];
        $internEmail = $internemailData['email'];
        $to = $internEmail;
        $att = $this->send_certificate_letter($internemailData);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "noreply@crymail.org";
        $mail->Password = "^%n7wh#m7_2k";
        $mail->setFrom('noreply@crymail.org');
        $mail->AddAttachment($att);
        $mail->AddAddress($to);
        $mail->addBCC("mahendra.s@neuralinfo.org", "Mahendra Sahu");
        $mail->FromName = 'CRY VE Team';
        $mail->IsHTML(true);
        $mail->Subject = 'CRY Internship completion Certificate';
        // $mail->Body = 'Certificate';
        $mail->Body = $this->load->view('admin/certificate', $data, TRUE);
		 $this->Admin_model->sent_certificate_to_intern($intern_id,$att);
        if (!$mail->Send()) {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

            $this->Admin_model->certificate_send($intern_id);
            $this->Admin_model->sent_certificate_to_intern($intern_id,$att);
            //  $this->Admin_model->count_send_mail($val);
            redirect(base_url() . 'intern-request-certificate');
        }
    }
}
