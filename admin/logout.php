<?php
session_start();

foreach($_SESSION as $key => $val)
{
    if ($key === 'adminId' || $key === 'adminUsername')
    {
        unset($_SESSION[$key]);
    }
}
header("Location: login.php");
?>