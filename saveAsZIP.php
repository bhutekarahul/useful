<?php
session_start();
include './connection.php';

$sql = "SELECT * FROM project_closure WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'";
$query = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($query);

$arr = explode(',',$data['files']);


function zipFilesDownload($file_names,$archive_file_name,$file_path){
$zip = new ZipArchive();
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
  exit("cannot open <$archive_file_name>\n");

}
foreach($file_names as $files){
  $zip->addFile($file_path.$files,$files);
}
$zip->close();


header("Content-type: application/zip"); 
header("Content-Disposition: attachment; filename=$archive_file_name"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
readfile("$archive_file_name"); 
//exit;
}


//$fileNames=array('files/file1.docx','files/file1.pdf');
$zip_file_name=$data['project_name'].'.zip';
$file_path=dirname(__FILE__).'/';
//$file_path = "http://betadelivery.com/rahuldev/projectClosure/";

zipFilesDownload($arr,$zip_file_name,$file_path);