<?php
 function sanitize_output($buffer)
 {
     $search = array(
         '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
         '/[^\S ]+\</s',  // strip whitespaces before tags, except space
         '/(\s)+/s'       // shorten multiple whitespace sequences
         );
     $replace = array(
         '>',
         '<',
         '\\1'
         );
     $buffer = preg_replace($search, $replace, $buffer);
     return $buffer;
 }
   ob_start("sanitize_output");
ini_set('display_errors', '1');
session_start();

require 'config.php';

require_once __DIR__ . '/requested/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
'app_id' => '292470247797392', // Replace {app-id} with your app id
'app_secret' => 'a2f83a6932d3a19eaa21d3d8d6ccc483',
'default_graph_version' => 'v2.7',
    'default_access_token' => '292470247797392|a2f83a6932d3a19eaa21d3d8d6ccc483',
    'persistent_data_handler' => 'session'
]);


$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://www.festivito.com/fb-callback.php', $permissions);

$tags = "";
$rw = "";
$eve = '';
$file = basename($_SERVER["PHP_SELF"],".php");
if(isset($_GET["event"]) || isset($_POST['eventid']))
{
  $eve = isset($_GET["event"]) ? $_GET["event"] : $_POST["eventid"];
  $rw = selectTicket($con,$eve);
  $tags =explode(",",$rw["tags"]);    
}else{
  $eve = '';
}
if(!isset($_SESSION["gloCity"])){  
  $_SESSION["gloCity"] = '%';
} else{
  if($_SESSION["gloCity"] == '%'){
    $_SESSION["gloCity"] == '%';
  }
}
list($title, $keywords, $description) = array_values(SEO($con,$file,$eve));


?>
<!DOCTYPE HTML>
<html>
<head>    
  <link rel='icon' href='images/event icon.png' type='image/x-icon'>    
  <title><?php echo $title !== '' ? $title : 'Festivito | '.str_replace('/','',$_SERVER['REQUEST_URI']); ?></title>

  <base href="<?php echo $base;?>">
 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name = "author" http-equiv = "author" content = "Festivito" />
  <meta name = "keywords" http-equiv = "keywords" content = "<?php echo $keywords; ?>" />
  <meta name = "description" http-equiv = "description" content = "<?php echo $description; ?>" />
  <link rel="canonical" href="http://www.festivito.com<?php echo $_SERVER['REQUEST_URI']?>">
  <meta name="google-site-verification" content="Vv85jaOgo7IOwo0-AXbfJI5bDi2tent49KqGJZTp-5k" />
  <meta name="google-site-verification" content="Vv85jaOgo7IOwo0-AXbfJI5bDi2tent49KqGJZTp-5k" />
  
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
  <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />  
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
  <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
  <link href="css/quill.snow.css" rel="stylesheet">

  <script type="text/javascript" src="js/jquery.min.js"></script>
  <?php //echo $file === 'payment' ? '<script type="text/javascript" src="js/jquery.min.js"></script>' : '' ; ?>
  <script type="text/javascript" src="js/customHeader.js"></script>
  
   
<!-- start plugins -->
  

  <script>
      var timeCookie='';
      $(document).ready(function(){
          timeCookie = timeZone();
      });

if(document.cookie.indexOf("GMT_bias") < 0){  
  location.reload();
}

  
  <?php
  isset($_COOKIE['GMT_bias'])? $date = timeZoneDate() : '';

    if(isset($_SESSION['try']) && isset($_POST['status']) ){
      unset($_SESSION['try']);
    }

  ?>      
     
      window.addEventListener("load", window.setTimeout(function(){
        var load_screen = document.getElementById("load_screen");
        load_screen.style.display = 'none'; 
      },2000));
    
      // $('#gateway').css('color','red');
      // var gateway = document.getElementById("gateway"); 
      // gateway.style.color = 'red';
    // Geting current timezone
  
    
  </script>
</head>
<body>
<!--Code for loading animation during index page is loaded-->

<div id="load_screen">
  <div id="loading">
    <img src = "images/ripple.gif"  style = "width:50px;" />
    <p id = "gateway" <?php echo (isset($_SESSION['try']) && $file === 'payment') ? 'style = "display:block;"' : ''; ?>>You'll be redirected to Payment Gateway.</p>
  </div>
</div>

<div class="container">

<div class="container_wrap">

<div class="container4">
  <div class="container3">
  <?php
  if(isset($_SESSION['fid'])){
    $qry = "select * from user_profile where fbid = '".$_SESSION['fid']."'";
    $res = $con->query($qry);
    if($res){
      $row = $res->fetch_assoc();
      if($row['mobile'] === '' || $row['mobile'] === NULL || $row['status'] === 1){
        ?>
          <div id = "mobileBox" class="white_content">              
            <div class="col-md-12 fbBox">        
              <div id = "mobileDiv">
                <h3 class="text-center" id = "headMsg">We want your number to keep updating you about latest Events!</h3>
                <div class="form-group" id = "mobileDiv">
<div class="col-lg-12">
                  <label class=" col-xs-12 col-lg-3">Mobile No:</label>
                  <div class="col-xs-12 col-lg-6">
                    <input type="text" name="mobile" class = "form-control text-center fb col-md-12" id = "mobileNum" maxlength="10" autosave="off" autocomplete="off" placeholder="99XXXXXXXX">
                    <div id = "errMobile" class="loginError"></div>
                  </div>

                  <input type="hidden" name="email" id = "fbEmail" value = "<?php echo $_SESSION['email'];?>">
                  <button class = "btn btn-primary col-md-3 col-xs-10 col-lg-offset-4 col-md-offset-1  col-xs-offset-1" id = "mobileBtn">Add</button>
</div>
                </div>
              </div>
              <!-- Verification -->
              <div id = "otpDiv" style="display: none;">
                <h3 class="text-center" id = "verifyBox">We had sent you an OTP to <span id = "verifyMobile"></span>.</h3>
                <div class="form-group">                
                  <div class="col-md-6">
                    <input type="text" name="mobile" class = "form-control text-center col-md-6 col-md-offset-6 otp" id = "verifyOtp" maxlength="6" placeholder="123456" autosave="off" autocomplete="off">
                    <div id = "errOtp" class="loginError text-center col-md-offset-6"></div>
                  </div>                
                  <button class = "btn btn-primary col-md-3 col-xs-offset-3 " id = "verifyBtn">Verifiy</button>
                </div>
              </div>
            </div>      
          </div>
          <div id="mobileFade" class="black_overlay"></div>
          
          
        <?php
       }
     }
   }
?>
          <?php 
          if(isset($_GET['new'])){
          ?>
          <div id = "newUserBox" class="white_content demo" role="dialog">              
            <button type="button" class="close" id = "closePop">&times;</button>              
            <div class="col-md-12 fbBox">                      
              <h3 class="text-center" id = "headMsg">You Need to Login first, for Creating a new Event.</h3>
            </div>
          </div>
          <div id="mobileFade" class="black_overlay"></div>
          <?php
          } 
          ?>
    <div class="nav_list">
      <ul>        
        <a href="Home/"><li>Home | </li></a>
        <a href="ContactUs/"><li>Contact</li></a>
      </ul>
    </div>
    
    <?php
    if(isset($_SESSION["id"]))
    {
      ?>
      <div class="withlogin-header">
        <ul >
          <?php echo $file == 'create_event' ? '<a href="javascript:void(0);" id = "help"> <li> <i class="fa fa-question" aria-hidden="true"></i> Help | </li></a>' : ''; ?>
          <a href="AddEvent/"> <li><i class="fa fa-file-text" aria-hidden="true"></i> Create Event | </li></a>
          <a href="Organizer/"><li> <i class="fa fa-street-view" aria-hidden="true"></i>  Organizer View</li></a>
        </ul>
      </div>
      <?php
    }
    ?>

    <div class="clear"></div>
  </div>
</div>
<div class="header_top">
  <div class=" logo"><a href="Home/"><img src="images/logo.png" alt="Festivito"/></a></div>
  <div class="banner_desc">
    <form name ="searchform" action="Show/" method = "post">
      <!-- <div class="conlable"> -->
      <div class="conlable">
        <input id="searchInput" name = "eventname" placeholder="Search by Event Types OR Event name... " autocomplete="off" >
          <i class="fa fa-search" aria-hidden="true"></i>
      </div>
      <input type="hidden" id = "eventHidden" name="eventid">
      <!-- <div class="conlable-search"> SEARCH</div> -->
    </form>
    <div class="scrollbar" id = "typesBox" style="display: none;">
      <div class="my-searchlist">
        <ul id="searchBox">
          <?php
            $row = getCategories($con);
            foreach ($row as $key => $val){
              echo '<li id="'.$row[$key]['cat_id'].'"> <i class="'.$row[$key]['cat_icon'].'" aria-hidden="true"></i> '.$row[$key]['cat_name'].' </li>';
            }
          ?>
            <li id = "all"><i class="fa fa-list"></i> All Events </li>
        </ul>
        <div class="clearfix"></div>
        <div class="sub-categories1 " id="events" style="display: none;">
          <h3>Select Event </h3>
          <div class="sub-categories style-4 " id="allEventDiv" >
            <ul id="allEvents">

            </ul>
          </div>
        </div>
        <div class="force-overflow"> </div>
      </div>
    </div>
  </div>
  <div class=" headeright">
    <select class="conlable-city" name = "selectCity" onchange = "cityse(this.value);">
      <?php echo isset($_SESSION["gloCity"]) ? '<option value = "%">All</option>' : '<option value = "%">Select City</option>'; ?>
      <?php

            $qry = "select DISTINCT city_name, city_id from cities inner join event_details on city_id = event_city_id";
            // echo $qry;
            $res=$con->query($qry);
            while($row = $res->fetch_assoc())
            {
              $ch ='';
                if(isset($_SESSION["gloCity"])){
                  if($_SESSION["gloCity"] == $row['city_id']){
                    $ch = 'selected';
                  }
                }                
                echo '<option value = '.$row['city_id'].' '.$ch.'>'.$row['city_name'].'</option>';
            }
          ?>
    </select>

      <?php
      if(isset($_SESSION["id"]))
      {
      ?>
        <div class="personal-details" id="profile">
         <img class="img1" src="<?php echo $_SESSION["pic"];?>" alt = "<?php echo $_SESSION["user"]; ?>">
            <div class="personal-name">  <?php echo $_SESSION["user"]; ?></div>

          <i class="fa fa-bars" aria-hidden="true"></i>
        </div>
        <div class="login-result" id="subMenu">
          <ul>
            <a href="Profile/<?php echo $_SESSION["user"]; ?>/" ><li><i class="fa fa-user" aria-hidden="true"></i> My Profile</li></a>
            <a href="Profile/<?php echo $_SESSION["user"]; ?>/"><li><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile</li></a>
              <a href="History/"><li><i class="fa fa-calendar" aria-hidden="true"></i> Booked History</li></a>
            <a href="Profile/<?php echo $_SESSION["user"]; ?>/Change/"> <li><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password </li></a>
          </ul>
          <a href="Signout"><h3> Log Out</h3></a>
        </div>
      <?php
      }
      else{
        ?>
        <ul class="header_right_box"  id="loginBox">
          <li><a href="javascript:void()"><i class="fa fa-file" aria-hidden="true"></i> Create Event</a></li>
          <li><a href="javascript:void()"><i class="fa fa-user" aria-hidden="true"></i> Login | </a></li>

          <div class="clearfix"> </div>
        </ul>
      <?php
      }
      ?>

  </div>

  <div class="clearfix"> </div>
<!--    <div class="login-main" id="loginMain">-->

        <div class="login-box"  id="loginMain">
          
          <div class="loginLoadingBox" id="loadScreen">
            <div class="loginLoading">
              <img src = "images/ripple.gif"  style = "width:50px;" />
            </div>
          </div>

           <b> <i class="glyphicon glyphicon-triangle-top" aria-hidden="true"></i></b>
           <form id = "loginForm">
            <div class="login-one" id = "loginBlock">
        <div class="">
            <input type="text" class="login-btn-new" placeholder="Email" aria-describedby="basic-addon1" id="username" autocomplete="off"  autosave="off">            
        </div>
        <div class="">
            <input type="password" class="login-btn-new" placeholder="Password" aria-describedby="basic-addon1" id="password"  autocomplete="off" autosave="off">
        </div>
        <div id="errorMsg" class="loginError"></div>
        <div class="login-button">
            <button type="submit" id = "loginBtn" class="acount-btn" > <i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
          </form>
            <p>Forget Passowrd ?</p>

        </div>
        <div class="clearfix"></div>
            <div class="login-facebook">                
            <?php            
                  //destroy facebook session if user clicks reset
                  if(!isset($_SESSION['fb_access_token'])){

                    $output = '<a href="' . htmlspecialchars($loginUrl) . '" class="btn btn-block btn-social btn-facebook">'
                                    .'<i class="fa fa-facebook-official"></i> SignUp with Facebook'
                                    .'</a>';  
                    echo $output;
                  }                           
                ?>                  

                </div>
            <div class="clearfix"></div>

            <button id = "signUpBtn" class="btn create-btn" ><i class="fa fa-external-link" aria-hidden="true"></i> Create an Account</button>
          </div>
            <div class="clearfix"></div>


            <div class="login-two" id = "signUpBlock">
              <form method="post" id = "signUpForm">
                <div class="">

                    <input type="text" id = "signUsername" name="signUsername" class="login-btn-new" placeholder="Username" aria-describedby="basic-addon1">
                    <div id = "errUsername" class="loginError"></div>
                </div>
                <div class="">

                    <input type="Email" id = "signEmail" name="signEmail" class="login-btn-new" placeholder="Email" aria-describedby="basic-addon1">
                    <div id = "errEmail" class="loginError"></div>
                </div>
                <div class="">

                    <input type="Mobile" id = "signMobile" name = "signMobile" maxlength="10" class="login-btn-new" placeholder="Mobile Number" aria-describedby="basic-addon1">
                    <div id = "errMobile" class="loginError"></div>
                </div>
                <div class="">

                    <input type="Password" id = "signPassword" name = "signPassword" class="login-btn-new" placeholder="Password" aria-describedby="basic-addon1">
                    <div id = "errPassword" class="loginError"></div>
                </div>
                <div class="">

                    <input type="Password" id = "signCPassword" class="login-btn-new" placeholder="Confirm Password" aria-describedby="basic-addon1">
                    <div id = "errConfirmPassword" class="loginError"></div>
                </div>
                <div class="clearfix"></div>
                <div class="login-screen">
                    <input type="checkbox" id="signTerm" name="signupchk" id="signUpBtn" checked>
                    <span>
                    <a href="TermsConditions" title="Terms of Services">By signing up, you agree to our terms and conditions and privacy policy.</a>
                </span>
                </div>
                <div class="login-button">
                    <button type="submit" id = "signUpBtn1" class="btn create-btn" ><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</button>


                </div>
                </form>
                <div class="clearfix"></div>
                <div class="login-facebook">
                <?php            
                  //destroy facebook session if user clicks reset
                  if(!isset($_SESSION['fb_access_token'])){

                    $output = '<a href="' . htmlspecialchars($loginUrl) . '" class="btn btn-block btn-social btn-facebook">'
                                    .'<i class="fa fa-facebook-official"></i> SignUp with Facebook'
                                    .'</a>';  
                    echo $output;
                  }                           
                ?>                  

                    </div>
                <div class="clearfix"></div>
<div class="login-button">
                  <p>Already a User ?</p>
                  <button type="button" id = "sLoginBtn" class="acount-btn" > <i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>

              </div>
              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        <div class="clearfix"></div>
    </div>
</div>
<?php 
  $opage = array('index','book','bookHistroy');
  if(!in_array($file, $opage)){
?>
<div class="scrollbar-new">
   <div class="nav-new id = "gallery" ">
       <div class="nav-new-left" id = "left-button">
       <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
       </div>
       <div class="nav-new-middle style-6" id = "gallery">
           <ul id = "content">
              <a href="Organizer/"><li>Current Events</li></a>
              <a href="PastEvents/"><li>Past Events</li></a>
              <a href="Transactions/"> <li>All Transactions</li></a>
              <a href="Incomplete/"> <li>Incomplete Transaction</li></a>
              <a href="Cancel/">   <li>Cancel Transaction</li></a>
           </ul>
       </div>
       <div class="nav-new-right" id = "right-button">
           <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
       </div>

   </div>

</div>
<?php } ?>
