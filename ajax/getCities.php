<?php 
include '../config.php';
	$qry = "select * from cities inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where cities.city_name like '%".$_POST['data']."%' limit 0,30";
	$res = $con->query($qry);
	if($res){	
		$count = $res->num_rows;
		if($count > 0){			
			while ($row = $res->fetch_assoc()) {
				echo '<li id = "'.$row['city_id'].'" value = "'.$row['city_name'].', '.$row['state_name'].' - '.$row['country_name'].'">'.$row['city_name'].'</li>';
			}
		}
		else{
			echo '<li id = "addOtherCity">Other</li>';
		}
	}