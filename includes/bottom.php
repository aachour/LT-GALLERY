
	</div>
	<!--End page-->

	<!------Footer------>
	<div class="leftLine onlyDesktop"></div>
	<div class="horizontalLine onlyMobile"></div>
	
	<div id="footer">

		<div class="content">

			<div class="col1" style="padding-bottom:20px !important;">
				<a href="home/">
					<div><img src="static/images/logo1-black.png" width="150px" /></div>
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
							<span class="gilroyMedium"><?php echo @$address;?></span><br />
							<span class="gilroyRegular"><?php echo @$working_hours;?></span>
						</div>
						<div class="topSpacerSmall tiny black gilroyLight">
							<?php echo @$phone;?><br />
							<?php echo @$email;?>
						</div>
					</div>
					
					<div class="col-lg-6 col-12">

						<div class="row">

							<div class="col-lg-8 col-12">
								<div class="topSpacerSmaller onlyMobile">&nbsp;</div>
								<div class="newsletter">
									<div class="tiny black">Sign up for our Newsletter</div>
									<div class="topSpacerSmall">
										<input type="text" class="tiny" placeholder="Email Address" />
										<input type="button" class="tiny" value="Submit" />
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-12">
								<div class="topSpacerSmaller onlyMobile">&nbsp;</div>
								<div class="socialMedia">
									<?php if(@$asocial!=""){?>
										<a href="<?php echo @$asocial;?>" target="_blank">
											<img src="static/images/a.png" />
										</a>&nbsp;
									<?php }?>
									<?php if(@$instagram!=""){?>
										<a href="<?php echo @$instagram;?>" target="_blank">
											<img src="static/images/instagram.png" />
										</a>&nbsp;
									<?php }?>
									<?php if(@$youtube!=""){?>
										<a href="<?php echo @$youtube;?>" target="_blank">
											<img src="static/images/youtube.png" />
										</a>&nbsp;
									<?php }?>
									<?php if(@$linkedin!=""){?>
										<a href="<?php echo @$linkedin;?>" target="_blank">
											<img src="static/images/linkedin.png" />
										</a>
									<?php }?>
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
