<?php include 'header.php';
  $id = $_GET["event"];
  $ticket = Tickets($con,$id);  
  $row = selecte($con,$id);

  function update(mysqli $con)
  {   
    $e_id = $_POST["e_id"];    
    $s_date = $_POST["s_date"];        
    $e_date = $_POST["e_date"];           
    $add = $_POST["venue_add"];
    $cntry = $_POST["country"];
    $cty = $_POST["city"];
    $zip = $_POST["zip"];
                    
    // if(is_uploaded_file($_FILES["u_img"]['tmp_name']) && is_uploaded_file($_FILES["t_img"]['tmp_name']))
    // {
    //   $u_img = $_FILES["u_img"];
    //   $t_img = $_FILES["t_img"];
      
    //   $u_file_name = $_FILES['u_img']['name'];        
    //   $u_file_tmp =$_FILES['u_img']['tmp_name'];  

    //   $t_file_name = $_FILES['t_img']['name'];    
    //   $t_file_tmp =$_FILES['t_img']['tmp_name'];  

    //   $desired_dir="Event/images";

    //   if(is_dir("../".$desired_dir)==false)
    //   {
    //     mkdir("../$desired_dir", 0700);
    //     move_uploaded_file($u_file_tmp,"../$desired_dir/".$u_file_name);
    //     move_uploaded_file($t_file_tmp,"../$desired_dir/".$t_file_name);      
    //     $u_path = "images/".$u_file_name;
    //     $t_path = "images/".$t_file_name;      
    //   }
    //   else              
    //   {
    //     move_uploaded_file($u_file_tmp,"../$desired_dir/".$u_file_name);    
    //     move_uploaded_file($t_file_tmp,"../$desired_dir/".$t_file_name);
    //     $u_path = "images/".$u_file_name;
    //     $t_path = "images/".$t_file_name;      
    //   }
    // }
    // else
    // {
    //   $rowe = selectTicket($con,$id);
    //   $u_path = $rowe["banner_img"];
    //   $t_path = $rowe["thumb_img"];
    // }    
      
    $form_data = array(
      'e_id' => $con->real_escape_string($e_id),
      'title' => $con->real_escape_string($_POST["title"]),      
      'url' => $con->real_escape_string($_POST["url"]),
      'start_date' => $con->real_escape_string($s_date),
      'end_date' => $con->real_escape_string($e_date),            
      'description' => $con->real_escape_string($_POST["descrip"]),
      'category' => $con->real_escape_string($_POST["category"]),
      'sub_category' => $con->real_escape_string($_POST["sub_cat"]),
      'tags' => $con->real_escape_string($_POST["tags"]),
      // 'banner_img' => $con->real_escape_string($u_path),
      // 'thumb_img' => $con->real_escape_string($t_path),      
      'banner_img' => $con->real_escape_string($_POST["u_img"]),
      'thumb_img' => $con->real_escape_string($_POST["t_img"]),      
      'address' => $con->real_escape_string($add),
      'country' => $con->real_escape_string($cntry),        
      'city' => $con->real_escape_string($cty),
      'pincode' => $con->real_escape_string($zip)    
    );        
    dbRowUpdate($con,"event_details",$form_data,"WHERE e_id = $id");
  }
    
  if(isset($_POST["update"]))
  {

    echo update($con);
  }
?>    
        <!-- Main content -->
        <section class="content">
          <div class="row">            
            <div class="col-md-12"> 
            <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Horizontal Form</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>?event=<?php echo $id;?>" method ="post" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Event ID:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "e_id" value = "<?php echo $row["e_id"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Title:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "title" value = "<?php echo $row["title"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">URL:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "url" value = "<?php echo $row["url"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Start Date:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "s_date" value = "<?php echo $row["start_date"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">End Date:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "e_date" value = "<?php echo $row["end_date"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description:</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name = "descrip" style="height:300px;"><?php echo $row["description"];?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Category:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "category" value = "<?php echo $row["category"];?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Sub Category:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "sub_cat" value = "<?php echo $row["sub_category"];?>">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tags:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "tags" value = "<?php echo $row["tags"];?>">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Venue Address:</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name = "venue_add" style="height:300px;"><?php echo $row["address"];?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">City:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "city" value = "<?php echo $row["city"];?>">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">State:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "state" value = "<?php echo $row["state"];?>">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Country:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "country" value = "<?php echo $row["country"];?>">
                      </div>
                    </div>     
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Pin Code:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name = "zip" value = "<?php echo $row["pincode"];?>">
                      </div>
                    </div>                                   
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Banner:</label>
                      <div class="col-sm-10">
                        <img style="width:80%"; src="../<?php echo $row["banner_img"];?>">
                        <input type="hidden" value="<?php echo $row["banner_img"];?>" name = "u_img"/>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Thumbnail:</label>
                      <div class="col-sm-10">
                        <img style="width:80%"; src="../<?php echo $row["thumb_img"];?>">
                        <input type="hidden" value="<?php echo $row["thumb_img"];?>" name = "t_img"/>
                      </div>
                    </div>                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <a href = "list.php" class="btn btn-default">Back</a>
                    <input type="submit" class="btn btn-info pull-right" value="Update" name = "update">
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->              
            </div>
          </div>
        </section>
<?php include 'footer.php';?>                          