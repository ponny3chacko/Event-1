<?php
	session_start();
	include '../config.php';
	if($_POST){
		$eventTitleT = $_POST['eventTitleT'];
		$bookDate = $_POST['bookDate'];
		$qry = "select * from book_history inner join event_details on event_details.e_id = book_history.bk_event_id inner join user_profile on user_profile.user_id = book_history.bk_user_id where bk_user_id = ".$_SESSION['id'];

		if($eventTitleT !== '' || $bookDate !== ''){
			if($eventTitleT !== ''){			
				if($bookDate !== ''){
					$qry .= " and book_history.bk_event_id = ".$eventTitleT ." and date(book_history.bk_created_on) = '".$bookDate."'";							
				}else{
					$qry .= " and book_history.bk_event_id = ".$eventTitleT;
				}
			}else if($bookDate !== ''){
				if($eventTitleT !== ''){
					$qry .= " and book_history.bk_event_id = ".$eventTitleT ." and date(book_history.bk_created_on) = '".$bookDate."'";			
				}else{				
					$qry .= " and date(book_history.bk_created_on) = '".$bookDate."'";			
				}
			}
		}	
		$res=$con->query($qry);
		$count = $res->num_rows;
		if($count > 0){		
			$co = 1;
			while ($row=$res->fetch_assoc())
			{
				echo '<tr><td>'.$co.'</td>'
						.'<td>'.$row['username'].'</td>'
		                .'<td>'.$row['bk_transaction_id'].'</td>'
		                .'<td>'.date("jS M Y",strtotime($row['bk_created_on'])).' at '.date("h:m A",strtotime($row['bk_created_on'])).'</td>'
		                .'<td>'.$row['title'].'</td>'
		                .'<td>'.$row['bk_num_tickets'].'</td>'
		                .'<td>'.$row['bk_price'].'</td></tr>';
		    	$co++;
			}
		}else{
			echo '<tr><td  colspan = "7" style = "text-align:center;">No Booking Found</td></tr>';
		}
	}