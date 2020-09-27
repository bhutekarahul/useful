<?php 
session_start();
require_once './config/siteconfig.php';
require_once './config/connection.php';
require_once './common/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/choicekids/common/mails-body.php';
require_once './common/dompdf/autoload.inc.php';

$kids = new ChoiceKids();
$enrollment_options = $kids->getApplicantData(1);
$data = mysqli_fetch_assoc($enrollment_options);

$date = strtotime($data['created_date']);
$file_path = $_SERVER['DOCUMENT_ROOT']."/choicekids/user_uploads/applicant_pre_enrollment_test/";
$file_name = $data['first_name']."-".$data['last_name']."_pre-enrollment-test_".date('d-m-Y',$date).".pdf";
$file = $file_path.$file_name;

$_SESSION['applicant_id'] = $data['applicant_id'];

// reference the Dompdf namespace
use Dompdf\Dompdf;

ob_start();
include './reports/pre-enrollment-test.php';
$contents = ob_get_clean(); 

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->load_html($contents);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF   
$dompdf->render();

//$dompdf->stream("hello.pdf");
$output = $dompdf->output();

$pdf = file_put_contents($file, $output);

if(!empty($pdf) && $pdf != FALSE){
    $mail = new MailBody();
    $admin_body = $mail->getPreEnrollmentAdminMailBody($_SESSION['position']);
    $subject = $_SESSION['position']." ".$_SESSION['center_name']." - Training Test";
    $admin_mail = $kids->sendMail(ADMIN_EMAIL, EMAIL_FROM, $admin_body, $subject, $file_name, NULL);
    if($admin_mail == TRUE){
        echo "<script>window.open('".SERVER_URL."','_self');</script>";
    }else{
        echo "0";
    }
}
