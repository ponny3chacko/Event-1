<?php
include "../config.php";
    if(isset($_POST['username'])){
        $qry = "select * from user_profile where username = '".$_POST['username']."'";
        $res = $con->query($qry);
        $count = $res->num_rows;
        if($count > 0){
            echo 'OK';
        }
    }
    if(isset($_POST['email'])){
        $qry = "select * from user_profile where mail = '".$_POST['email']."'";
        $res = $con->query($qry);
        $count = $res->num_rows;
        if($count > 0){
            echo 'OK';
        }
    }