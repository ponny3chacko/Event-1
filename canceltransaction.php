<?php include'header.php';?>
<div class="clearfix"> </div>  
<div class="Edit-event2">
  <div class="admin-main">
    <h1>All Cancelled Transactions</h1>
    <div class="organize-sidebar2" style="width:100%;">
    <table class="table table-hover">
      <tbody>
        <tr>
          <th>S.No</th>
          <th>Booked By</th>
          <th>Transaction ID</th>
          <th>Date</th>
          <th>Event Name</th>
          <th>Number of tickets</th>
          <th>Amount</th>          
        </tr>
        <tr>
          <?php
          $co = 1;
            $qry = "select * from book_history inner join event_details on event_details.e_id = book_history.bk_event_id inner join user_profile on user_profile.user_id = book_history.bk_user_id where bk_user_id = ".$_SESSION['id']." and book_history.bk_unmapped_status = 'userCancelled'";
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
          <td colspan="7">
            <div class="isa_error">Sorry, No records found.</div>
          </td>
          <?php } ?>
        </tr>
      </tbody>
    </table>
      <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
  </div>
  <div class="clearfix"> </div>
</div>
<?php include'footer.php';?>                 


