<?php 
	session_start();
	include '../config.php';
	if(isset($_POST['new'])){
		$qry = "insert into ticket_details (tic_e_id) values(".$_SESSION['eId'].")";
		$res = $con->query($qry);	
		if($res){			
			$data['verify'] = 'OK';
			$data['tId'] = $con->insert_id;
			echo json_encode($data);
		}
	}
	if(isset($_POST['delete'])){
		$qry = "delete from ticket_details where tic_id = ".$_POST['tId'];
		$res = $con->query($qry);
		if($res){
			echo 'OK';
		}
	}

	if(isset($_POST['update'])){		
		$_POST['field'] = preg_replace("/^([ticket])+/", "tic_", $_POST['field']);
		$_POST['field'] = preg_replace("/([0-9 ])/", "", $_POST['field']);
		
		if($_POST['field'] === 'tic_Last_date' || $_POST['field'] === 'tic_Start_date'){

			$_POST['val'] = date('Y-m-d', strtotime($_POST['val']));			
		}
		
		$form_data = array(strtolower($_POST['field']) => $_POST['val']);		
		$where_clause = 'tic_id = '.$_POST['update'];
		
		dbRowUpdate($con, 'ticket_details', $form_data, $where_clause);
	}

