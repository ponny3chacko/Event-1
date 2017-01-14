<?php include 'header.php';
  $qry = "select * from event_details where status = 1 limit 0,6";    
  $res = $con->query($qry);  
?>
<div class="content">
  <div class="organize-main" >

    <div class="organize-sidebar2" style="width:100%;">
      <h1>PAST EVENT</h1>
      <table class="table table-hover">
        <tbody>
          <tr>
            <th>Event Id</th>
            <th>Event Title</th>
            <th>City</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          <?php           
          if($res)
          {
            while($row = $res->fetch_row())
            {          
              echo "<tr>"
                ."<td>92265</td>"
                ."<td>VCBGFDGG</td>"
                ."<td>Pune</td>"
                ."<td><span class=\"label label-primary\">UnPublished</span></td>"
                ."<td><a href=\"Edit/$row[0]\"><span class=\"label label-primary2\">Edit Event</span></a></td>"
              ."</tr>";
            } 
         }
         else
         {
        ?>
          <tr>
            <td colspan="5">
              <div class="isa_error">No events found, <a href="AddEvent/">Click here</a> to create event.</div>
            </td>
          </tr>
        <?php
          }
        ?>
        </tbody>
      </table>
    </div>
  <div class="clearfix"> </div>
</div>
  </div>
<?php include 'footer.php';?>
