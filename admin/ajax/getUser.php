<?php 
include '../../config.php';
	$qry = "select * from user_profile where user_profile.username like '%".$_POST['data']."%' limit 0,30";
	$res = $con->query($qry);
	if($res){	
		$count = $res->num_rows;
		if($count > 0){			
			while ($row = $res->fetch_assoc()) {
				echo '<li id = "user-'.$row['user_id'].'" value = "'.$row['username'].'">'.$row['username'].'</li>';
			}
		}
	}
?>