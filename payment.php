<?php  
  include_once 'easebuzz/easepay-lib.php';
  include 'header.php';

  $url = in_array($_SERVER['REMOTE_ADDR'], $whitelist) ? 'http://event/' : 'http://www.festivito.com/';
    
  $SALT = "GX8VBY9WGF"; 
  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';
  if(isset($_POST["status"])){
    $result = response( $_POST, $SALT );
    $_POST["qty"] = $_SESSION["qty"];
    $_POST["eventid"] = $_SESSION["eventid"];
    $_POST['bookid'] = insertBookData($con,$_SESSION['id'],$_POST);    
    $out = paymentStatus($con,$_POST,$SALT,$_SESSION['id']);
  }
  $id = isset($_SESSION["eventid"])? $_SESSION["eventid"] : $_POST["event"];  
  $_SESSION["eventid"] = $id;  
  $row = selectTicket($con,$id);

  if(isset($_SESSION["price"])){
    $pay = $_SESSION["price"];  
    $_SESSION["pay"] = $pay;
    $qty = $_SESSION["qty"];    
    $details = implode(",",$_SESSION["details"]);    
  }else{
    $pay = $_SESSION["pay"];
    $qty = $_SESSION["qty"];
    $details = $_SESSION["details"];
  }
?>

<div class="content">        
  <div class="pay-new"> 
    <div class="order-summry">
      <h2>Order Summary</h2>      
      <div class="row1">
        <div class="order"><i class="fa fa-calendar" aria-hidden="true"></i> Event</div>
        <b><?php echo $row["title"];?></b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-location-arrow" aria-hidden="true"></i> Venue</div>                    
        <b><?php echo $row["address"];?></b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Location</div>                
        <b><?php echo getCity($row["event_city_id"],$con);?></b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-calendar-o" aria-hidden="true"></i> Date</div>
        <b><?php 
        // $dt = explode(" ",$row["start_date"]);
            echo $d = date('M d, Y', strtotime($row["start_date"])) .' to '. date('M d, Y',strtotime($row["end_date"]));
            
            ?>            
        </b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-clock-o" aria-hidden="true"></i> Time</div>
        <b>
          <?php 
            echo $time = date('h:i A',strtotime($row["start_date"])) .' to '.date('h:i A',strtotime($row["end_date"]));
          ?>          
        </b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-wheelchair" aria-hidden="true"></i> Seat Info</div>
        <b><?php echo $details; ?></b>
      </div>
      <div class="clearfix"></div>
      <div class="row1">
        <div class="order"><i class="fa fa-list-ol" aria-hidden="true"></i> Quantity</div>
        <b><?php echo $qty;?></b>
      </div>
      <div class="clearfix"></div>
        <div class="Gtotal">
          Total : &nbsp;<?php echo $pay;?>
        </div>
      </div>        
      <div class="verify">
        <h2>Payment Details</h2>
        <div class="empty"></div>  
        <?php
          if(isset($_POST["status"]) ? $_POST['status'] !== 'try' : ''){
            echo $out;
          }else{
        ?>      
          <form action="easebuzz/pay.php" method="post">            
            <input type="hidden" name="amount" value="<?php echo (empty($posted['amount'])) ? $_SESSION["price"] : $posted['amount'] ?>" />
            <input type="hidden" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? isset($_SESSION['id']) ? $_SESSION["user"] : '' : $posted['firstname']; ?>" />
            <input type="hidden" name="productinfo" value = "<?php echo (empty($posted['productinfo'])) ? implode(",",$_SESSION['details']) : $details ; ?>" >
            <input type="hidden" name="surl" value="<?php echo (empty($posted['surl'])) ? $url.'Pay/' : $posted['surl'] ?>"  />
            <input type="hidden" name="furl" value="<?php echo (empty($posted['furl'])) ? $url.'Pay/' : $posted['furl'] ?>"  />
            <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
            <div class="col-md-10">
              <input class="login-btn-new" id = "payEmail" placeholder="Enter Your E-mail ID" name="email" id="email" value="<?php echo (empty($posted['email'])) ? isset($_SESSION['id']) ? $_SESSION['email'] : '' : $posted['email']; ?>" required>
              <div id = "payErrMail" class="loginError"></div>
            </div>
            <div class="col-md-10">
              <input class="login-btn-new" id = "payMobile" required="Required" name="phone" type="text" placeholder="Enter Your Mobile Number" value="<?php echo (empty($posted['phone'])) ? isset($_SESSION['id']) ? $_SESSION['mobile'] : '' : $posted['phone']; ?>" maxlength= "10">
              <div id = "payErrMobile" class="loginError"></div>
            </div>
            <div class="clear"></div>
            <div class="checkpay">
              <input type="checkbox" name="signupchk" id="payTerms" checked>
              <span>
                <a href="TermsConditions/" title="Terms of Services">By checking up, you agree to our terms and conditions and privacy policy.</a>
              </span>
            </div>
            <div class="clearfix"></div>            
              <div class="btn-order">
                <input type="submit" value="Pay Now" id = "payBtn" class="btn acount-btn"/>
              </div>
            
          </form>  
          <?php } ?>      
          <!-- Related demos -->
          <div class="clear"></div>




      </div>
      <div class="clear"></div>                
      </div>  
    <div class="clear"></div>                
    </div>  
  <div class="clear"></div>                
  </div>  
<div class="clear"></div>                
</div>  
<?php include 'footer.php';?>

