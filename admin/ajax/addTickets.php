<?php 
	include '../../config.php';
	$count = $_POST['count'];	
	for($i = 0; $i < $count; $i++){
		$data = array(
			'tic_name' => $_POST['ticketname'][$i],
			'tic_description' => $_POST['description'][$i],
			'tic_last_date' => $_POST['lastdate'][$i] == '' ? Null : $_POST['lastdate'][$i],
			'tic_total' => $_POST['total'][$i],
			'tic_max' => $_POST['max'][$i],
			'tic_price' => $_POST['price'][$i],
			'tic_e_id' => $_POST['event']
			);		
		if($_POST['ticketId'][$i] != ''){
			$where_clause='where tic_id = '.$_POST['ticketId'][$i];
			if(dbRowUpdate($con, 'ticket_details' , $data, $where_clause)){
				echo 'OK';
			}else{
				echo "NO";
			}
		}else{
			if(dbRowInsert($con,'ticket_details', $data)){
				echo 'OK';
			}else{
				echo 'NO';
			}
		}
	}
?>