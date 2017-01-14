<?php 
	include '../config.php';
	$data = array();
	$da = $_POST['data'];	
	$qry = 'insert into cities (city_name,city_state_id) values("'.ucwords($da['city']).'",'.$da['state'].')';	
	$res = $con->query($qry);

	if($res){
		$id = $con->insert_id;
		$qry = "select * from cities inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where cities.city_id = ".$id;
		$res = $con->query($qry);
		$row = $res->fetch_assoc();
		$data['city'] =  $row['city_name'].', '.$row['state_name'].' - '.$row['country_name'];
		$data['cityId'] = $id;
		echo json_encode($data);
	}