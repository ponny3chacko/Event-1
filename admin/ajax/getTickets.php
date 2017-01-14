<?php 
	include '../../config.php';
	$date = timeZoneDate();
	$res = $con->query('select * from ticket_details where tic_e_id = '.$_POST['eid']);
	if($res){
		$count = $res->num_rows;
		if($count > 0){
			$i = 1;
			$data = array();
			while ($row = $res->fetch_assoc()) {
				$values = '<div class="col-sm-6" '.$i.'>'
						.'<input type="hidden" name="ticketId[]" value = "'.$row['tic_e_id'].'">'
						.'<h5 class="text-center">Ticket '.$i.'</h5>'
						.'<hr>'
						.'<div class="col-sm-12">'
						.'<input type="text" class="form-control" name = "ticketname[]" placeholder="Ticket Name" vlaue = "'.$row['tic_name'].'"><br/>'
						.'<input type="text" class="form-control" name = "description[]" placeholder="Ticket Description" vlaue = "'.$row['tic_description'].'"><br/>'
						.'<div class="input-group date form_datetime col-md-12" data-date="'.$date.'Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input'.$i.'">'
					        .'<input class="form-control" size="16" type="text" value="" placeholder = "Start Date" readonly>'
					        .'<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>'
							.'<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>'
					    .'</div>'
						.'<input type="hidden" name = "lastdate[]" id="dtp_input'.$i.'"  vlaue = "'.$row['tic_last_date'].'" /><br/>'
					.'</div>'
					.'<div class="col-sm-4">'
						.'<input type="text" class="form-control" name = "price[]" placeholder="Price"  vlaue = "'.$row['tic_price'].'">'
					.'</div>'
					.'<div class="col-sm-4">'
						.'<input type="text" class="form-control" name = "total[]" placeholder="Total" vlaue = "'.$row['tic_total'].'">'
					.'</div>'
					.'<div class="col-sm-4">'
						.'<input type="text" class="form-control" name = "max[]" placeholder="Maximum Tickets" vlaue = "'.$row['tic_max'].'">'
						.'</div>'
					.'</div>';

				array_push($data, $row);
				$i++;
			}
		echo json_encode($data);
		}else{
			echo "NO";
		}
	}
?>