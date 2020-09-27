<?php
require_once '../../config/connection.php';
require_once '../common/function_admin.php';

$obj = new Admincontroller();

if(!empty($_POST['record_per_page']) && !empty($_POST['section_name'])){
    $record_per_page = $_POST['record_per_page'];
    if(isset($_POST['center'])){
        $center = $_POST['center'];
    }else{
        $center = "";
    }
            
    $page = '';
    $output = '';
    if (isset($_POST["page"])) {
        $page = $_POST["page"];
    } else {
        $page = 1;
    }
    
    $start_from = ($page - 1) * $record_per_page;
    
    $allJobs = $obj->getAllJobs($start_from, $record_per_page, $center);
    while ($row = mysqli_fetch_assoc($allJobs)) {
        $jobs[] = $row;
    }

    if($jobs > 0){
        $i=1;
        foreach($jobs as $job){
                        
            $description = $job['job_desc'];
            if(strlen($description) > 75) {
                $description = substr($description, 0, strpos($description, ' ', 75));
            }
                        
            $competencies = $job['competencies'];
            if(strlen($competencies) > 75) {
                $competencies = substr($competencies, 0, strpos($competencies, ' ', 75));
            }
            
            $other = $job['other'];
            if(strlen($other) > 75) {
                $other = substr($other, 0, strpos($other, ' ', 75));
            }
            
            if($job['status'] == 1){
                $attr = "checked";
            }else{
                $attr = "";
            }
            
            $output .= '<div class="block-item">
                            <div class=" tender_section green-strip">
                                <div class="row">
                                    <div class="box-typical-section col-sm-4">  <span class="sr-no">Sr. No. '.$i.'</span></div>
                                    <div class="box-typical-section col-sm-3"></div>
                                    <div class="box-typical-section col-sm-5">
                                        <div class="form-group row d-flex-center justify-content-center">

                                            <div class="checkbox-toggle">
                                                <input type="checkbox" '.$attr.' class="toggle_status" id="check-toggle-'.$i.'" name="status_id" value="'.$job['id'].'" data-status="'.$job['id'].'" />
                                                <label for="check-toggle-'.$i.'">Status</label>
                                            </div>
                                            <div class="head-btns">
                                                <a href="edit-jobs.php?id='.$job['id'].'" class="btn btn-inline btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="" id='.$job['id'].' data-toggle="modal" data-target="#delete_job" class="btn btn-inline btn-danger delete_job"><i class="fa fa-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class=" tender_section">
                                <div class="row border-btm">  
                                    <div class="box-typical-section col-sm-3">
                                        <div class="form-group row">
                                            <div class="col-xl-4">
                                                <label class="form-label"> Position:</label>
                                            </div>
                                            <div class="col-xl-8">
                                                <p>'.$job['position'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-typical-section col-sm-3">

                                        <div class="form-group row">
                                            <div class="col-xl-4">
                                                <label class="form-label"> Centre:</label>
                                            </div>
                                            <div class="col-xl-8">
                                                <p>'.$job['center'].'</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-typical-section col-sm-3">
                                        <div class="form-group row">
                                            <div class="col-xl-4">
                                                <label class="form-label"> Hours:</label>
                                            </div>
                                            <div class="col-xl-8">
                                                <p>'.$job['hours'].' hrs </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-typical-section col-sm-3">
                                        <div class="form-group row">
                                            <div class="col-xl-6">
                                                <label class="form-label"> Remuneration:</label>
                                            </div>
                                            <div class="col-xl-6">
                                                <p>$ '.$job['rennumeration'].' </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt20">  
                                    <div class="box-typical-section col-sm-4">
                                        <div class="form-group row">
                                            <div class="col-xl-12">
                                                <label class="form-label"> Job Description:</label>
                                            </div>
                                            <div class="col-xl-12">
                                                <p>'.$description.'</p>
                                                <button type="button" class="btn btn-inline btn-secondary view_job_desc" data-info="job_desc" id="'.$job['id'].'">View more</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-typical-section col-sm-4">
                                        <div class="form-group row">
                                            <div class="col-xl-12">
                                                <label class="form-label"> Competencies:</label>
                                            </div>
                                            <div class="col-xl-12">
                                                <p>'.$competencies.'</p>
                                                <button type="button" class="btn btn-inline btn-secondary view_job_comp" data-info="competency" id="'.$job['id'].'">View more</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-typical-section col-sm-4">
                                        <div class="form-group row">
                                            <div class="col-xl-12">
                                                <label class="form-label"> Other:</label>
                                            </div>
                                            <div class="col-xl-12">
                                                <p>'.$other.'</p>
                                                <button type="button" class="btn btn-inline btn-secondary view_job_other" data-info="other" id="'.$job['id'].'">View more</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
        $i++;}

        $allrecords = $obj->getAllJobs(NULL, NULL, $center);
        $total_records = mysqli_num_rows($allrecords);
        $total_pages = ceil($total_records / $record_per_page);
        $output .= '<div class="pgn-right"><ul class="pagination pagination-lg custom-pagination pull-right">
                <li class="page-item"><a href="#" class="pagination_link" id="1"><i class="fa fa-angle-double-left" ></i></a></li>';
    if($page == 1)
    {
        $output .= "<li class='page-item active'><a href=\"#\" class=\"active pagination_link\" id='".$page."'>".$page."</a></li>";
        if($total_records > $record_per_page)
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".++$page."'>".$page."</a></li>";
        if($total_records > $record_per_page+$record_per_page)
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".++$page."'>".$page."</a></li>";
    }
    else if ($page == $total_pages)
    {
        $secondLast = $page-1;$thirdLast = $page-2;
        if($thirdLast != 0){
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$thirdLast."'>".$thirdLast."</a></li>";
        }
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$secondLast."'>".$secondLast."</a></li>";
        $output .= "<li class='page-item active'><a href=\"#\" class=\"active pagination_link\" id='".$page."'>".$page."</a></li>";
    }
    else if ($page == 2)
    {
        $previous = $page-1;
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$previous."'>".$previous."</a></li>";
        $output .= "<li class='page-item active'><a href=\"#\" class=\"active pagination_link\" id='".$page."'>".$page."</a></li>";
        if(++$page <= $total_pages)
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$page."'>".$page."</a></li>";
        if(++$page < $total_pages)
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$page."'>".$page."</a></li>";
    }
    else if($page == ($total_pages-1))
    {
        $secondLast = $page-1;$thirdLast = $page-2;
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$thirdLast."'>".$thirdLast."</a></li>";
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$secondLast."'>".$secondLast."</a></li>";
        $output .= "<li class='page-item active'><a href=\"#\" class=\"active pagination_link\" id='".$page."'>".$page."</a></li>";
        if($page < $total_pages)
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".++$page."'>".$page."</a></li>";
    }
    else 
    {
        $secondLast = $page-1;$thirdLast = $page-2;
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$thirdLast."'>".$thirdLast."</a></li>";
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".$secondLast."'>".$secondLast."</a></li>";
        $output .= "<li class='page-item active'><a href=\"#\" class=\"active pagination_link\" id='".$page."'>".$page."</a></li>";
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".++$page."'>".$page."</a></li>";
        $output .= "<li class='page-item'><a href=\"#\" class=\"pagination_link\" id='".++$page."'>".$page."</a></li>";
    }
    $output .= '<li class="page-item"><a href="#" class="pagination_link" id="'.$total_pages.'"><i class="fa fa-angle-double-right"></i></a></li>
                </ul></div>';
    }else{
        if(!empty($center)){
            $output .= "No Vacant Jobs Found For Choosen Center";
        }else{
            $output .= "No Vacant Jobs Found";
        }
    }
    echo $output;
//    echo $total_records."<br>";
//    echo $record_per_page;
}

?>