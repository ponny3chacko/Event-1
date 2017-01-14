<?php
session_start();
require('../pdf/fpdf.php');
class PDF extends FPDF
{
// Load data
	// $nam,$cou,$sdate,$edate,$table
function LoadData()
{	
	$qry = '';
	// if(!empty($nam)||!empty($cou)||!empty($sdate)||!empty($edate))
	// {

		$qry = "select user_profile.username,user_profile.user_id,book_history.bk_transaction_id,event_details.e_id,book_history.bk_num_tickets,book_history.bk_price,book_history.bk_user_id,book_history.bk_event_id,book_history.bk_created_on from book_history inner join event_details on event_details.e_id = book_history.bk_event_id inner join user_profile on user_profile.user_id = book_history.bk_user_id where bk_user_id = ".$_SESSION['id'];;

		// echo $qry ;
	// }
	include '../config.php';
	 // echo $qry;
	$res = $con-> query($qry);	 
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
	                    $result[$i][$key[$x]] = $r[$key[$x]]; 
	            }
	        }
	    }            
	    return $result; 
    }
}

// Better table
function ImprovedTable($header,$data,$title = '')
{
	$this->SetFont('Arial','B',10);
	
	$this->Cell(60,10,$title,0,1,'C');
	// Column widths
	$w = array(10, 50, 50, 50 ,10, 20 );
	// Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],6,$header[$i],1,0,'C');
	$this->Ln();
	$c = 1;	
	foreach($data as $key=>$row)
	{
		$date = date("d/M/y",strtotime($data[$key]['bk_created_on'])).' - '.date("h:m A",strtotime($data[$key]['bk_created_on']));

		$this->Cell($w[0],6,$c,'LR');
		$this->Cell($w[1],6,$data[$key]['username'],'LR');
		$this->Cell($w[2],6,$data[$key]['bk_transaction_id'],'LR');		
		$this->Cell($w[3],6,$date,'LR');	
		// $this->Cell($w[4],6,$data[$key]['title'],'LR');	
		$this->Cell($w[4],6,$data[$key]['bk_num_tickets'],'LR');
		$this->Cell($w[5],6,$data[$key]['bk_price'],'LR');	
		$this->Ln();
		$c++;
	}	
	
	// Closing line

	$this->Cell(array_sum($w),0,'','T');
}

}

$pdf = new PDF();
// Column headings
$header = array('ID', 'username','Transaction Id', 'date','num','price');
$title = 'Fast and Furious';
// Data loading
// $nam = $_POST['emp_type'];
// $cou = $_POST['city'];
// $sdate = $_POST['sdate'];
// $edate = $_POST['edate'];
// $table = $_GET['table'];

$data =$pdf->LoadData();
// print_r($data);
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data,$title);
$pdf->Output();
