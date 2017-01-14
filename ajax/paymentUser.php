<?php 
	session_start();
	include '../config.php';

	if(isset($_POST['newUser'])){		
		$qry = "select * from user_profile where mail = '".$_POST['newUser']."'";
	    $res = $con->query($qry);
	    $count = $res->num_rows;	    
	    if($count > 0){	   	        
	        $row = $res->fetch_assoc();	
	        if(isset($_SESSION['id'])){	        
		        if($row['user_id'] !== $_SESSION['id']){

		        	$_SESSION["oldid"] = $_SESSION["id"];
			        $_SESSION["id"] = $row['user_id'];
					$_SESSION["user"] = $row["username"];
					$_SESSION["pic"] = $row['img_path'];
			        $_SESSION["email"] = $row["mail"];    
			        $_SESSION["mobile"] = $row["mobile"];
			    }else{
			    	echo 'same';
			   	}
			}else{								
		        $_SESSION["id"] = $row['user_id'];
				$_SESSION["user"] = preg_replace('/@(.*)$/','',$row["mail"]);
				$_SESSION["pic"] = $row['img_path'];
		        $_SESSION["email"] = $row["mail"];    
		        $_SESSION["mobile"] = $row["mobile"];		        
			}
	    }else{	    
			$qry = "insert into user_profile (mail,img_path,user_status) values ('".$_POST['newUser']."','images/usericon.png',0)";					
			$res = $con->query($qry);
			$id = $con->insert_id;			
			if($res){
				$_SESSION["oldid"] = $_SESSION["id"];
				$_SESSION["id"] = $id;
	   			$_SESSION["user"] = preg_replace('/@(.*)$/','',$_POST["newUser"]);
	   			$_SESSION["pic"] = 'images/usericon.png';
	            $_SESSION["email"] = $_POST["newUser"];    

				echo 'OK';
			}
		}
	}
	
	if(isset($_POST['newMobile'])){	
		$qry = '';
		if($_POST['verify']){
			$otp = random_numbers(6);			
			$text = 'Use '.$otp.' as your verification code to confirm your Mobile number for Festivito account.';
			sendMessage($text,$_POST["newMobile"]);
			$qry = "update user_profile set mobile = ".$_POST['newMobile'].", otp = ".$otp." where mail = '".$_POST['email']."' ";		
		}else{			
			$qry = "update user_profile set mobile = ".$_POST['newMobile']." where mail = '".$_POST['email']."' ";		
		}
		$res = $con->query($qry);		
		if($res){			
			$_SESSION["mobile"] = $_POST["newMobile"];
			echo 'OK';
		}
	}

	if(isset($_POST['otp'])){
		$qry = "select * from user_profile where mail = '".$_SESSION['email']."'";		
		$res = $con->query($qry);

		if($res){
			$row = $res->fetch_assoc();			
			if($row['otp'] === $_POST['otp']){
				echo 'OK';
			}else{
				echo 'NO';
			}
		}
	}