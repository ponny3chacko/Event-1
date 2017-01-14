<?php
	session_start();
    include '../config.php';

    if(isset($_POST['signUsername'])){
    	$form_data = array(
    		'username' => $_POST['signUsername'],
    		'mail' => $_POST['signEmail'],
    		'password' => $_POST['signPassword'],
    		'mobile' => $_POST['signMobile'],
    		'img_path' => 'images/usericon.png',
    		'user_status' => 0
    		);
    	$res = dbRowInsert($con,'user_profile', $form_data);
    	$id = $con->insert_id;
    	if($res){
    		$_SESSION["id"] = $id;
   			$_SESSION["user"] = $_POST["signUsername"];
   			$_SESSION["pic"] = 'images/usericon.png';
            $_SESSION["email"] = $_POST["signEmail"];
            $_SESSION["mobile"] = $_POST["signMobile"];
    		echo 'OK';
    	}
    }