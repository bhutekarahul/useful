<?php
$description = $data['job_desc'];
if(strlen($description) > 75) {
    $description = substr($description, 0, strpos($description, ' ', 75));
}
