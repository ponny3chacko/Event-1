<?php include'header.php';
	$qry = "select * from user_profile";
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
              <h3 class="box-title">Data Table With Full Features</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>ADDRESS</th>
                    <th>CITY</th>
                    <th>MOBILE NO.</th>                    
                    <th>ACTION</th>                    
                  </tr>
                </thead>
                <tbody>
                	<?php
            				              		          		          
		              while ($row = $res->fetch_row()) 
		              {   		                		                
		                echo "<tr>"
		                  ."<td>$row[0]</td>"
		                  ."<td>$row[5]</td>"
		                  ."<td>$row[7]</td>"
		                  ."<td>$row[10]</td>"
                      ."<td>$row[12]</td>"
		                  ."<td><a href=\"orgdetail.php?id=$row[0]&v=y\" class=\"btn btn-block btn-danger btn-sm\">Details</a></td>"		                  
		                  ."</tr>";
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