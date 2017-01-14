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
		                		<label class="col-sm-2 control-label">Select Event:</label>
			                	<div class="col-sm-8">
			                		<select class="form-control" name = "event" id = "events">
			                			<option value='-1'>--select--</option>
			                			<?php 
			                				$res = $con->query('select e_id,title from event_details');
			                				if($res){
			                					while ($row = $res->fetch_assoc()) {
			                						echo '<option value="'.$row['e_id'].'">'.$row['title'].'</option>';
			                					}
			                				}
			                			?>
			                		</select>
			                	</div>
		                	</div>	  
		                	<hr>
		                	<input type="hidden" name="count" id = "count" value="1">
		                	<input type="hidden" name="date" id = "date" value="<?php echo $date;?>">
	                    	<div class="form-group" id = "ticketsHolder" style="display: none;">
	                      		<div class="col-sm-6" id = "ticket1">
		                    		<input type="hidden" name="ticketId[]">
	                      			<h5 class="text-center">Ticket 1</h5>
	                      			<hr>
                      				<div class="col-sm-12">
		                        		<input type="text" class="form-control" name = "ticketname[]" idplaceholder="Ticket Name"><br/>
		                        		<input type="text" class="form-control" name = "description[]" placeholder="Ticket Description"><br/>
		                        		<div class="input-group date form_datetime col-md-12" data-date="<?php echo $date; ?>Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
						                    <input class="form-control" size="16" type="text" value="" placeholder = "Last Date" readonly>
						                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
						                </div>
										<input type="hidden" name = "startdate[]" id="dtp_input1" value="" /><br/>
										<input type="hidden" name = "lastdate[]" id="dtp_input2" value="" /><br/>
									</div>
									<div class="col-sm-4">
	                        			<input type="text" class="form-control" name = "price[]" placeholder="Price">
	                        		</div>
									<div class="col-sm-4">		                        		
	                        			<input type="text" class="form-control" name = "total[]" placeholder="Total">
	                        		</div>
									<div class="col-sm-4">		                        		
	                        			<input type="text" class="form-control" name = "max[]" placeholder="Maximum Tickets">
	                      			</div>
	                      			<hr>
	                      		</div>	
	                    	</div>
	                    	<div class="form-group text-center">
	                    		<button name="add" class="btn btn-primary" style="display: none;" id="more">Add More Ticket</button>
	                    	</div>                 	
	                  	</div><!-- /.box-body -->
	                  	<div class="box-footer text-center">		                    
	                    	<input type="submit" class="btn btn-info" value="Add All" name = "addTickets" id = "addTickets">
	                  	</div><!-- /.box-footer -->
	                  	<div id = "message" class="alert-warning"></div>
                	</form>
              	</div><!-- /.box -->              
            </div>
		</div>
	</section>	
<?php
$script = '<script type="text/javascript" src = "js/ticket.js"></script>';
include 'footer.php'; ?>