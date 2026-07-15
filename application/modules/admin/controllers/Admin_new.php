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

    private function certificate_format_date($date, $format = 'd-m-Y', $fallback = '')
    {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return $fallback;
        }

        $timestamp = strtotime($date);
        if ($timestamp === false || $timestamp <= 0) {
            return $fallback;
        }

        return date($format, $timestamp);
    }

    private function certificate_end_date($joiningDate, $durationWeeks, $format = 'M jS Y')
    {
        if (empty($joiningDate) || $joiningDate == '0000-00-00' || $joiningDate == '0000-00-00 00:00:00') {
            return '';
        }

        $timestamp = strtotime($joiningDate);
        if ($timestamp === false || $timestamp <= 0) {
            return '';
        }

        return date($format, strtotime('+' . (int) $durationWeeks . ' weeks', $timestamp));
    }

    private function certificate_html_to_text($html)
    {
        $html = (string) $html;
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $html = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n", $html);
        $html = preg_replace('/<(p|div|li|h[1-6])[^>]*>/i', '', $html);
        $html = str_replace('&nbsp;', ' ', $html);
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8');
        do {
            $previousText = $text;
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        } while ($previousText !== $text);
        $text = preg_replace('/[ \t\x{00A0}]+/u', ' ', $text);
        $text = preg_replace("/\r\n|\r/", "\n", $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = str_replace(
            array('‘', '’', '‚', '‛', '“', '”', '„', '–', '—', '…', 'â€˜', 'â€™', 'â€œ', 'â€', 'â€“', 'â€”', 'â€¦'),
            array("'", "'", "'", "'", '"', '"', '"', '-', '-', '...', "'", "'", '"', '"', '-', '-', '...'),
            $text
        );

        if (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text);
            if ($converted !== false) {
                $text = $converted;
            }
        }

        return trim($text);
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
                    $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id = $inputState AND i.status = 8 AND isr.status = 2";
                }
                // Only region filter
                else if (!empty($inputRegion)) {
                    if ($inputRegion == '99') { // All regions
                        $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.status = 8 AND isr.status = 2";
                    } else {
                        // Get states under this region
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$inputRegion'", 'state_name ASC');
                        if ($states) {
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2";
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
                        $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2";
                    } else {
                        $where = "1=0";
                    }
                }
            } else {
                // For other roles, similar logic but limited to session region
                $data['rname'] = $this->Crud_modal->fetch_single_data('region_name,state_id', 'regions', ['region_id' => $region]);
                $data['states'] = $this->Crud_modal->fetch_all_data('*', 'states', "region_id=$region");

                if (!empty($inputStart) && !empty($inputEnd) && !empty($inputState) && !empty($inputRegion)) {
                    $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id = $inputState AND i.status = 8 AND isr.status = 2";
                } else if (!empty($inputRegion)) {
                    if ($inputRegion == '99') {
                        $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
                    } else {
                        $states = $this->Crud_modal->all_data_select('state_id', 'states', "region_id='$inputRegion'", 'state_name ASC');
                        if ($states) {
                            $stateIds = '"' . implode('","', array_column($states, 'state_id')) . '"';
                            $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2 AND fd.status = 1";
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
                        $where = "isr.creation_date >= '$date_from' AND isr.creation_date <= '$date_to' AND i.state_id IN ($stateIds) AND i.status = 8 AND isr.status = 2";
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
                $formattedJoiningDate = $this->certificate_format_date($joiningDate, 'M jS Y');
                $formattedEndDate = $this->certificate_end_date($joiningDate, $durationWeeks);

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
        $intern_email = $this->input->post('intern_email'); // (optional)
        $content = (string) $this->input->post('emialcontent', false);
        $content = str_ireplace(array('&amp;', '&#38;', '&#x26;'), '&', $content);

        // Check agar intern_email mil raha hai ya nahi. Agar nahi mil raha to query fail hogi.
        if (empty($intern_email)) {
            $where = ['intern_id' => $intern_id];
        } else {
            $where = ['intern_id' => $intern_id, 'email' => $intern_email];
        }

        $emailData = [
            'certificate_email' => $content,
        ];

        $update = $this->Crud_modal->update_data($where, 'interns', $emailData);

        if ($update) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
    }
    public function view_certificate()
{
    // ── Auth ────────────────────────────────────────────
    $emp_id = $this->session->userdata('emp_id');
    $where1 = "emp_id = $emp_id";
    $data['empSing'] = $this->Admin_model->get_employye_details($where1);
    $empsing  = $data['empSing']['signature'];
    $emp_name = $data['empSing']['emp_name'];
    $des_name = $data['empSing']['des_name'];
 
    // ── Intern ID decode ─────────────────────────────────
    $intern_id = $this->uri->segment(2);
    $val = base64_decode(
        str_pad(strtr($intern_id, '-_', '+/'), strlen($intern_id) % 4, '=', STR_PAD_RIGHT)
    );
 
    $where = 'intern_id = "' . $val . '"';
    $internemailData = $this->Crud_modal->fetch_single_data('*', 'interns', $where);
 
    if (!$internemailData) {
        echo "Intern data not found.";
        return;
    }
 
    // ── Convert HTML → clean plain text ─────────────────
    $rawHtml = (string) ($internemailData['certificate_email'] ?? '');
 
    // Double <br> → 2 newlines, single <br> → 1 newline
    $rawHtml = preg_replace('/(<br\s*\/?>){2,}/i', "\n\n", $rawHtml);
    $rawHtml = str_replace(["<br/>","<br>","<br />","</p>","</div>","</li>"], "\n", $rawHtml);
    $rawHtml = str_replace("&nbsp;", " ", $rawHtml);
    $text    = strip_tags($rawHtml);
    $text    = preg_replace('/[\t ]+/', ' ', $text);         // collapse spaces
    $text    = preg_replace('/\n{3,}/', "\n\n", $text);      // max 2 blank lines
    $text    = trim($text);
    $text = $this->certificate_html_to_text((string) ($internemailData['certificate_email'] ?? ''));
 
    $date           = date('d-m-Y');
    $certificatehead = "TO WHOM IT MAY CONCERN";
 
    // ── Constants ────────────────────────────────────────
    $LEFT   = 20;   // left margin  (mm)
    $RIGHT  = 20;   // right margin (mm)
    $PW     = 210;  // A4 page width
    $PH     = 297;  // A4 page height
    $CW     = $PW - $LEFT - $RIGHT;  // content width = 170mm
    $LH     = 6;    // line height for body text
 
    // ── FPDF setup ───────────────────────────────────────
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
 
    // ✅ FIX 1: Equal margins from both sides
    $pdf->SetMargins($LEFT, 15, $RIGHT);
    $pdf->SetAutoPageBreak(true, 20);
 
    // ✅ FIX 2: Background image — full A4 coverage (x=0, y=0)
    $bgPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/MumbaiOffice_certificate.png';
    if (file_exists($bgPath)) {
        $pdf->Image($bgPath, 0, 0, $PW, $PH);
    } else {
        // fallback: base_url version
        $pdf->Image(base_url() . '/uploads/MumbaiOffice_certificate.png', 0, 0, $PW, $PH);
    }
 
    // ── Date — right aligned ─────────────────────────────
    // ✅ FIX 3: Full content width cell, right aligned
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY($LEFT, 35);
    $pdf->Cell($CW, 6, $date, 0, 1, 'R');   // 'R' = right align, full width
 
    // ── Heading — centered ───────────────────────────────
    // ✅ FIX 4: Full width cell, centered
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetXY($LEFT, 45);
    $pdf->Cell($CW, 8, $certificatehead, 0, 1, 'C');   // 'C' = center
 
    // ── Body text — JUSTIFIED ────────────────────────────
    // ✅ FIX 5: MultiCell with 'J' = justified both sides
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY($LEFT, 57);
    $pdf->MultiCell($CW, $LH, $text, 0, 'J');
 
    // cursor position after body text
    $bodyEndY = $pdf->GetY();
 
    // ── Signature block ──────────────────────────────────
    // ✅ FIX 6: Everything starts at X=$LEFT (20mm)
    $sigW    = 50;   // signature image width
    $sigH    = 25;   // signature image height
    $gap     = 8;    // gap between text and signature
    $sigTopY = $bodyEndY + $gap;
 
    $signaturePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/signature/' . $empsing;
 
    // "Warm Regards" line
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY($LEFT, $bodyEndY + 4);
    $pdf->Cell($CW, 6, 'Warm Regards,', 0, 1, 'L');
 
    if (file_exists($signaturePath)) {
        // ✅ Signature image — starts at LEFT margin
        $pdf->Image($signaturePath, $LEFT, $sigTopY, $sigW, $sigH);
 
        $afterSigY = $sigTopY + $sigH + 2;
 
        // Employee name — bold, left aligned at margin
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY($LEFT, $afterSigY);
        $pdf->Cell(100, 6, $emp_name, 0, 1, 'L');
 
        // Designation — normal, left aligned at margin
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY($LEFT, $afterSigY + 7);
        $pdf->Cell(100, 6, $des_name, 0, 1, 'L');
 
    } else {
        // No signature fallback
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetXY($LEFT, $sigTopY);
        $pdf->Cell(100, 8, '[Signature not available]', 0, 1, 'L');
 
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY($LEFT, $sigTopY + 12);
        $pdf->Cell(100, 6, $emp_name, 0, 1, 'L');
 
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY($LEFT, $sigTopY + 20);
        $pdf->Cell(100, 6, $des_name, 0, 1, 'L');
    }
 
    // ── Output PDF ───────────────────────────────────────
    $pdf->Output('I', 'certificate.pdf');  // 'I' = browser mein open
}


  public function send_certificate_letter($internemailData)
{
    $emp_id = $this->session->userdata('emp_id');
    $where1 = "emp_id = $emp_id";
    $data['empSing'] = $this->Admin_model->get_employye_details($where1);
    $empsing  = $data['empSing']['signature'];
 
    if (empty($empsing)) {
        echo "<script>alert('Signature not updated. Please contact Admin.');</script>";
        return false;
    }
 
    $emp_name = $data['empSing']['emp_name'];
    $des_name = $data['empSing']['des_name'];
 
    // ── Convert HTML → plain text ────────────────────────
    $rawHtml = (string) ($internemailData['certificate_email'] ?? '');
    $rawHtml = preg_replace('/(<br\s*\/?>){2,}/i', "\n\n", $rawHtml);
    $rawHtml = str_replace(["<br/>","<br>","<br />","</p>","</div>","</li>"], "\n", $rawHtml);
    $rawHtml = str_replace("&nbsp;", " ", $rawHtml);
    $text    = strip_tags($rawHtml);
    $text    = preg_replace('/[\t ]+/', ' ', $text);
    $text    = preg_replace('/\n{3,}/', "\n\n", $text);
    $text    = trim($text);
    $text = $this->certificate_html_to_text((string) ($internemailData['certificate_email'] ?? ''));
 
    $date            = date('d-m-Y');
    $certificatehead = "TO WHOM IT MAY CONCERN";
 
    // ── Constants ───────────────────────────────────────
    $LEFT = 20; $RIGHT = 20;
    $PW   = 210; $PH = 297;
    $CW   = $PW - $LEFT - $RIGHT;  // 170mm
    $LH   = 6;
 
    // ── FPDF ────────────────────────────────────────────
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetMargins($LEFT, 15, $RIGHT);
    $pdf->SetAutoPageBreak(true, 20);
 
    // Background
    $bgPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/MumbaiOffice_certificate.png';
    if (file_exists($bgPath)) {
        $pdf->Image($bgPath, 0, 0, $PW, $PH);
    }
 
    // Date — right
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY($LEFT, 35);
    $pdf->Cell($CW, 6, $date, 0, 1, 'R');
 
    // Heading — center
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetXY($LEFT, 45);
    $pdf->Cell($CW, 8, $certificatehead, 0, 1, 'C');
 
    // Body — justified
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY($LEFT, 57);
    $pdf->MultiCell($CW, $LH, $text, 0, 'J');
 
    $bodyEndY = $pdf->GetY();
 
    $sigTopY  = $bodyEndY + 8;
    $sigW     = 50;
    $sigH     = 25;
 
    // Warm Regards
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY($LEFT, $bodyEndY + 4);
    $pdf->Cell($CW, 6, 'Warm Regards,', 0, 1, 'L');
 
    $signaturePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/signature/' . $empsing;
 
    if (file_exists($signaturePath)) {
        $pdf->Image($signaturePath, $LEFT, $sigTopY, $sigW, $sigH);
        $afterSigY = $sigTopY + $sigH + 2;
 
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY($LEFT, $afterSigY);
        $pdf->Cell(100, 6, $emp_name, 0, 1, 'L');
 
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY($LEFT, $afterSigY + 7);
        $pdf->Cell(100, 6, $des_name, 0, 1, 'L');
    } else {
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetXY($LEFT, $sigTopY);
        $pdf->Cell(100, 8, '[Signature not available]', 0, 1, 'L');
 
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY($LEFT, $sigTopY + 12);
        $pdf->Cell(100, 6, $emp_name, 0, 1, 'L');
 
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY($LEFT, $sigTopY + 20);
        $pdf->Cell(100, 6, $des_name, 0, 1, 'L');
    }
 
    $path = 'certificate/' . rand() . '.pdf';
    $pdf->Output($path, 'F');
    return $path;
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
        $this->Admin_model->sent_certificate_to_intern($intern_id, $att);
        if (!$mail->Send()) {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

            $this->Admin_model->certificate_send($intern_id);
            $this->Admin_model->sent_certificate_to_intern($intern_id, $att);
            //  $this->Admin_model->count_send_mail($val);
            redirect(base_url() . 'intern-request-certificate');
        }
    }
}
