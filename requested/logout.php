<?php
session_start();
//include 'config.php';
//if(isset($_GET["id"]))
//{
//	$lt = $_GET["id"];
//	if($lt=="out")
//	{
foreach($_SESSION as $key => $val)
{

    if ($key !== 'gloCity')
    {

        unset($_SESSION[$key]);

    }

}
		header("Location: Home/");
//	}
//}
?>