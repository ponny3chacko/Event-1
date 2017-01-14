<?php
require('fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData()
{
	$con = new mysqli("localhost","root","","loan");	
	$res = $con -> query("select P_id,b_amt,b_city,date from personal_loan where date >= '2016-05-18' and date <= '2016-08-31' order by date");	 
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

// Better table
function ImprovedTable($header,$data)
{
	// Column widths
	$w = array(30, 30, 30 ,30);
	// Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	
	foreach($data as $key=>$row)
	{
		$date = date('m/d/Y',strtotime($data[$key]['date']));
		$this->Cell($w[0],6,$data[$key]['P_id'],'LR');
		$this->Cell($w[1],6,$data[$key]['b_amt'],'LR');		
		$this->Cell($w[2],6,$data[$key]['b_city'],'LR');	
		$this->Cell($w[3],6,$date,'LR');	
		$this->Ln();
	}	
	// Closing line

	$this->Cell(array_sum($w),0,'','T');
}

}

$pdf = new PDF();
// Column headings
$header = array('ID', 'Amount', 'City', 'Date');
// Data loading
$data =$pdf->LoadData();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->Output();
?>
