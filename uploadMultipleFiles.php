<?php	
	$dbpath_file="";
    $images_arr = array();
        foreach($_FILES['upload_file']['name'] as $key=>$val){
            //upload and stored images
            $target_dir = "Uploads/";
            $dbpath_file.= 'Uploads/'.$_FILES['upload_file']['name'][$key].',';
            $target_file = $target_dir.$_FILES['upload_file']['name'][$key];
            $uploading = move_uploaded_file($_FILES['upload_file']['tmp_name'][$key],$target_file);
        }
        $myfilepath = substr(trim($dbpath_file), 0, -1);

		if($uploading)
		{	
			$query="insert into project_closure (project_name, client_name,organization,email,phone_no,username,password,files,terms,status) values ('$project_name' ,'$client_name','$organization','$email','$phone_number','$username','$password','$myfilepath','$terms','N') ";
			$result= mysqli_query($conn , $query);    
		}