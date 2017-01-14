<?php 
	session_start();

	$_SESSION['price'] = $_POST['price'];
	$_SESSION['qty'] = $_POST['qty'];
	$_SESSION['details'] = $_POST['details'];
	$_SESSION['ticids'] = $_POST['ticids'];
	$_SESSION['ticqty'] = $_POST['ticqty'];
