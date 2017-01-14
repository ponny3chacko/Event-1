<?php include 'header.php';
  $id = $_GET["id"];
  $qry = "select * from user_profile where user_id = ".$id;
  $res = $con->query($qry);
  $row = $res->fetch_assoc();


  function update(mysqli $con)
  {                             
    $id = $_POST["u_id"];
    $form_data = array(
      'user_id' => $con->real_escape_string($_POST["u_id"]),
      'name' => $con->real_escape_string($_POST["u_name"]),      
      'mail' => $con->real_escape_string($_POST["mail"]),
      'mobile' => $con->real_escape_string($_POST["mob"]),
      'address' => $con->real_escape_string($_POST["u_add"]),            
      'city' => $con->real_escape_string($_POST["city"]),
      'state' => $con->real_escape_string($_POST["state"]),
      'country' => $con->real_escape_string($_POST["country"]),
      'zip' => $con->real_escape_string($_POST["zip"])      
    );        
    dbRowUpdate($con,"user_profile",$form_data,"WHERE user_id = $id");
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
          <h3 class="box-title">Organiser Details</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo $id;?>" method ="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">User ID:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name = "u_id" value = "<?php echo $row["user_id"];?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Name:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name = "u_name" value = "<?php echo $row["name"];?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Email:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name = "mail" value = "<?php echo $row["mail"];?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Mobile No.:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name = "mob" value = "<?php echo $row["mobile"];?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Address:</label>
              <div class="col-sm-10">
                <textarea style="height:200px;" class="form-control" name = "u_add"><?php echo $row["address"];?></textarea>
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
                <input type="text" class="form-control" name = "zip" value = "<?php echo $row["zip"];?>">
              </div>
            </div>            
          </div><!-- /.box-body -->
          <div class="box-footer">
            <a href = "list.php" class="btn btn-default">Back</a>
            <input type="submit" class="btn btn-info pull-right" value="update" name="update">
          </div><!-- /.box-footer -->
        </form>
      </div><!-- /.box -->              
    </div>
  </div>
</section>
<?php include 'footer.php';?>                          