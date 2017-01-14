<?php include'header.php';
  $qry = "select * from event_details inner join user_profile on user_profile.user_id = event_details.user_id inner join cities on cities.city_id = event_details.event_city_id inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id";  

  $res = $con->query($qry);  
  $count = $res->num_rows;
	
?>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">ALL EVENTS</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Event Id</th>
                    <th>Event Title</th>
                    <th>City</th>            
                    <th>Created on</th>            
                    <th>Event By</th>
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
                          ."<td><a href = '../Show/".$url."' title = 'Check event'>".$row['title']."</a></td>"
                          ."<td>".$row['city_name']."</td>"
                          ."<td style=\"width:14%;\">".$dt."</td>"
                          ."<td style=\"width:8%;\"><a href=\"../Edit/".$url."/pass/\"><span class=\"label label-primary2\">Edit Event</a></td>"
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
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->          
    </section><!-- /.content -->  	
<?php include'footer.php';?>
<script type="text/javascript">
  var count = $("#count").val();
  for(var i=0;i<=count;i++)
  {                 
    new DG.OnOffSwitch({                            
      el: '#on-off-switch'+i,
      textOn: 'Published',
      textOff: 'WithHold',
      listener:function(name, checked){ 
        $.ajax({
          url:"ajax/organiserview.php",
          data:{tog:checked,nm:name},
          type: "POST",
          cache:true,                
        });              
      }    
    });
  }      
</script>