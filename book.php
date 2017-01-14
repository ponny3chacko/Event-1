<?php include 'header.php';
$count = 1;
$id = "";
$id = isset($_GET["event"]) ? $_GET["event"] : $_POST["eventid"];
$_SESSION['eventid'] = $id;
$row = selecte($con,$id);

?>
<div class="content" style="background:#;">
    <div class="slider3">
        <div class="">
            <div  class="" >
            <?php 
                echo '<img src="'.$row["banner_img"].'" alt="'.$row['title'].'"/>';
            ?>
            </div>
        </div>
    </div>
    <div class="descri">
        <h1>About Event Description</h1>
        <div class="inside-decri style-4" style="color: #000;"><?php echo $row['description'];?></div>
    </div>
    <div class="clearfix"></div>
    <div class="book-new ">
    <hr>
    <div class="eventtitle"><h4><?php echo $row['title']; ?></h4></div>

    <div class="event-list1 loaded">
        <div id="tabs" class="tabs">        
        <div class="content" style="background:#fff;">
            
            <h3 class="event-h3">Available Tickets</h3>  
            <?php
                $ttl=0;
                $qry = "select * from ticket_details where tic_e_id = ".$id;
                $res = $con->query($qry);
                $num = $res->num_rows;
                if($num == 0) {
                    echo 'No Tickets Found';
                }
                $co = 0;            
                while($trow=$res->fetch_assoc())
                {
            ?>
                <div class="ticket1" id="borderimg2">
                    <div class="ticket-borderTop"></div>
                    <div class="ticket-div-content">
                        <div class="ticket-cont_main row">
                            <div class="ticket-eventCatName col-xl-8">
                                <h2 id = "ticketName<?php echo $co;?>"><?php echo $trow['tic_name'];?> Tickets  </h2>
                                <p class="ticket-tckdesc">
                                <?php echo $trow['tic_description'];?>
                                </p>
                                <p class="ticket-lastdate">
                                    <i>Last Date: <?php $ldt = date("d-m-Y",strtotime($trow['tic_last_date']));echo $ldt;?></i>
                                </p>
                            </div>


                            <div class="ticket-price col-sm-2" >
                                <p class = "priceTag"><input type = "hidden" id = "price<?php echo $co;?>" value = "<?php echo $trow['tic_price'];?>">&#x20b9; <?php echo $trow['tic_price'];?></p>
                            </div>
                            <div class="ticket-number col-sm-2">
                            <?php
                            $ticSD = new DateTime(date("Y-m-d",strtotime($trow['tic_start_date'])));
                            $ticED = new DateTime(date("Y-m-d",strtotime($trow['tic_last_date'])));

                            $today = new DateTime(date("Y-m-d"));
                            $intervalS = $ticSD->diff($today);
                            $intervalE = $ticED->diff($today);
                            $dayS = $intervalS->format('%R%a');
                            $dayE = $intervalE->format('%R%a');
                           
                            if($dayS < +0){
                                ?>
                                <img class="available" src="images/available.png">
                                <input type="hidden" name="" id="quantity<?php echo $co;?>" value = "0"> 
                                <?php
                            }else if($dayE >= 1){
                                ?>
                                <img class="sold" src="images/sold.jpg">
                                <input type="hidden" name="" id="quantity<?php echo $co;?>" value = "0"> 
                                <?php
                            }else{
                            ?>
                                <select class="sel" id="quantity<?php echo $co;?>" onchange="lo('<?php echo $trow['tic_id']; ?>');">
                            <?php
                                $i=0;
                                while($i<=$trow['tic_max']){
                                    echo "<option value='$i'>$i</option>";
                                    $i++;
                                }?>
                                </select>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="ticket-borderBottom"></div>
                </div>
                <div class="clear"></div>
                <?php
                    echo '<input type="hidden" id ="total'.$co.'" value = "'.$trow['tic_price'].'">';
                        $co += 1;
                    }
                    echo '<input type = "hidden" id = "count" value = "'.$co.'">';
                    $qr = "select count(*) from ticket_details where tic_id = ".$id;
                    $re = $con->query($qr);
                    $r = $re->fetch_row();
                    echo '<input type="hidden" id ="no" value = "'.$r[0].'">';
                ?>
                <div class="clear"></div>
                <form action="Pay/" method="post">
                    <div class="purchase">
                        <div class="purchase1">
                            <b>Purchase Total - </b> <p name="ttl" id="show"></p>
                            <div class="clear"></div>
                            <input type="hidden" name = "event" value = "<?php echo $row["e_id"];?>">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>                    
                    <div class="ticket-book">
                        <input type = "submit" class="btn btn-primary" id = "bookBtn" value="BOOK NOW" name="Submit" disabled />
                    </div>
                </form>
            
                <div class="etdet">
                    <?php if($row["e_terms"] !== Null){
                    ?>
                    <h3 class="event-h3">Terms &amp; Conditions</h3>  

                    <div class="fl_100">
                        <ol class="ol termsol">
                        <?php
                            $terms = explode(".",$row["e_terms"]);
                            foreach ($terms as $key => $value) {                                
                                echo '<li>'.$value.'</li>';
                            }
                        // echo $row["e_terms"];
                        ?>                           
                        </ol>
                    </div>
                    <?php } ?>
                </div>            
        </div><!-- /content -->
    </div>
</div>
<div class="advertise2">
    <div class="RightHeading">Event Details / ID : <?php echo $row["e_id"];?> </div>
        <div id="RightSectionInfo">
            <i class="fa fa-calendar" aria-hidden="true"></i>     
            <p class="CalenderIcon">
            <?php
                // $dt = explode(" ",$row["start_date"]);
                $d = date('D - M j, Y', strtotime($row["start_date"]));

                // $edt = explode(" ",$row["end_date"]);
                // echo $edt[0];
                $ed = date('D - M j, Y', strtotime($row["end_date"]));
                echo $d .' to '. $ed;
            ?>
            </p>
        </div>
        <div class="clear"></div>
        <div id="RightSectionInfo">
            <i class="fa fa-clock-o" aria-hidden="true"></i>  
            <p class="TimeIcon">
            <?php
                
                $d = date('h:m', strtotime($row["start_date"]));
                $ed = date('h:m', strtotime($row["end_date"]));
                echo $d.' - '.$ed;
            ?>
            </p>
        </div>
        <div class="clear"></div>
        <div id="RightSectionInfo">
            <i class="fa fa-globe" aria-hidden="true"></i>  
            <p class="AddressIcon">
            <?php
                $row["address"] .= ",".getCity($row["event_city_id"],$con);
                $string = str_replace(",",",",$row["address"]);
                echo nl2br($string);
            ?>
            </p>
        </div>            
        <div class="clear"></div>
        <div class="RightHeading">Contact Details</div>
        <div id="RightSectionInfo">
            <i class="fa fa-envelope-o" aria-hidden="true"></i> <p class="SupportIcon"> <?php echo $row["c_email"];?></p>
        </div>
        <div class="clear"></div>
        <div id="RightSectionInfo">
            <p class="HostIcon">
                <a onclick="showcontacthost();" style="cursor:pointer">Contact the host</a>
            </p>
        </div>
        <div class="clear"></div>
        <div id="RightSectionInfo">
            <i class="fa fa-eye" aria-hidden="true"></i>  
            <p class="RightLink">
                <b >Views:</b>
                <?php
                    $count +=  $row["counts"];
                    $qry = "update event_details set counts = ".$count." where e_id = ".$id;
                    $con->query($qry);
                    echo $row["counts"] == 0 || $row["count"] == Null ? $count : $row["counts"];                    
                ?>
            </p>
        </div>
        <div class="clear"></div>
        <div class="RightHeading">Social Share</div>
        <div id="RightSectionInfo">
            <a href="<?php echo $row['e_fb_link']; ?>" title = "Like these Event at Facebook" ><i class="fa fa-facebook"></i></a>
            <a href="<?php echo $row['e_twitter_link']; ?>" title = "Follow these Event at Twitter" ><i class="fa fa-twitter"></i></a>                        
        </div>        
    </div>    
  <div class="clear"></div>                
  </div>  
<div class="clear"></div>                
</div>  
<?php include'footer.php';?>