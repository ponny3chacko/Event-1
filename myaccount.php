<?php include 'header.php';
	$id = $_SESSION["id"]; 
	$qry = "select * from user_profile where user_id = ".$id;
	$res = $con->query($qry);
	
	if($res){
		$row = $res->fetch_assoc();		
		if($row['city'] !== Null){
			$qry = "select * from user_profile inner join cities on cities.city_id = user_profile.city inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where user_id=".$id;			
		}
	}

	$qryCom = "select * from company_profile inner join cities on cities.city_id = company_profile.c_city inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where c_user_id=".$id;
	$qryBank = "select * from bank_detail where b_user_id = ".$id;
	// echo $qryCom;
	$res = $con->query($qry);
	$row = $res->fetch_assoc();
	// print_r($row);
	$resCom = $con->query($qryCom);
	$rowCom = $resCom->fetch_assoc();

	$resBank = $con->query($qryBank);
	$rowBank = $resBank->fetch_assoc();

	function t_insert(mysqli $con)
  	{  
	  	$id = $_SESSION["id"];            
	  	if(isset($_FILES['img']))
		{
			$file_name = $_FILES['img']['name'];        
		    $file_tmp =$_FILES['img']['tmp_name'];  

		    $desired_dir="Event/images";          

		    if(is_dir("../".$desired_dir)==false)
		    {
		      	mkdir("../$desired_dir", 0700);
		      	move_uploaded_file($file_tmp,"../$desired_dir/".$file_name);      
		      	$path = "../$desired_dir/".$file_name;      
		    }
		    else              
		    {
		    	move_uploaded_file($file_tmp,"../$desired_dir/".$file_name);      
		      	$path = "../$desired_dir/".$file_name;      
		  	}
		}
	    $form_data = array(
		    'username'=>$_POST["unm"],
		    'mail'=>$_POST["mail"],
		    'saluation'=>$_POST["sal"],
		    'name'=>$_POST["fnm"]." ".$_POST["lnm"],
		    'designation'=>$_POST["deg"],
		    'address'=>$_POST["add"],
		    'country'=>$_POST["cnty"],
		    'state'=>$_POST["st"],
		    'city'=>$_POST["cty"],
		    'zip'=>$_POST["zip"],
		    'mobile'=>$_POST["mob"],
		    'img_path'=>$path
	        );
	            
	    dbRowUpdate($con,"user_profile",$form_data,"WHERE user_id = $id");
	}

  	if(isset($_POST["sub"]))
  	{
	  	t_insert($con);
  	}
?>
<div id = "updateLoader" class="LoadingBox">
			  <div class ="Loading">
			    <img src = "images/ripple.gif"  style = "width:50px;" />
			  </div>
			</div>
<div class="content">
	<div class="organize-main">
		<div class="organize-sidebar1">			
			<ul id = "list">
				<li id = "personal" class="active">PERSONAL DETAILS</li>
				<li id = "company">COMPANY DETAILS</li>
				<li id ="bank">BANK DETAILS</li>
				<li id ="change">CHANGE PASSWORD</li>
			</ul>
		</div>
		<div class="organize-sidebar2">

			<div id = "message" class="bg-success alertMsg"></div>
			<div class="personal-main" id = "personalSection">
			
				<h1>PERSONAL DETAILS</h1>
				<form id = "personalForm" method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
				<div class="col-md-6">
				<input type="text" name = "firstname" class="login-btn-new" placeholder="Firstname" aria-describedby="basic-addon1" value="<?php echo $row['firstname']; ?>">
				</div>
				<div class="col-md-6">
					<input type="text" name = "lastname" class="login-btn-new" placeholder="Lastname" aria-describedby="basic-addon1" value="<?php echo $row['lastname'];?>">
				</div>
				<div class="col-md-8">
					<div class="gender">
<!--						<div class="col-md-3">-->
<!--							<label>Gender :</label>-->
<!--							-->
<!--						</div>-->
						<div class="col-md-3 col-xs-5 col-xs-5">
							<input type="radio" name="gender" checked value="0"> <i class="fa fa-male"></i> Male
						</div>
						<div  class="col-md-3 col-xs-8 col-xs-6">
							<input type="radio" name="gender" value="1"> <i class="fa fa-female"></i> Female
						</div>
					</div>
					<input type="text" name = "email" class="login-btn-new" placeholder="Email" aria-describedby="basic-addon1" value = "<?php echo $row['mail']; ?>">
					<input type="text" name = "mobile" class="login-btn-new" placeholder="Mobile" aria-describedby="basic-addon1" value = "<?php echo $row['mobile']; ?>">
					<textarea class="comment-box2" name="address" placeholder="Enter Address"><?php echo $row['address']; ?></textarea>
				</div>
				<div class="col-md-4">
					<div class="profile-image">						
						<div class="profile-img" id = "imagePreview" style="background-image: url('<?php echo $row['img_path']; ?>');"></div>
						<input name="profile" class="upload" id="file-2" type="file" data-multiple-caption="{count} files selected" multiple="" accept="image/png, image/jpeg, image/jpg" style="display: none;">
						<p style="cursor: pointer;">
							<label for="file-2"  style="cursor: pointer;" class="fileUpload upload" id="labelPic">
								<i class="fa fa-upload" aria-hidden="true"></i> Upload Pro Pic 
							</label>
						</p>
					</div>
					<div>
						<input name = "username" type="text" class="login-btn-new" placeholder="Username" aria-describedby="basic-addon1" value = "<?php echo $row['username']; ?>">
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-8">
					<input type="hidden" name="city" id = "hiddenCity1" value="<?php echo $row['city_id'];?>">
					<input type="text" autocomplete="off" class="login-btn-new" id = "selectCity1" onclick="selectCities('1')" placeholder="Enter City" aria-describedby="basic-addon1" value="<?php echo $row['city_name']. ', '.$row['state_name'].' - '.$row['country_name'];?>">

					<div class="scrollbar2 style-4" style="display: none;" id = "showCity1">
						<div class="my-searchlist">
							<ul id = "listCities1">
								<div id="back_result1">

								</div>
							</ul>
							<div class="force-overflow"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div id = "addCity1" style="display: none;">
					<div class="col-md-4">
						<select class="form-control" id = "country1" onchange="statesData('1',this.value);">
							<option value="-1">--Country--</option>
							<?php	
								$rCo = $con->query("select * from countries");
								while($rowCo = $rCo->fetch_assoc())
								{
									echo '<option value = "'.$rowCo["country_id"].'">'.$rowCo["country_name"].'</option>';
								}
							?>
						</select>

					</div>
					<div class="col-md-3">
						<select class="form-control" disabled="disabled" onchange="cityName('1');" id="states1">
							<option value="-1">--State--</option>
						</select>
					</div>
					<div class="col-md-3">
						<input class="login-btn-new" type="text" name="cityname" id="cityname1" disabled="disabled" onkeyup="checkCity('1',this.value);">
					</div>
					<div class="col-md-2">
						<div class="add3" id = "addCityBtn1" style="display: none;" onclick="addCities('1');" ><i id = "btnIcon1" class="fa fa-plus-circle" aria-hidden="true"></i> Add</div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="col-md-8">
					<input name="zip" type="text" class="login-btn-new" placeholder="Enter Zip Code" aria-describedby="basic-addon1" value="<?php echo $row['zip'];?>">	
				</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<div class="admin-conlable2" >
							<button type="submit" class="btn button4"  name = "personalBtn">Update</button>
						</div>
						</div>
					<div class="clear"></div>

				</form>
			</div>

<div class="clear"></div>
<!--------------------------1 over-------------------------->

			<div class="personal-main" id = "companySection">
				<h1>COMPANY DETAILS</h1>
				<form id = "companyForm" method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
				<div class="col-md-8">
				<input type="text" name = "companyName" class="login-btn-new" placeholder="Company Name" aria-describedby="basic-addon1" value="<?php echo $rowCom['c_name']; ?>">
					<input type="text" name = "companyEmail" class="login-btn-new" placeholder="E-mail" aria-describedby="basic-addon1" value="<?php echo $rowCom['c_email']; ?>">
					<input type="text" name = "companyMobile" class="login-btn-new" placeholder="Mobile" aria-describedby="basic-addon1" value="<?php echo $rowCom['c_mobile']; ?>">					
					<input type="text" name = "companyWebsite" class="login-btn-new" placeholder="Company Website" aria-describedby="basic-addon1" value="<?php echo $rowCom['c_url']; ?>">

					<textarea class="comment-box2" name="companyAbout" placeholder="About Company" ><?php echo $rowCom['c_description']; ?></textarea>
					<textarea class="comment-box2" name="companyAddress" placeholder="Address"><?php echo $rowCom['c_address']; ?></textarea>
				</div>



				<div class="clear"></div>
				<div class="col-md-8">
					<input type="hidden" name="companyCity" id = "hiddenCity2" value="<?php echo $rowCom['city_id'];?>">
					<input type="text" autocomplete="off" class="login-btn-new" id = "selectCity2" onclick="selectCities('2')" placeholder="Enter City" aria-describedby="basic-addon1" value="<?php echo $rowCom['city_name']. ', '.$rowCom['state_name'].' - '.$rowCom['country_name'];?>">

					<div class="scrollbar2 style-4" style="display: none;" id = "showCity2">
						<div class="my-searchlist">
							<ul id = "listCities2">
								<div id="back_result2">

								</div>
							</ul>
							<div class="force-overflow"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div id = "addCity2" style="display: none;">
					<div class="col-md-4">
						<select class="form-control" id = "country2" onchange="statesData('2',this.value);">
							<option value="-1">--Country--</option>
							<?php	
								$rCo = $con->query("select * from countries");
								while($rowCo = $rCo->fetch_assoc())
								{
									echo '<option value = "'.$rowCo["country_id"].'">'.$rowCo["country_name"].'</option>';
								}
							?>
						</select>

					</div>
					<div class="col-md-3">
						<select class="form-control" disabled="disabled" onchange="cityName('2');" id="states2">
							<option value="-1">--State--</option>
						</select>
					</div>
					<div class="col-md-3">
						<input class="login-btn-new" type="text" name="cityname" id="cityname2" disabled="disabled" onkeyup="checkCity('2',this.value);">
					</div>
					<div class="col-md-2">
						<div class="add3" id = "addCityBtn2" style="display: none;" onclick="addCities('2');" ><i id = "btnIcon2" class="fa fa-plus-circle" aria-hidden="true"></i> Add</div>
					</div>
				</div>				

				<div class="clear"></div>
				<div class="col-md-8">
					<input type="text" autocomplete="off" name="companyZip" class="login-btn-new" placeholder="Enter Zip" aria-describedby="basic-addon1" value="<?php echo $rowCom['c_zip'];?>">
				</div>
				<div class="clear"></div>
					<div class="col-md-8">
						<div class="admin-conlable2" >
							<button type="submit" class="btn button4"  name = "companyBtn">Update</button>
						</div>
					</div>
					<div class="clear"></div>


				</form>
			</div>
			<div class="clear"></div>
			<!--------------------------2 over-------------------------->

			<div class="personal-main" id = "bankSection" >
				<h1>BANK DETAILS</h1>
				<form id = "bankForm" method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

				<div class="col-md-8">
					<input type="text" class="login-btn-new" placeholder="Acc Holder Name" aria-describedby="basic-addon1" name = "holderName" value = "<?php echo $rowBank['holder_name'];?>">
					<input type="text" class="login-btn-new" placeholder="Acc Number" aria-describedby="basic-addon1" name = "accountNum" value = "<?php echo $rowBank['act_number'];?>" >
					<input type="text" class="login-btn-new" placeholder="Bank Name" aria-describedby="basic-addon1"  name = "bankName" value = "<?php echo $rowBank['bank_name'];?>">
					<input type="text" class="login-btn-new" placeholder="Branch" aria-describedby="basic-addon1" name = "branch" value = "<?php echo $rowBank['branch'];?>" >
					<input type="text" class="login-btn-new" placeholder="IFSC Code" aria-describedby="basic-addon1" name = "ifsc" value = "<?php echo $rowBank['ifsc'];?>">
					<select class="form-control login-btn-new" name = "actType">
						<option value="-1">-- Acc Type --</option>
						<option value="Current" <?php echo $rowBank['type'] = 'Current' ? 'selected' : '';?>>Current</option>
						<option value="Saving"  <?php echo $rowBank['type'] = 'Saving' ? 'selected' : '';?>>Saving</option>
						</select>
					<div class="clear"></div>
				</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<div class="admin-conlable2" >
							<button type="submit" class="btn button4"  name = "bankBtn">Update</button>
						</div>
					</div>
					<div class="clear"></div>

				</form>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<!--------------------------3 over-------------------------->



			<div class="personal-main" id = "changeSection">
				<h1>CHANGE PASSWORD</h1>
				<form id = "changeForm" method = "post" action = "<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
				<div class="col-md-8">
					<input type="text" class="login-btn-new" placeholder="Old Password" aria-describedby="basic-addon1" name = "oldPass" id = "oldPass">
					<div id = "oldMsg" style="color:red;display: none;">						
						<span id = "resetM">Incorrect Password</span>
						<button class = "btn btn-primary resetBtn" id = "requestChange">Request for Password Reset</button>
						<div id = "resetMsg" style="color:green;display: none;">
							<span>Please Check your mail for password reset</span>
						</div>
					</div>					
					<input type="text" class="login-btn-new" placeholder="New Password" aria-describedby="basic-addon1" name = "newPass" id = "newPass">
					<div id = "passMsg" style="color:red;display: none;"></div>
					<input type="text" class="login-btn-new" placeholder="Confirm Password" aria-describedby="basic-addon1" id = "conNewPass">
					<div id = "coPassMsg" style="color:red;display: none;"></div>
					<div class="clear"></div>
				</div>
					<div class="clear"></div>
					<div class="col-md-8">
						<div class="admin-conlable2" >
							<button type="submit" class="btn button4"  id = "changeBtn" disabled = "disabled">Update</button>
						</div>
					</div>
					<div class="clear"></div>

			</div>
			<div class="clear"></div>
			<!--------------------------3 over-------------------------->					
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
<script type="text/javascript" src ='js/account.min.js' defer></script>
<?php include 'footer.php';?>