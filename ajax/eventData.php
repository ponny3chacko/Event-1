<?php 
	session_start();
	include '../config.php';
	$_POST['id']= preg_replace('[#]', '',$_POST['id']);
	if($_POST['id'] == 'eventTime1' || $_POST['id'] == 'eventTime2' || $_POST['id'] == 'eventFrom' || $_POST['id'] == 'eventTo'){
		$date = '';
		$qry = "select * from event_details where e_id = ".$_SESSION['eId'];
		$res = $con->query($qry);
		if($res){
			$row = $res->fetch_assoc();
			$gotDate='';
			$time = '';

			if($_POST['id'] == 'eventTime1' || $_POST['id'] == 'eventTime2'){

				$time = DateTime::createFromFormat('h : i a', $_POST['data']);
				$time = $time->format('H:i:s');	

				if($_POST['id'] == 'eventTime1'){					
					$gotDate = date('Y-m-d',strtotime($row['start_date']));					
				}

				if($_POST['id'] == 'eventTime2'){					
					$gotDate = date('Y-m-d',strtotime($row['end_date']));				
				}

			}else{
				if($_POST['field'] == 'start_date'){
					$time = date('H:i:s',strtotime($row['start_date']));
					$gotDate = date('Y-m-d',strtotime($row['start_date']));					
				}

				if($_POST['field'] == 'end_date'){
					$time = date('H:i:s',strtotime($row['end_date']));	
					$gotDate = date('Y-m-d',strtotime($row['end_date']));				
				}
			}	

			if($_POST['field'] === 'start_date' || $_POST['field'] === 'end_date'){
				if($_POST['field'] === 'start_date'){
					if($_POST['id'] === 'eventFrom'){		
						$gotDate = date('Y-m-d', strtotime($_POST['data']));	
					}else{
						$gotDate = date('Y-m-d', strtotime($row['start_date']));
					}
				}

				if($_POST['field'] === 'end_date'){
					if($_POST['id'] === 'eventTo'){
						$gotDate = date('Y-m-d', strtotime($_POST['data']));	
					}else{
						$gotDate = date('Y-m-d', strtotime($row['end_date']));						
					}
				}
			}

			$date = $gotDate . " " . $time;
			
			$form_data = array(
					$_POST['field'] => $date
				);			
			$where = 'where e_id = '.$_SESSION['eId'];
				
			dbRowUpdate($con, 'event_details', $form_data, $where);
		}		
	}else{
		if(isset($_POST['data']) && isset($_POST['field'])){		

			$form_data = array(
				$_POST['field'] => $_POST['data']
			);			
			$where = 'where e_id = '.$_SESSION['eId'];
			// echo dbRowUpdate($con, 'event_details', $form_data, $where);
			if(dbRowUpdate($con, 'event_details', $form_data, $where)){
				echo 'OK';				
			}else{
				echo 'NO';
			}
		}	

		if(isset($_FILES['eventPic'])){
			$fileName = $_FILES['eventPic']['name'];
			$tmp = $_FILES['eventPic']['tmp_name'];
			$exe = pathinfo($fileName, PATHINFO_EXTENSION);
			$des = '../images/event/';
			$t = time()."-".rand();
			$fileName = $t.".".$exe;
			$targetFile = $des.$fileName;
			
			if(move_uploaded_file($tmp, $targetFile)){
				list($width, $height, $type, $attr) = getimagesize($targetFile);
				resizeImage($targetFile, $targetFile, $width, $height);
					
				$qry = "select * from event_details where e_id = ".$_SESSION['eId'];
				$res = $con->query($qry);

				if($res){
					$row = $res->fetch_assoc();
					if($row['banner_img'] !== ''){			
						unlink($row['banner_img']);
					}
					$form_data = array(
						'banner_img' => $targetFile
					);			
					$where = 'where e_id = '.$_SESSION['eId'];
					
					if(dbRowUpdate($con, 'event_details', $form_data, $where)){
						echo 'OK';
					}else{
						echo 'NO';
					}
				}
			}
		}
	}