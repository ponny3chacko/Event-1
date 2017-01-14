<?php
    session_start();
    isset($_POST["city"]) ? $_SESSION["gloCity"] = $_POST["city"] : '%';
