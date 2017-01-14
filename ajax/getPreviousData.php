<?php
session_start();
include '../config.php';
if(isset($_GET['terms'])){
	$qry = "select e_terms from event_details where e_id = ".$_SESSION['eId'];
	$res = $con->query($qry);
	$row = $res->fetch_assoc();	
	echo $row["e_terms"];
}else{
	$qry = "select description from event_details where e_id = ".$_SESSION['eId'];
	$res = $con->query($qry);
	$row = $res->fetch_assoc();	
	echo $row["description"];
}