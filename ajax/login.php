<?php  
	session_start();
	include '../config.php';		
	// print_r($_POST);
	if(isset($_POST["username"]))
	{	
		$mail=$con->real_escape_string($_POST["username"]);
	   	$password=$con->real_escape_string($_POST["password"]);
	   	
	   	$qry = "select * from user_profile where mail='".$mail."'";
	   	$res=$con->query($qry);
	   	$count = $res->num_rows;
	   	
	   	if($count == 1)
	   	{
	   		$row = $res->fetch_assoc();
	   		$pass = $row["password"];

	   		if($password == $pass)
	   		{
	   			$_SESSION["id"] = $row["user_id"];
	   			$_SESSION["user"] = $row["username"] != '' ? $row['username'] : $row['mail'];
	   			$_SESSION["pic"] = $row["img_path"];
                $_SESSION["email"] = $row["mail"];
                $_SESSION["mobile"] = $row["mobile"];

	   			$qry = 'select * from event_details where user_id = '.$_SESSION["id"] . ' and status = 1' ;
	   			$row = $con->query($qry)->fetch_assoc();
	   			
	   			$_SESSION["eId"] = $row['e_id'];
	   			
				echo 'OK';	   			
	   		}else{
	   			echo 'NO';
	   		}	   		
	   	}else{	   		
	   		echo 'NO';
	   	}

	}