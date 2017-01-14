<?php 
	session_start();
	include '../../config.php';

	if(isset($_POST['username']) && isset($_POST['password'])){
		$qry = 'select * from admin where username = "'.$_POST['username'].'" and password = "'.$_POST['password'].'"';		
		$res = $con->query($qry);

		if($res){
			$row = $res->fetch_assoc();
			$_SESSION['adminId'] = $row['admin_id'];
			$_SESSION['adminUsername'] = ucwords($row['username']);
			echo 'OK';
		}else {
			echo 'NO';
		}
	}else{
		echo 'NO';
	}
?>