<?php 
	include '../../config.php';
	// $date = timeZoneDate();
	print_r($_POST);
	// $start = date('Y-m-d H:i:s',strtotime($_POST['startdate']));
	// $end = date('Y-m-d H:i:s',strtotime($_POST['enddate']));
	$targetFile = '';
	if(isset($_FILES['eventPic'])){
		$fileName = $_FILES['eventPic']['name'];
		$tmp = $_FILES['eventPic']['tmp_name'];
		$exe = pathinfo($fileName, PATHINFO_EXTENSION);
		$des = '../images/event/';
		$t = time()."-".rand();
		$fileName = $t.".".$exe;
		$targetFile = $des.$fileName;
		
		if(move_uploaded_file($tmp, '../'.$targetFile)){
			list($width, $height, $type, $attr) = getimagesize('../'.$targetFile);
			resizeImage($targetFile, $targetFile, $width, $height);			
		}else {
			$targetFile = '';
		}	
	}
	$data = array(
		'title' => $_POST['title'],
		'start_date' => $_POST['startdate'], 
		'end_date' => $_POST['enddate'],
		'description' => $_POST['description'],
		'category' => $_POST['category'],
		'e_terms' => $_POST['terms'],
		'banner_img' => $targetFile,
		'address' => $_POST['address'],
		'event_city_id' => $_POST['city_id'],
		'email' => $_POST['email'],
		'user_id' => $_POST['user_id'],
		'status' => 0,
		'e_fb_link' => $_POST['fb'],
		'e_twitter_link' => $_POST['tw']
		);
	
	if(dbRowInsert($con,'event_details', $data)){
		echo 'OK';
	}else {
		echo 'NO';
	}
?>