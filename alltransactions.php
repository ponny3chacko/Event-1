<?php include'header.php';?>
<div class="clearfix"> </div>  
<div class="Edit-event2">
  <div class="admin-main">
    <h1>All Transactions</h1>
    
    <div class="transaction-main" >
      <form action ="data.php" method="post">

      <div class="empty2">
        <div class="col-md-3">
          <select class="form-control login-btn-new" id="eventTitleT" name="emp_type" onchange="getVal()">
          <option value="">Select Event Title</option>
          <?php
            getTitle($con, $_SESSION['id']);
          ?>                                            
          </select>
        </div>
        <div class="col-md-3">
          <input class="form-control login-btn-new" type="date" name="sdate" id="bookDate" placeholder="Start Date" onchange="getVal()"/>
        </div>      
        <div class="col-md-2">  
          <input type="submit" value="Generate PDF"  class="btn btn-default btn-flat  login-btn-new" name="submit">
        </div>
        <div class="clear"></div>
      </div>
        <div class="clear"></div>

      </form>
      <div class="clear"></div>

    </div><!-- /.box-header -->
    <div class="clear"></div>
    <div class="organize-sidebar2" style="width:100%;">

    <table id = "myTable" class="table table-hover">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Booked By</th>
          <th>Transaction ID</th>
          <th>Date</th>
          <th>Event Name</th>
          <th>Number of tickets</th>
          <th>Amount</th>          
        </tr>
      </thead>
        <tbody id="show">
          <?php
            $co = 1;
            $qry = "select * from book_history inner join event_details on event_details.e_id = book_history.bk_event_id inner join user_profile on user_profile.user_id = book_history.bk_user_id where bk_user_id = ".$_SESSION['id'];
            $res = $con->query($qry);
            $count = $res->num_rows;

            if($count > 0){
              while($row = $res->fetch_assoc()){
              ?>
                <tr>
                  <td><?php echo $co;?></td>
                  <td><?php echo $row['username'];?></td>
                  <td><?php echo $row['bk_transaction_id'];?></td>
                  <td><?php echo date("jS M Y",strtotime($row['bk_created_on']));?>  at  <?php echo date("h:m A",strtotime($row['bk_created_on'])); ?></td>
                  <td><?php echo $row['title'];?></td>
                  <td><?php echo $row['bk_num_tickets'];?></td>
                  <td><?php echo $row['bk_price'];?></td>
                </tr>
              <?php
              $co++;
              }
            }else{
          ?>
          <tr>
            <td colspan="7">
              <div class="isa_error">Sorry, No records found.</div>
            </td>
          </tr>
          <?php } ?>        
      </tbody>
    </table>
        <div class="clear"></div>
      </div>
  </div>
    <div class="clear"></div>
</div>
<?php include'footer.php';?>                 


