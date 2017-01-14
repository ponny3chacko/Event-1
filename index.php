<?php
include 'header.php';
$ci = isset($_SESSION["gloCity"]) ? ' and event_city_id like "'.$_SESSION["gloCity"].'"' : 'and event_city_id like "%"';

echo '<input type="hidden" id="refreshed" value="no">'
.'<script type="text/javascript">'
.'onload=function(){'
.'var e=document.getElementById("refreshed");'
.'if(e.value=="no")e.value="yes";'
.'else{e.value="no";location.reload();}'
.'}'
.'</script>';
?>
<div class="slider">
	<div class="callbacks_container">
		<ul class="rslides" id="slider">
		<?php
			$qry = "select e_id,title,banner_img from event_details where status = 0 and end_date >= '".$date."' ".$ci." order by start_date DESC limit 0,4";
		// echo $qry;
			$res=$con->query($qry);
			while ($row = $res->fetch_assoc()) 
			{          	
		?>
			<li><a href="Show/<?php echo slug($row['title'],'-');?>/<?php echo $row['e_id'];?>/"><img src="<?php echo $row['banner_img'];?>" class="img-responsive" alt="Festivito - <?php echo $row['title'];?>" title = "Book your <?php echo $row['title'];?> Show"/></a>

			</li>
		<?php
			}
		?>
		</ul>
	</div>
	<div class="clearfix"> </div>

</div>
<div class="content">	
	<div class="box_2">
		<div class="content2">
			<div class="box-1">
				<h1 class="m_2">Featured Shows</h1>

				<!-- <div class="clearfix"> </div> -->
			</div>
		
			<div class="event-list loaded">
			<?php
				$qry = "select * from event_details where status = 0 and end_date >= '".$date."' ".$ci." order by start_date desc limit 0,6";
				// echo $qry;
				$res = $con->query($qry);	
				$count = $res->num_rows;
				// echo $count;
				if($count > 0)			
				{
				while($row=$res->fetch_assoc())
				{
			?>
				<div class="event" style="opacity: 1;">

					<div class="event-img">
						<a href="Show/<?php echo slug($row['title'],'-');?>/<?php echo $row['e_id'];?>/" title = "Book your <?php echo $row['title'];?> Show">
							<img src="<?php echo $row['banner_img'];?>" style="opacity:1;" alt = "Festivito - <?php echo $row['title'];?>&">
						</a>
					</div>
					<div class="event-bottom">
						<h3 class="event-title" title = "<?php echo $row['title'];?>">
							<a href="Show/<?php echo slug($row['title'],'-');?>/<?php echo $row['e_id'];?>/"><?php echo substr($row['title'],0, 30);?>..</a>
						</h3>
						<p class="event-subline"><?php echo getCategory($con,$row['category']);?></p>
						<p class="event-meta">
						<?php 
							$start = new DateTime(date("Y-m-d",strtotime($row['start_date'])));
							$end = new DateTime(date("Y-m-d",strtotime($row['end_date'])));
							$interval = $start->diff($end);
							$da = $interval->format('%a');
							$sdt=date("jS M",strtotime($row['start_date']));
							$edt = date("jS M",strtotime($row['end_date'])); 
							if($da == 0)
							{
								echo $sdt;
							}
							else
							{
								echo $sdt ."-". $edt;
							}							
						?>
						</p>
						<?php 						
							$datetime1 = new DateTime(date("Y-m-d",strtotime($row['start_date'])));
							$datetime2 = new DateTime(date("Y-m-d"));
							$interval = $datetime2->diff($datetime1);
							$day = $interval->format('%R%a');
							$days = $interval->format('%a');							
							if($day == 1)
							{
								echo '<span class="tomorrow">Tomorrow</span>';
							}						
							else if($day == 0)
							{
								echo '<span class="tomorrow">Today</span>';	
							}
							else if($day > 1 )
							{
								echo '<span class="tomorrow"> After '.$days.' Days</span>';	
							}
						?>
						<div class="clearfix"></div>

					</div>
				</div>
			<?php         		
			} 
			}
			else
			{
				echo '<h1>No Current event </h1>';
			}
			?>          
			</div>       
						
		</div>       
</div>
	<div class="clearfix"></div>
</div>			
<?php
    $script = '<script type="text/javascript" src="js/responsiveslides.min.js"></script>'
    	.'<script type="text/javascript" src="js/index.js"></script>';    
    include 'footer.php';
?>