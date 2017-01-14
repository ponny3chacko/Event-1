<?php	
	$whitelist = array(
	    '127.0.0.1',
	    '::1'
	);
	$base = '';
	

	if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
		define("HOST", 'localhost');	
		define("USER", 'root');
		define("PSWD", '');
		define("DB", 'event');		
		$base = "/";

	}else{		
		define("HOST", 'localhost');
		define("USER",'festivit_user');
		define("PSWD",'Festivito@78987');
		define("DB", 'festivit_data');
		$base = 'http://www.festivito.com/';
	}

	$con = new mysqli(HOST,USER,PSWD,DB);

    include 'requested/functions.php';
	
?>