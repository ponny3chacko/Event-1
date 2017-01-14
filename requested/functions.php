<?php
function id()
{
    $id ="";
    if(isset($_SESSION["id"]))
    {
        $id = $_SESSION["id"];
    }
    return $id;
}

function countTickets($con,$id)
{
    $qry = "select count(*) from ticket_detail where e_id = ".$id;
    $res = $con->query($qry);
    $row=$res->fetch_row();
    return $row[0];
}
function checkAuthority($con,$eid,$user){
    $qry = 'select * from event_details where user_id = '.$user.' and e_id = '.$eid;
    $res = $con->query($qry);
    $count = $res->num_rows;
    // echo $qry;
    if($count > 0){
        return true;
    }
    return false;
}
function Tickets($con,$id)
{
    $qry = "select * from ticket_detail where e_id = ".$id;
    $res = $con->query($qry);
    return $res->fetch_row();
}
function checkValue($value,$name){
    $date = timeZoneDate();
    if(empty($value)){
        if($name == 'date'){
            return $date;
        }
        return '';
    }else{
        return $value;
    }
}
function dbRowInsert($con,$table_name, $form_data)
{
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);
    $val = array_values($form_data);
    // build the query
    $sql = "INSERT INTO ".$table_name."(`".implode('`,`', $fields)."`)VALUES('".implode("','",$val)."')";
    // echo $sql."</br>";

    //$eve = $val[0];

    //echo select($con,$eve);
    // run and return the query result resource
    return $con->query($sql);
}

// again where clause is left optional
function dbRowUpdate($con, $table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
        $sets[] = "`".$column."` = '".addslashes($value)."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;
   // echo $sql;
    // run and return the query result
    return $con->query($sql);
}

function slug($string, $spaceRepl = "")
{
// Replace "&" char with "and"
    $string = str_replace("&", "and", $string);
// Delete any chars but letters, numbers, spaces and _, -
    $string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);
// Optional: Make the string lowercase
    $string = strtolower($string);
// Optional: Delete double spaces
    $string = preg_replace("/[ ]+/", " ", $string);
// Replace spaces with replacement
    $string = str_replace(" ", $spaceRepl, $string);
    return $string;
}


// Returns Time
  function timeZoneDate(){
    // date_default_timezone_set('UTC');    
    $fct_clientbias = $_COOKIE['GMT_bias'];

    $fct_servertimedata = gettimeofday();
    $fct_servertime = $fct_servertimedata['sec'];
    $fct_serverbias = $fct_servertimedata['minuteswest'];
    $fct_totalbias = $fct_serverbias - $fct_clientbias;
    $fct_totalbias = $fct_totalbias * 60;
    $fct_clienttimestamp = $fct_servertime + $fct_totalbias;
    $fct_time = time();
    $fct_year = strftime("%Y", $fct_clienttimestamp);
    $fct_month = strftime("%m", $fct_clienttimestamp);
    $fct_day = strftime("%d", $fct_clienttimestamp);
    $fct_hour = strftime("%H", $fct_clienttimestamp);
    $fct_minute = strftime("%M", $fct_clienttimestamp);
    $fct_second = strftime("%S", $fct_clienttimestamp);
    $fct_am_pm = strftime("%p", $fct_clienttimestamp);
    $date = $fct_year."-".$fct_month."-".$fct_day." ".$fct_hour.":".$fct_minute.":".$fct_second;
    return $date;    
  } 

function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 70)
{
    // echo $sourceImage;
    // Obtain image from given source file.
    if (!$image = @imagecreatefromjpeg($sourceImage))
    {
        return false;
    }

    // Get dimensions of source image.
    list($origWidth, $origHeight) = getimagesize($sourceImage);

    if ($maxWidth == 0)
    {
        $maxWidth  = $origWidth;
    }

    if ($maxHeight == 0)
    {
        $maxHeight = $origHeight;
    }

    // Calculate ratio of desired maximum sizes and original sizes.
    $widthRatio = $maxWidth / $origWidth;
    $heightRatio = $maxHeight / $origHeight;

    // Ratio used for calculating new image dimensions.
    $ratio = min($widthRatio, $heightRatio);

    // Calculate new image dimensions.
    $newWidth  = (int)$origWidth  * $ratio;
    $newHeight = (int)$origHeight * $ratio;

    // Create final image with new dimensions.
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
    imageinterlace($image, 1);
    imagejpeg($newImage, $targetImage, $quality);

    // Free up the memory.
    imagedestroy($image);
    imagedestroy($newImage);

    // return true;
}

function getCategories(mysqli $con){
    $row = array();
    $qry = "select * from categories";
    $res = $con->query($qry);
    while($rows = $res->fetch_assoc() ){
        array_push($row,$rows);
    }
    return $row;
}

function getCategory(mysqli $con,$id){
    $row = array();
    $qry = "select * from categories where cat_id = ".$id;    
    $res = $con->query($qry);      
    $row = $res->fetch_assoc();
    return $row['cat_name'];

}

function timeSelector(){
    $time = array();
    $hours = 1;
    $minutes = array("00" , "30");

    for($i=1; $i <= 48; $i++){
        $time[$i] = $hours.":".$minutes[0];
        if(count($time) % 2 ==0){            
            $time[$i] = $hours.":".$minutes[1];            
            $hours++;
        }


    }
    echo '<select style = "height :30px;">';
    foreach ($time as $key => $value) {
        echo '<option value = "'.$value.'">'.$value.'</option>';
    }
    echo "</select>";
}

function select(mysqli $con,$eve)
{
    $qry = "select e_id from event_details where title='$eve'";
    $res = $con->query($qry);
    $row = $res->fetch_row();
    return $row[0];
}
function selectTicket(mysqli $con,$eve)
{
    $qry = "select * from event_details inner join cities on cities.city_id = event_details.event_city_id where e_id=$eve";
    //and ticket_detail.e_id=$eve
    // echo $qry;
    $res = $con->query($qry);
    return $row = $res->fetch_assoc();
}
function getCity($id,mysqli $con){
    $qry = "select * from cities inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where cities.city_id = ".$id;

    $resCity = $con->query($qry);
    // echo $qry;
    if($resCity){
        $row = $resCity->fetch_assoc();
        return $row['city_name'].' - '.$row['state_name'];
    }
}
function selecte(mysqli $con,$id)
{

    $qry = "select * from event_details,company_profile where e_id=".$id;
    $res = $con->query($qry);
    return $row=$res->fetch_assoc();
}
function insertBookData(mysqli $con, $id,$post){
    $status=$post["status"];    
    $amount=$post["amount"];
    $txnid=$post["txnid"];
    $qty = $post['qty'];
    $tckInfo = $post['productinfo'];
    $uStatus = $post['unmappedstatus'];
    $addOn = $post['addedon'];
    $eventId = $_POST['eventid'];
    $qry = 'INSERT INTO `book_history`(`bk_transaction_id`, `bk_ticket_info`, `bk_user_id`, `bk_event_id`, `bk_price`, `bk_num_tickets`, `bk_status`, `bk_unmapped_status`, `bk_created_on`) VALUES ("'.$txnid.'","'.$tckInfo.'",'.$id.', '.$eventId.','.$amount.','.$qty.',"'.$status.'","'.$uStatus.'","'.$addOn.'")';
    $res=$con->query($qry);
    if($res){
        return $con->insert_id;
    }
}
function getClient($con,$eid){
    // $where = $email !== '' ? 'mail = "'.$email.'"' : 'user_id = '.$eid;
    // if($email !== ''){
    $qry = 'select * from user_profile where user_id = '.$eid;
    // echo $qry;
    $res = $con->query($qry);    
    $data = [];

    if($res){
        $count = $res->num_rows;
        
        if($count > 0){            
            $row = $res->fetch_assoc();
            $data['username'] = $row['username'] !== '' ? $row['username'] : $row['firstname'];        
            $data['mobile'] = $row['mobile'];                    
        }    
    }else{
        $data['username'] = $eid;
    }

    return $data;
}
function getUser($con,$email){
    // $where = $email !== '' ? 'mail = "'.$email.'"' : 'user_id = '.$eid;
    // if($email !== ''){
    $qry = 'select * from user_profile where mail = "'.$email.'"';   
    // echo $qry;
    $res = $con->query($qry);    
    $data = [];

    if($res){
        $count = $res->num_rows;
        
        if($count > 0){            
            $row = $res->fetch_assoc();
            $data['username'] = $row['username'] !== '' ? $row['username'] : $row['firstname'] != '' ? $row['firstname'] : $email;        
            $data['mobile'] = $row['mobile'];                    
        }    
    }else{
        $data['username'] = $email;
    }

    return $data;
}
function random_numbers($length) 
{
    $chars = "123456789";
    $value = substr( str_shuffle( $chars ), 0, $length );
    return $value;
    
}
function sendMessage($text,$mobile){
    $url = 'http://trans.smsfresh.co/api/sendmsg.php';

    $fields = array(
        'user' => 'magarsham', 
        'pass' => 'festivito5555', 
        'sender' => 'FESTVT' ,
        'phone' => $mobile, 
        'text' => $text, 
        'priority' => 'ndnd', 
        'stype' => 'normal'        
    );

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

    //execute post
    $res = curl_exec($ch);

    //close connection
    curl_close($ch);

    // var_dump($result);
    return $res;
}
function paymentStatus(mysqli $con,$post,$salt,$id){
    $status=$post["status"];
    $firstname=$post["firstname"];
    $amount=$post["amount"];
    $txnid=$post["txnid"];
    $posted_hash=$post["hash"];
    $key=$post["key"];
    $productinfo=$post["productinfo"];
    $email=$post["email"];
    $bookid = $post['bookid'];
    // $salt="gZ6HtB3YQy";

        if($status == 'failure' || $status == 'userCancelled'){
            $msg = $status == 'failure'? '<p>Your Order Status <b>'.$status.'</b></p><p>Booking ID: <b>'.$bookid.'</b></p>' : '<p>You Cancelled these transaction.</p>';
            $data = '<div class="col-md-12" id = "failureBox">'
                .'<div class="order-status">'
                    .$msg
                .'</div>'
                .'<div class="clear"></div>'
                .'<div class="col-md-12 col-md-offset-3">'                    
                    .'<form action = "Pay/" method = "post">'
                    .'<button  class="btn btn-warning">Please Try again ...!! </button>'
                    .'</form>'
                .'</div>'
            .'</div>'
            .'<div class="clear"></div>';                    
        }elseif ($status == 'success') {
             
            $data = '<div class="col-md-12">'
                        .'<div class="order-status">'                            
                            .'<p>Booking ID:  <b>'.$bookid.'</b></p>'
                            .'<p style="successP">We have Received your payment of <b> <i class="fa fa-inr" aria-hidden="true"></i> '.$amount.' </b></p>'
                        .'</div>'
                        .'<div class="bgnew">'
                            .'<div class="container">'
                                .'<div class="row">'
                                    .'<div   class="col-md-10  col-lg-10 col-lg-offset-1 col-md-offset-1 ">'
                                        .'<div  class="center">'
                                            .'<button type="button" class="btn btn-success btn-circle btn-lg m-b-20"><i class="glyphicon glyphicon-ok"></i></button>'
                                            .'<p >Thank you for using Festivito. Enjoy your show !!</p>'
                                        .'</div>'
                                    .'</div>'
                                .'</div>'
                            .'</div>'
                        .'</div>'
                    .'</div>';
            $row = selectTicket($con,$_POST['eventid']);
            
            $client = getClient($con,$row['user_id']);
            $user = getUser($con,$email);
             
            $userTxtMsg = 'Hi '.$user['username'].', Booking ID: FEST'.$bookid.'. You have successfully booked your '.$productinfo.' of '.ucwords($row['title']).' event at '.ucwords($row['city_name']).'. Transaction Rs. '.$amount.'. Enjoy to the fullest :D. Thanks for using FESTIVITO.. keep rocking B-).';
           
            $clientTxtMsg = 'Hi '.$client['username'].', You have recieved booking for '.ucwords($row['title']).', '.$productinfo.'. Booking ID: FEST'.$bookid.'. Amount Rs. '.$amount;                    
            // Message Sending

//            sendMessage($clientTxtMsg,$client['mobile']);
//            sendMessage($userTxtMsg,$user['mobile']);
            

            // Mail Sending
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

            $tic_details = '';

            $qry = "select * from ticket_details where tic_id in (".implode(',',$_SESSION['ticids']).")";
            
            $res = $con->query($qry);
            $i = 0;

            while($rowT = $res->fetch_assoc()){
                $tic_details .= '<div>'.$rowT['tic_name'].' X '.$_SESSION['ticqty'][$i].'</div>';
            }

            ob_start();
                include "requested/mail.php";
                $message = ob_get_contents();
            ob_end_clean();
            // echo $message;
            $to = $email;            
            $subject = "Festivito - Booking details of ".ucwords($row['title']);
            // echo $message;
            // sendMail($to,$message,$subject);
        }
                   
     return $data;
}

// function paymentStatus(mysqli $con,$post,$salt,$id){
//     $status=$post["status"];
//     $firstname=$post["firstname"];
//     $amount=$post["amount"];
//     $txnid=$post["txnid"];
//     $posted_hash=$post["hash"];
//     $key=$post["key"];
//     $productinfo=$post["productinfo"];
//     $email=$post["email"];
//     $bookid = $post['bookid'];
//     // $salt="gZ6HtB3YQy";

//     if(isset($post["additionalCharges"])) {
//         $additionalCharges=$post["additionalCharges"];
//         $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;            
//     }else {    
//         $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
//     }
//     $hash = hash("sha512", $retHashSeq);
//     $data = '';  
//     if ($hash != $posted_hash) {
//         $data = "Invalid Transaction. Please try again";
//     }else {
        
//         if($status == 'failure'){
//             $data = '<div class="col-md-12" id = "failureBox">'
//                 .'<div class="order-status">'
//                     .'<p>Your Order Status <b>'.$status.'</b></p>'
//                     .'<p>Booking ID: <b>'.$bookid.'</b></p>'
//                 .'</div>'
//                 .'<div class="clear"></div>'
//                 .'<div class="col-md-12 col-md-offset-3">'
//                     // .'<input type="" value="Reset" onClick="window.location.reload()">'
//                     .'<form action = "Pay/" method = "post">'
//                     .'<button  class="btn btn-warning">Please Try again ...!! </button>'
//                     .'</form>'
//                 .'</div>'
//             .'</div>'
//             .'<div class="clear"></div>';                    
//         }elseif ($status == 'success') {
             
//             $data = '<div class="col-md-12">'
//                         .'<div class="order-status">'                            
//                             .'<p>Booking ID:  <b>'.$bookid.'</b></p>'
//                             .'<p style="successP">We have Received your payment of <b> <i class="fa fa-inr" aria-hidden="true"></i> '.$amount.' </b></p>'
//                         .'</div>'
//                         .'<div class="bgnew">'
//                             .'<div class="container">'
//                                 .'<div class="row">'
//                                     .'<div   class="col-md-10  col-lg-10 col-lg-offset-1 col-md-offset-1 ">'
//                                         .'<div  class="center">'
//                                             .'<button type="button" class="btn btn-success btn-circle btn-lg m-b-20"><i class="glyphicon glyphicon-ok"></i></button>'
//                                             .'<p >Thank you for using Festivito. Enjoy your show !!</p>'
//                                         .'</div>'
//                                     .'</div>'
//                                 .'</div>'
//                             .'</div>'
//                         .'</div>'
//                     .'</div>';
//             $row = selectTicket($con,$_POST['eventid']);
            
//             $client = getClient($con,$row['user_id']);
//             $user = getUser($con,$email);
             
//             $userTxtMsg = 'Hi '.$user['username'].', Booking ID: FEST'.$bookid.'. You have successfully booked your '.$productinfo.' of '.ucwords($row['title']).' event at '.ucwords($row['city_name']).'. Transaction Rs. '.$amount.'. Enjoy to the fullest :D. Thanks for using FESTIVITO.. keep rocking B-).';
           
//             $clientTxtMsg = 'Hi '.$client['username'].', You have recieved booking for '.ucwords($row['title']).', '.$productinfo.'. Booking ID: FEST'.$bookid.'. Amount Rs. '.$amount;                    
//             // Message Sending

// //            sendMessage($clientTxtMsg,$client['mobile']);
// //            sendMessage($userTxtMsg,$user['mobile']);
            

//             // Mail Sending
//             $whitelist = array(
//                 '127.0.0.1',
//                 '::1'
//             );
//             $base = '';


//             if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {                
//                 $base = "/";
//             }else{      
//                 $base = 'http://www.festivito.com/';
//             }

//             $tic_details = '';

//             $qry = "select * from ticket_details where tic_id in (".implode(',',$_SESSION['ticids']).")";
            
//             $res = $con->query($qry);
//             $i = 0;

//             while($rowT = $res->fetch_assoc()){
//                 $tic_details .= '<div>'.$rowT['tic_name'].' X '.$_SESSION['ticqty'][$i].'</div>';
//             }

//             ob_start();
//                 include "requested/mail.php";
//                 $message = ob_get_contents();
//             ob_end_clean();
//             // echo $message;
//             $to = $email;            
//             $subject = "Festivito - Booking details of ".ucwords($row['title']);
//             // echo $message;
//             sendMail($to,$message,$subject);
//         }        
               
//     }   
//      return $data;
// }

function sendMail($email,$message,$subject){
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    $headers .= "From: no-reply@festivito.com" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // echo $email.$message.$subject.$headers;
    if(mail($email,$subject,$message,$headers)) {
        return true;
    }
    return false;
}


function getTitle(mysqli $con,$eid){

  $qry = "select distinct(title),book_history.bk_event_id from book_history inner join event_details on event_details.e_id = book_history.bk_event_id inner join user_profile on user_profile.user_id = book_history.bk_user_id where bk_user_id = ".$eid;
  $res = $con->query($qry);
  while ($row = $res->fetch_assoc()) {
      echo '<option value = "'.$row['bk_event_id'].'" >'.$row['title'].'</option>';
  }
}

function SEO(mysqli $con,$file,$eve){
    $data = array();
    $cities = array();    
    $category = array();
    // Get all Cities 
    $qry = "select DISTINCT city_name, city_id from cities inner join event_details on city_id = event_city_id";
    $res=$con->query($qry);
    while($row = $res->fetch_assoc())
    {      
        array_push($cities,"Events in ".$row['city_name']);
    }        

    foreach (getCategories($con) as $key => $value) {        
        array_push($category, getCategories($con)[$key]['cat_name']);           
    }    

    // Creating Results
    if($file == 'index'){
        $data['title'] = 'Festivito | Home - Book your Favourite Events happening allover India.';
        $data['keywords'] = "Festivito ,Festivito.com , Event Booking , ".implode(', ',$cities).", Current Events, ".implode(", ", $category);
        $data['description'] = "We Provide best Deals for Event Booking across India";
    }else if($file == 'book'){
        $rw = selectTicket($con,$eve);
        $city = explode(' - ',getCity($rw['event_city_id'],$con));
        // $pos=strpos($rw['description'], ' ', 160);
        $description = substr(strip_tags($rw['description']),0,150); 
        $data['title'] = $rw['title']. ' | Festivito | '.$city[0];
        $data['keywords'] = 'Festivito , '.$rw['title']. ", ".getCategory($con,$rw['category']).', '.$rw['title'].'in '.$city[0].' Events in India, Event, Upcoming Events, Events, Event Ticket Booking Website, Event Ticket Booking Online, Event today, Events today, Today events, Event ticket booking online, Event Ticket Booking, Event ticket booking sites, Concerts, Event Happening, Online Ticket for Events, Events Booking Online, live shows ticket booking, Upcoming Events India, Online Events Booking, Buy concert tickets, Tickets for concerts, Tickets for events';
        $data['description'] = $description;
    }else{
        $data['title'] = "";
        $data['keywords'] = "";
        $data['description'] = "";
    }

    return $data;
}

?>