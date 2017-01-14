<?php
    $file = basename($_SERVER["PHP_SELF"],".php");
    if($file == 'fblogin'){

        $email = $_SESSION["email"];
        $msg = "Success with Facebook";
        $subject = "Welcome to Festivito";
        sendMail($email,$msg,$subject);
    }

?>