
	</div>
	<!--End page-->

	<!------Footer------>
	<div class="leftLine onlyDesktop"></div>
	<div class="horizontalLine onlyMobile"></div>
	
	<div id="footer">

		<div class="content">

			<div class="col1" style="padding-bottom:20px !important;">
				<a href="home/">
					<div><img src="static/images/logo1-black.png" width="60%" /></div>
				</a>
			</div>
			
			<div class="col2">

				<div class="row">

					<?php  
						$query="SELECT * FROM `footer` WHERE `id`='1' ";
						$result=runQuery($query);
						$row=fetchArray($result);
		                foreach($row as $key => $item){$$key=stripslashes($row[$key]);}
					?>
				
					<div class="col-lg-6 col-12">
						<div class="tiny black">
							<?php echo @$address;?><br />
							<?php echo @$working_hours;?>
						</div>
						<div class="topSpacerSmall tiny black">
							<?php echo @$phone;?><br />
							<?php echo @$email;?>
						</div>
					</div>
					
					<div class="col-lg-6 col-12">

						<div class="row">

							<div class="col-lg-8 col-12">
								<div class="topSpacer onlyMobile"></div>
								<div class="newsletter">
									<div class="tiny black">Sign up for our Newsletter</div>
									<div class="topSpacerSmall">
										<input type="text" class="tiny" placeholder="Email Addess" />
										<input type="button" class="tiny" value="Submit" />
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-12">
								<div class="socialMedia">
									<a href="#" target="_blank">
										<img src="static/images/a.png" />
									</a>&nbsp;
									<a href="#" target="_blank">
										<img src="static/images/instagram.png" />
									</a>&nbsp;
									<a href="#" target="_blank">
										<img src="static/images/youtube.png" />
									</a>&nbsp;
									<a href="#" target="_blank">
										<img src="static/images/linkedin.png" />
									</a>
								</div>
							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="clear"></div>
			
		</div>

	</div>

</body>

</html>
