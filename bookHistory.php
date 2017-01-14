<?php include 'header.php'; ?>
<div class="content">
    <div class="booked">
    <?php 
        $qry = "select * from book_history inner join event_details on event_details.e_id = book_history.bk_event_id where bk_user_id = ".$_SESSION['id'];
        $res = $con->query($qry);
        $count = $res->num_rows;
        $tid = '';
        if($count > 0){
            while($row = $res->fetch_assoc()){
                // if($row['userCancelled'])
            ?>            
                <div class="ticket1">
                <div class="ticket-borderTop"> </div>
                <div class="ticket-div-content">
                    <div class="ticket-cont_main">
                        <div class="ticket-eventCatName">
                            <h2 id="ticketName0"><?php echo $row['title'];?> </h2>
                            <p class="ticket-tckdesc">
                                <i class="fa fa-map-signs" aria-hidden="true"></i> 
                                <?php echo $row['address'];?> 
                                </p>
                            <p class="ticket-lastdate">
                                <i> Event on : <?php echo date("jS M Y",strtotime($row['start_date']));?> at  <?php echo date("h:m A",strtotime($row['start_date']));?></i>
                            </p>
                            <p class="ticket-lastdate">
                                <i> Booked on : <?php echo date("jS M Y",strtotime($row['bk_created_on']));?>  at  <?php echo date("h:m A",strtotime($row['bk_created_on'])); ?></i>
                            </p>
                        </div>
                        <div class="ticket-eventCatValue" style="">
                            <span><input type="hidden" id="price0" value="250">Total Price - ₹ <?php echo $row['bk_price'];?></span>
                            <hr>
                            <span style="color: #000; font-size:15px;"><input type="hidden" id="price0" value="250">Transaction ID - <?php echo $row['bk_transaction_id'];?></span>
                        </div>
                        <div class="ticket-eventCatSelect">
                           <div class="ticketnumbr">No of Tickets - <?php echo $row['bk_num_tickets'];?> </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="ticket-borderBottom"></div>
            </div>
            <div class="clear"></div>
            <?php
            }
        }else{
            echo '<h5>No Booked Tickets Found</h5>';
        }
    ?>
    


        <div class="ticket2">
            <div class="ticket-borderTop"> </div>
            <div class="ticket-div-content">
                <div class="ticket-cont_main">
                    <div class="ticket-eventCatName">
                        <h2 id="ticketName0">The Grand Auto & Real Estate Expo, Kapse Lawns </h2>
                        <p class="ticket-tckdesc">
                            <i class="fa fa-map-signs" aria-hidden="true"></i>  Chinchwad Nagarpalika Ground,
                            Behind PCMC,                                        </p>
                        <p class="ticket-lastdate">
                            <i> Date: 09-05-2016 | Time : 10-30am to 5pm</i>
                        </p>
                    </div>
                    <div class="ticket-eventCatValue" style="">
                        <span><input type="hidden" id="price0" value="250">Ticket Price - ₹ 250</span>
                        <hr>
                        <span style="color: #000; font-size:15px;"><input type="hidden" id="price0" value="250">Transaction ID - fdfjkfk75478</span>
                    </div>
                    <div class="ticket-eventCatSelect">
                        <div class="ticketnumbr">No of Tickets - 5 </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="ticket-borderBottom"></div>
        </div>

        <div class="clear"></div>
        <div class="ticket3">
            <div class="ticket-borderTop"> </div>
            <div class="ticket-div-content">
                <div class="ticket-cont_main">
                    <div class="ticket-eventCatName">
                        <h2 id="ticketName0">The Grand Auto & Real Estate Expo, Kapse Lawns </h2>
                        <p class="ticket-tckdesc">
                            <i class="fa fa-map-signs" aria-hidden="true"></i>  Chinchwad Nagarpalika Ground,
                            Behind PCMC,                                        </p>
                        <p class="ticket-lastdate">
                            <i> Date: 09-05-2016 | Time : 10-30am to 5pm</i>
                        </p>
                    </div>
                    <div class="ticket-eventCatValue" style="">
                        <span><input type="hidden" id="price0" value="250">Ticket Price - ₹ 250</span>
                        <hr>
                        <span style="color: #000; font-size:15px;"><input type="hidden" id="price0" value="250">Transaction ID - fdfjkfk75478</span>
                    </div>
                    <div class="ticket-eventCatSelect">
                        <div class="ticketnumbr">No of Tickets - 5 </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="ticket-borderBottom"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include 'footer.php';?>        