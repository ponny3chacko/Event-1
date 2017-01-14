<?php 
	session_start();	
	include '../config.php';
 	
    if(isset($_POST['username'])){    
        $where_clause = 'where user_id = '.$_SESSION["id"];
      	$form_data = array(
        'username' => $_POST['username'],
    	'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'mail' => $_POST['email'],
        'gender' => $_POST['gender'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],    
        'zip' => $_POST['zip'],
        'mobile' => $_POST['mobile'],
     	);
     	if(isset($_FILES['profile'])){
    		
            $fileName = $_FILES['profile']['name'];
            $tmp = $_FILES['profile']['tmp_name'];
            $exe = pathinfo($fileName, PATHINFO_EXTENSION);
            $des = '../images/profile/';
            $t = time()."-".rand();
            $fileName = $t.".".$exe;
            $targetFile = $des.$fileName;

     		$newName = '../images/profile/'.time().'-'.rand().'.'.end($exe);

     		if(move_uploaded_file($tmp, $targetFile)){ 
                
                list($width, $height, $type, $attr) = getimagesize($targetFile);
                resizeImage($targetFile, $targetFile, $width, $height);

                $qry = "select * from user_profile where user_id = ".$_SESSION["id"];
                $res = $con->query($qry);

                if($res){
                    $row = $res->fetch_assoc();
                    if($row['img_path'] !== ''){          
                        unlink($row['img_path']);
                    }                    
                }
     			$form_data['img_path'] = $targetFile;

    			$_SESSION["pic"] = $form_data["img_path"];
     		} 		
     	} 	
    	$res = dbRowUpdate($con, 'user_profile', $form_data, $where_clause);
    	
    	if($res){
    		$_SESSION["user"] = $form_data["username"];
            $_SESSION["email"] = $form_data["mail"];
            $_SESSION["mobile"] = $form_data["mobile"];
            echo 'OK';
    	}
    }

    if(isset($_POST['companyName'])){
        $where_clause = 'where c_user_id = '.$_SESSION["id"];
        $form_data = array(
        'c_name' => $_POST['companyName'],
        'c_description' => $_POST['companyAbout'],
        'c_address' => $_POST['companyAddress'],
        'c_city' => $_POST['companyCity'],
        'c_zip' => $_POST['companyZip'],        
        'c_email' => $_POST['companyEmail'],        
        'c_mobile' => $_POST['companyMobile'],
        'c_url' => $_POST['companyWebsite']
        );
        $res = dbRowUpdate($con, 'company_profile', $form_data, $where_clause);
        
        if($res){            
            echo 'OK';
        }
    }

    if(isset($_POST['holderName'])){
        $where_clause = 'where b_user_id = '.$_SESSION["id"];
        $form_data = array(
        'holder_name' => $_POST['holderName'],
        'act_number' => $_POST['accountNum'],
        'bank_name' => $_POST['bankName'],
        'branch' => $_POST['branch'],
        'ifsc' => $_POST['ifsc'],        
        'type' => $_POST['actType']        
        );
        $res = dbRowUpdate($con, 'bank_detail', $form_data, $where_clause);
        
        if($res){            
            echo 'OK';
        }
    }
    print_r($_POST);
    if(isset($_POST['oldPass'])){
        $qry = "select * from user_profile where user_id = ".$_SESSION["id"];
        echo $qry;
        $res = $con->query($qry);
        if($res){            
            $row = $res->fetch_assoc();
            if($row['password'] == $_POST['oldPass']){                
                $where_clause = 'where user_id = '.$_SESSION["id"];
                $form_data = array(        
                'password' => $_POST['newPass']        
                );
                $res = dbRowUpdate($con, 'user_profile', $form_data, $where_clause);
                
                if($res){  
                        
                    echo 'OK';
                } 
            }else {
                
                echo 'NO';
            }
        }        
    }