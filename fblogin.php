<?php
if(!session_id()) {
    session_start();
}
require_once __DIR__ . '/requested/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
'app_id' => '292470247797392', // Replace {app-id} with your app id
'app_secret' => 'a2f83a6932d3a19eaa21d3d8d6ccc483',
'default_graph_version' => 'v2.7',
    'default_access_token' => '292470247797392|a2f83a6932d3a19eaa21d3d8d6ccc483',
    'persistent_data_handler' => 'session'
]);

$helper = $fb->getRedirectLoginHelper();

if(isset($_SESSION['fb_access_token']))
{
    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,name,email,first_name,last_name,gender,picture.width(200)',$_SESSION['fb_access_token']);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    }
    catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $profile = $response->getGraphUser()->asArray();

    //echo 'Name: ' . $user['name'];
//    echo '<pre>';
//    print_r($profile);
//    echo '</pre>';

//    echo $dob = isset($profile["birthday"]) ? $profile["birthday"]->format('Y-m-d') : '';
//    echo 'Logging with Facebook Successful. Sit Tight you\'ll be redirected to Troviday.com soon!!!' ;
    echo '<body style="background-color: #f5f5f5;">'
            .'<div style = "width:auto;margin:18% auto auto auto;">'
                .'<center>'
                .'<img src = "images/ripple.gif"  style = "width:50px;" />'
                .'<p style = "font-size: x-large;color: #767575;">these won\'t take long...</p>'
                .'</center>'
            .'</div>'
        .'</body>';
    $gen = $profile["gender"] = 'male' ? 0 : 1;

    include 'config.php';
//
    $qry = "select * from user_profile where fbid = ".$profile["id"];
//    echo $qry;
    $res= $con->query($qry);
    $co = $res->num_rows;
    if($co == 0)
    {
        $qry = "INSERT INTO `user_profile`(`username`, `firstname`, `lastname`, `mail`, `gender`,`img_path`,`user_status`,`fbid`) VALUES"
            ." ('".$profile["name"]."','".$profile["first_name"]."','".$profile["last_name"]."','".$profile["email"]."','".$gen."','".$profile["picture"]["url"]."','1','".$profile["id"]."')";
//            echo $qry;
        $res = $con->query($qry) or die (mysqli_error($con));
        if($res)
        {
            $qry = "select * from user_profile where fbid = ".$profile["id"];
//            echo $qry;

            $res= $con->query($qry);
            $row = $res->fetch_assoc();

            $_SESSION["id"] = $row["user_id"];
            $_SESSION["fid"] = $row["fbid"];
            $_SESSION["user"] = $row["username"];
            $_SESSION["pic"] = $row["img_path"];
            $_SESSION["email"] = $row["mail"];
//            $_SESSION["mobile"] = $row["mobile"];
            // include 'requested/mails.php';
            $whitelist = array(
                    '127.0.0.1',
                    '::1'
                );
            $base = '';


            if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {                
                $base = "/";
            }else{      
                $base = 'http://www.festivito.com/';
            }

            ob_start();
                include "requested/welcomeMail.php";
                $message = ob_get_contents();
            ob_end_clean();
//             echo $message;
            $to = $_SESSION["email"];
            $subject = "Greetings from Festivito.";

            sendMail($to,$message,$subject);
            
            echo '<script>window.setTimeout(function(){window.location.href = "http://www.festivito.com/Home/";}, 2000);</script>';
        }
    }
    else
    {
        $row = $res->fetch_assoc();
        $_SESSION["id"] = $row["user_id"];
        $_SESSION["user"] = $row["username"];
        $_SESSION["fid"] = $row["fbid"];
        $_SESSION["pic"] = $row["img_path"];
        $_SESSION["email"] = $row["mail"];
        $_SESSION["mobile"] = $row["mobile"];
//        echo $_SESSION["id"].$_SESSION["user"].$_SESSION["pic"];
        $_SESSION["newUser"] = "new";
//        header('Location: Home/');
//        echo '<script>window.location = "Home/";</script>';
        echo '<script>window.setTimeout(function(){window.location.href = "http://www.festivito.com/Home/";}, 3000);</script>';

    }
//
}

//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';


?>

