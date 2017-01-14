<?php include 'header.php';
  
  $qry = "select * from event_details inner join cities on cities.city_id = event_details.event_city_id inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where user_id = ".$_SESSION['id'];  
  // echo $qry;
  $res = $con->query($qry);  
  $count = $res->num_rows;


                       
?>

<div class="content">
  <div class="organize-main">    
    <div class="organize-sidebar2" style="width:100%;">
      <h1>All EVENTS</h1>






      <table class="table table-hover">
        <tbody>
          <tr>
            <th>Event Id</th>
            <th>Event Title</th>
            <th>City</th>            
            <th>Created on</th>            
            <th>Action</th>
            <th>Status</th>
          </tr>
          <?php
            if($res)
            {
              echo '<input type="hidden" id = "count" value="'.$count.'">';
              $co = 0;
              $chk = "";
              while ($row = $res->fetch_assoc()) 
              {   
                if($row['status'] == 0) 
                {
                  $chk = "checked";
                  // echo $chk;
                }
                else
                {
                  $chk = "";
                }
                $dt = date("jS M, Y",strtotime($row['start_date']));
                $url = $row['title'] != '' ? slug($row['title'],'-'). '/'.$row['e_id'] : $row['e_id'];
                echo "<tr>"
                  ."<td style=\"width:10%;\">".$row['e_id']."</td>"
                  ."<td>".$row['title']."</td>"
                  ."<td>".$row['city_name']."</td>"
                  ."<td style=\"width:14%;\">".$dt."</td>"
                  ."<td style=\"width:8%;\"><a href=\"Edit/".$url."/\"><span class=\"label label-primary2\">Edit Event</a></td>"
                  ."<td style=\"width:10%;padding-top:1%\"><input type=\"checkbox\" id=\"on-off-switch".$co."\" name=\"".$row['e_id']."\" $chk></td>"
                  ."</tr>";
                $co++;
              }
            }
            else 
            {            
          ?>          
          <tr>
            <td colspan="6">
              <div class="isa_error">No events found, <a href="AddEvent/">Click here</a> to create event.</div>
            </td>
          </tr>
          <?php 
            }
          ?>
        </tbody>
      </table>
      <script type="text/javascript">
          
      </script>
    </div>    
    <div class="clearfix"> </div> 
  </div>
  <div class="clearfix"> </div> 
</div>

<?php
$script = '<script type="text/javascript" src="js/on-off-switch.min.js"></script>'
    .'<script type="text/javascript" src="js/organiser.js"></script>';

 include 'footer.php';
 ?>