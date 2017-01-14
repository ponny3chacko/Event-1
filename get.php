<?php 
session_start();

include 'config.php';
$tic_details = '';

$qry = "select * from ticket_details where tic_id in (".implode(',',$_SESSION['ticids']).")";

$res = $con->query($qry);
$i = 0;
while($rowT = $res->fetch_assoc()){
	$tic_details .= '<div>'.$rowT['tic_name'].' X '.$_SESSION['ticqty'][$i].'</div>';
}

ob_start();

include "mail.php";

$message = ob_get_contents();

$subject = 'Booking Confirmation of ';
$email = 'ch.chhuchha@hotmail.com';
ob_end_clean();


// echo $message;
