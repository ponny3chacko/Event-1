			    <!-- <div class="clear"></div>                
  			</div>   -->
			<!-- <div class="clearfix"> </div>
		</div> -->
	<!-- </div>      
</div>	 -->
 
<div class="container" > 
 <footer id="footer">

    <div id="footer-widgets" class="gp-footer-larger-first-col">
		<div class="gp-container row">
			<div class="col-md-4">
				<div class="footer-widget footer-1">
	            	<div class="wpb_wrapper">
						<img src="images/logo.png" alt="Festivito" style="width: 40%;" />
					</div> 
			        <br>
					<p class="text">
						Festivito.com is an online event ticket booking portal. Here you can find handpicked events from all categories.</p>
				</div>	
			</div>
			<div class="col-md-4">
				<div class="col_1_of_3 span_1_of_3">
					<?php		
						$category = array();				
						foreach (getCategories($con) as $key => $value) {     
					        array_push($category,'<li><a href="#">'.getCategories($con)[$key]['cat_name'].'</a></li>');
					    }
					    $till = count($category)/2;
					    // echo $till;
					?>						
					<h3>Categories</h3>
					<div class="col-lg-6  text-center">
						<ul class="first">	
							<?php
							for($i = 0;$i < $till; $i++){
								echo $category[$i];
							}
							?>
						</ul>
					</div>
					<div class="col-lg-6 text-center">
						<ul class="first">						
							<?php
							for($i = 4;$i < $till*2 ; $i++){
								echo $category[$i];
							}
							?>
						</ul>
					</div>
			     </div>	
			</div>

			<div class="col-md-4">
				<div class="footer-widget footer-1">
					<div class="col-lg-12 text-center">
						<ul class="first">
							<li><a href="Privacy/">Privacy &amp; Policy</a></li>
							<li><a href="TermsConditions/">Terms &amp; Conditions</a></li>
							<li><a href="ContactUs/">Contact Us</a></li>
						</ul>
					</div>
		     	</div>	
			</div>   

	        <!-- <div class="clearfix"> </div> -->
		</div>
		<div class="copy">			
				<p>
				&copy; 2016 Festivito. All Rights Reserved <a href="http://sungare.com" target="_blank">Sungare Technologies Pvt. Ltd.</a>				
				</p>
			
			<div class="social-footer">
				<a href="https://www.facebook.com/"><i class="fa fa-facebook grow grow-fb"></i></a>
				<a href="https://www.twitter.com/"><i class="fa fa-twitter grow grow-tw"></i></a>
				<a href="https://www.linkedin.com/"><i class="fa fa-linkedin grow grow-l"></i></a>
				<a href="https://www.google.com/"><i class="fa fa-google-plus grow grow-g"></i></a>
			</div>
		</div>
	</div>
  </footer>
</div>
	 <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="  crossorigin="anonymous"></script> -->
	<!-- <script type="text/javascript" src="js/jquery.min.js"></script> -->


	<script type="text/javascript" src="js/jquery-ui.min.js" ></script>  
	<script type="text/javascript" src="js/dataTables.min.js" ></script>
	<script type="text/javascript" src="js/wickedpicker.min.js" ></script>
	<script type="text/javascript" src="js/customFooter.js"></script>
	<script type="text/javascript" src="js/quill.min.js"></script>	

<!--	<script type="text/javascript" src="js/customFooter.js" ></script>-->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-88029501-1', 'auto');
		ga('send', 'pageview');

	</script>
	<?php echo isset($script) ? $script: '';?>
</body>
</html>