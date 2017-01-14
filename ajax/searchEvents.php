<?php
    session_start();
    include '../config.php';
    $date = timeZoneDate();
    
    $out = '';
    $qry = '';    
    $other = '';
    $status = 'status = 0';
    if($_POST['type'] == 'id'){
        $other = 'category = '.$_POST["value"];
    }else{
        $other = 'title like "%'.$_POST["value"].'%"';
    }
    if($_SESSION["gloCity"] != "%") {
        $city = $_SESSION["gloCity"];
        if($_POST['value'] == 'all'){
            $qry = 'select e_id,title,category from event_details where '.$status.' and end_date > "'.$date.'" and event_city_id = "'.$city.'"';
        }else{
            $qry = 'select e_id,title,category from event_details where '.$status.' and end_date > "'.$date.'" and event_city_id = "'.$city.'" and '.$other;
        }
    }else{
        if($_POST['type'] == 'id'){
            if($_POST['value'] == 'all'){
                $qry = 'select e_id,title,category from event_details where end_date > "'.$date.'" and '.$status;
            }else{
                $qry = 'select e_id,title,category from event_details where '.$status.' and end_date > "'.$date.'" and '.$other;
            }
        }else{
            $qry = 'select e_id,title,category from event_details where '.$status.' and end_date > "'.$date.'" and '.$other;
        }
    }

    $res = $con->query($qry);
    $count = $res->num_rows;

    if($count > 0){
        while ($row = $res->fetch_assoc()){
            if($_POST['type'] == 'title'){
                if(!empty($_POST['value'])) {
                    $row["title"] = preg_replace("/" . $_POST['value'] . "/i", '<b>$0</b>', $row["title"]);
                }
            }
            $out .= '<li id="'.$row["e_id"].'">'.$row["title"].'</li>';
        }
        echo $out;
    }else{
        echo '<h4>No Event Found</h4>';

    }