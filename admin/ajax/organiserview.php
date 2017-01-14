<?php 
include '../../config.php';	

print_r($_POST);
if(isset($_POST["nm"]))
{
	$id = $_POST["nm"];
	$chk = $_POST["tog"];
	$qry = "";  
	if($chk == "true")
	{
		$qry = "UPDATE `event_details` SET `status`= 0 WHERE `e_id` = ".$id;
	}
	else
	{
  		$qry = "UPDATE `event_details` SET `status`= 1 WHERE `e_id` = ".$id;
	}
	// echo $qry;
	$con->query($qry);
}
?>