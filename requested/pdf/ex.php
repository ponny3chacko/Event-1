<?php

function LoadData()
{
	$con = new mysqli("localhost","root","","loan");
	// Read file lines
	// $lines = file($file);
	$data = array();
	// foreach($lines as $line)
	// 	$data[] = explode(';',trim($line));	
	$res = $con -> query("select P_id,b_amt,b_city from personal_loan");
	//$data = $res->fetch_row();
	// $data = explode(' ',trim($line));
	// return $data;


	if($res)
        {
            $numResults = $res->num_rows;
            for($i = 0; $i < $numResults; $i++)
            {
                $r = $res->fetch_array();
                $key = array_keys($r); 
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
                        if($res->num_rows > 1)
                            $result[$i][$key[$x]] = $r[$key[$x]];
                        else if($res->num_rows < 1)
                            $result = null; 
                        else
                            $result[$key[$x]] = $r[$key[$x]]; 
                    }
                }
            }            
            return $result; 
        }
}
$data = LoadData();
print_r($data);
foreach ($data as $key => $value) 
{
	echo $data[$key]['P_id']."<br>";
	echo $data[$key]['b_amt']."<br>";
	echo $data[$key]['b_city']."<br>";
}
?>