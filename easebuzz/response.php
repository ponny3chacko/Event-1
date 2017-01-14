<?php
session_start();
    include_once 'easepay-lib.php';
    include '../config.php';
    $SALT='GX8VBY9WGF';
    $result = response( $_POST, $SALT );
    // echo '<pre>';
    // print_r($result);
    // print_r($_POST);
    // echo '</pre>';
    
    if(isset($_POST["status"])){

    $_POST["qty"] = $_SESSION["qty"];
    $_POST["eventid"] = $_SESSION["eventid"];
    $_POST['bookid'] = insertBookData($con,$_SESSION['id'],$_POST);
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    echo $out = paymentStatus($con,$_POST,$SALT,$_SESSION['id']);

  }
  
?>
