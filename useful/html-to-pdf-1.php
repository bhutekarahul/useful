<?php //
session_start();
require_once './config/siteconfig.php';
require_once './config/connection.php';
require_once './common/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/choicekids/common/mails-body.php';
require_once './common/dompdf/autoload.inc.php';

$kids = new ChoiceKids();
$enrollment_options = $kids->getApplicantData(NULL);
$data = mysqli_fetch_assoc($enrollment_options);

$_SESSION['applicant_id'] = $data['id'];
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$html = file_get_contents("http://php.betadelivery.com/choicekids/reports/job-application.php");

$dompdf->load_html($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF   
$dompdf->render();

//$dompdf->stream("hello.pdf");
$output = $dompdf->output();

$date = strtotime($data['created_date']);
$file_path = $_SERVER['DOCUMENT_ROOT']."/choicekids/user_uploads/applicants_cv_pdf/";
$file_name = $data['first_name']." ".$data['last_name']."_".date('d-m-Y',$date).".pdf";
$file = $file_path.$file_name;

$pdf = file_put_contents($file, $output);


if(!empty($pdf) && $pdf != FALSE){
   
    $mail = new MailBody();
    $admin_body = $mail->getApplicationAdminMailBody($_SESSION['position']);
    $applicant_body = $mail->getApplicationMailBody($data['first_name']);
    $subject = $_SESSION['position']." ".$_SESSION['center_name'];
    $cv = $data['applicatant_cv'];

    $admin_mail = $kids->sendMail(ADMIN_EMAIL, EMAIL_FROM, $admin_body, $subject, $file_name, $cv);
    $applicant_mail = $kids->sendMail($data['email'], EMAIL_FROM, $applicant_body, $subject,NULL,NULL);
    
    if($admin_mail == TRUE && $applicant_mail == TRUE){
        echo "<script>window.open('".SERVER_URL."thank_you.php?pos=".$data['job_position']."&cen=".$data['job_center']."','_self');</script>";
    }else{
        echo "0";
    }
}