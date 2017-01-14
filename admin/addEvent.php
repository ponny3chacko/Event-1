<?php include 'header.php'; 
	$date = timeZoneDate();
?>
	<section class="content">
		<div class="row">            
            <div class="col-md-12"> 
            <!-- Horizontal Form -->
              	<div class="box box-info">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Horizontal Form</h3>
                	</div><!-- /.box-header -->
                	<!-- form start -->
                	<form class="form-horizontal" action="" id = "eventForm" method ="post" enctype="multipart/form-data">
	                  	<div class="box-body">
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Banner:</label>
	                      		<div class="col-sm-10">
	                        		<input type="file" class="form-control" name = "eventPic">
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Title:</label>
	                      		<div class="col-sm-10">
	                        		<input type="text" class="form-control" name = "title">
	                      		</div>
	                    	</div>
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Description :</label>
	                      		<div class="col-sm-10">
	                        		<textarea class="form-control" name = "description"></textarea>
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Terms:</label>
	                      		<div class="col-sm-10">
	                        		<textarea class="form-control" name = "terms"></textarea>	
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
				                <label for="dtp_input1" class="col-md-2 control-label">Set Dates: </label>
	                      		<div class="col-sm-5">				                
					                <div class="input-group date form_datetime col-md-12" data-date="<?php echo $date; ?>Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
					                    <input class="form-control" size="16" type="text" value="" placeholder = "Start Date" readonly>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					                </div>
									<input type="hidden" name = "startdate" id="dtp_input1" value="" /><br/>
								</div>
								<div class="col-sm-5">				                
					                <div class="input-group date form_datetime col-md-12" data-date="<?php echo $date; ?>Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input2">
					                    <input class="form-control" size="16" type="text" value="" placeholder = "End Date" readonly>
					                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
										<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					                </div>
									<input type="hidden" name = "enddate" id="dtp_input2" value="" /><br/>
								</div>
				            </div>
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Category:</label>
	                      		<div class="col-sm-10">
	                        		<select class="form-control" name = "category">
	                        			<option value = "-1">--Select-</option>
	                        			<?php 
	                        				$cat = getCategories($con);
	                        				foreach ($cat as $key => $value) {
	                        					echo '<option value = "'.$value['cat_id'].'">'.$value['cat_name'].'</option>';
	                        					// echo $value;
	                        				}
	                        			?>
	                        		</select>
	                      		</div>
	                    	</div>
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Address:</label>
	                      		<div class="col-sm-10">
	                        		<textarea class="form-control" name = "address"></textarea>
	                      		</div>
	                    	</div>
	                    	<div class="form-group">
	                    		<label class="col-sm-2 control-label">City:</label>
	                      		<!-- <div class="col-sm-10"> -->
	                    		<div class="citySelection col-sm-10">
			                        <input type="hidden" name="city_id" id = "hiddenCity1" value="" >
			                        <input type="text" autocomplete="off" class="login-btn-new" id = "selectCity1" onclick="selectCities('1')" onfocus="selectCities('1')" placeholder="e.g. Pune, Mumbai" aria-describedby="basic-addon1"  title = "Add where Event is going to be." value="" >
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
			                        <div class="clear"></div>
			                        <div id = "addCity1" style="display: none;">
			                            <div class="col-md-4">
			                                <select class="form-control" id = "country1" onchange="statesData('1',this.value);">
			                                    <option value="-1">--Country--</option>
			                                    <?php   
			                                        $rCo = $con->query("select * from countries");
			                                        while($rowCo = $rCo->fetch_assoc()){
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
			                    </div> 
	                    	</div>
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Email ID:</label>
	                      		<div class="col-sm-10">
	                        		<input type="text" class="form-control" name = "email" value = "">
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">User:</label>
	                      		<div class="citySelection col-sm-10">
			                        <input type="hidden" name="user_id" id = "hiddenUser" value="" >
			                        <input type="text" autocomplete="off" class="login-btn-new" id = "selectUser" placeholder="">
			                        <div class="scrollbar2 style-4" style="display: none;" id = "showUser">
			                            <div class="my-searchlist">
			                                <ul id = "listUser">

			                                </ul>
			                                <div class="force-overflow"></div>
			                            </div>
			                        </div>
			                        <div class="clear"></div>           		
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Facebook:</label>
	                      		<div class="col-sm-10">
	                        		<input type="text" class="form-control" name = "fb">
	                      		</div>
	                    	</div> 
	                    	<div class="form-group">
	                      		<label class="col-sm-2 control-label">Twitter:</label>
	                      		<div class="col-sm-10">
	                        		<input type="text" class="form-control" name = "tw">
	                      		</div>
	                    	</div> 	                    	
	                  	</div><!-- /.box-body -->
	                  	<div class="box-footer">
		                    <a href = "list.php" class="btn btn-default">Back</a>
	                    	<input type="submit" class="btn btn-info pull-right" value="Create" name = "create">
	                  	</div><!-- /.box-footer -->
	                  	<div id = "message" class="alert-warning"></div>
                	</form>
              	</div><!-- /.box -->              
            </div>
		</div>
	</section>	
<?php
$script = '<script type="text/javascript" src = "js/add.js"></script>';
include 'footer.php'; ?>