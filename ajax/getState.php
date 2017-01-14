<?php  
include '../config.php';

$qry = "select * from states where state_country_id = ".$_POST['coId'];
$res = $con -> query($qry);
	echo '<option>--States--</option>';
while ($row = $res->fetch_assoc()) {
	echo '<option value = "'.$row['state_id'].'">'.$row['state_name'].'</option>';
}
