<?php
	@$PAGE_TITLE="PODCASTS | LT GALLERY";
	@$CURRENT_SECTION="PODCASTS";
	include ("../includes/top.php");
	include ("../includes/popupMsg.php");

	extract($_POST);
	extract($_GET);
		
	$query="SELECT * FROM `podcast` WHERE `id`='11'";
	$result=runQuery($query);
	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
		
	}
?>

<div class="fullContainer" id="podcasts">
	<div class="content">

		<div class="col1">
			<div class="medium gilroyMedium topSpacerBigger">PODCASTS</div>
		</div>

		<div class="col2">
			<div class="big black topSpacerBigger">Beirut-based contemporary art gallery, <br />featuring exclusive works by renowned and emerging talent
			<img src="static/images/Group 40.svg" alt=""></div>
		

			<div class="row">
				<div class="topSpacer col-lg-5 col-12 ">
						<div class="topSpacer">
						<img src="podcasts/images/<?php echo @$image;?>" width ="65%" />
						</div>
				</div>
				<div class="topSpacer col-lg-5 col-12">
				<div class="topSpacer big black gilroyMedium"><?php echo @$title;?></div>
				<div class="topSpacer medium black gilroyMedium"><?php echo @$subtitle;?></div>
				<div class="topSpacer small black gilroyMedium"><?php echo @$text;?></div>

				</div>
				<div class=" topSpacer textRight rightSpacer col-lg-6 col-12">
							<?php if($link!=""){?>
							<div class="topSpacer">
								<a href="<?php echo $link; ?>" target="_blank">
									<input type="button" value="Go to Episode" class="buttonTriangle small black" />
								</a>
							</div>
							<?php }?>
						</div>

			</div>

			<div class="row">
					<div class="col-12">
							<div class=" topSpacer bottomSpacer with-underline">	
								<div class="topSpacer big black gilroyMedium "><?php echo @$title;?></div>
								<div class="topSpacer medium black gilroyMedium"><?php echo @$subtitle;?></div>
								<?php if($link!=""){?>
							<div class="topSpacer bottomSpacer text-right col-10 ">
								<a href="<?php echo $link; ?>" target="_blank">
									<img src="static/images/Rectangle 22.png" alt="">
								</a>
							</div>
							<?php }?>
							</div>	
							
							
					</div>		
			</div>

			<div class="row">
					<div class="col-12">
							<div class=" topSpacer bottomSpacer with-underline">	
								<div class="topSpacer big black gilroyMedium "><?php echo @$title;?></div>
								<div class="topSpacer medium black gilroyMedium"><?php echo @$subtitle;?></div>
								<?php if($link!=""){?>
							<div class="topSpacer bottomSpacer text-right col-10 ">
								<a href="<?php echo $link; ?>" target="_blank">
									<img src="static/images/Rectangle 22.png" alt="">
								</a>
							</div>
							<?php }?>
							</div>	
					
					</div>		
			</div>
			<div class="row">
					<div class="col-12">
							<div class=" topSpacer bottomSpacer with-underline">	
								<div class="topSpacer big black gilroyMedium "><?php echo @$title;?></div>
								<div class="topSpacer medium black gilroyMedium"><?php echo @$subtitle;?></div>
								<?php if($link!=""){?>
							<div class="topSpacer bottomSpacer text-right col-10 ">
								<a href="<?php echo $link; ?>" target="_blank">
									<img src="static/images/Rectangle 22.png" alt="">
								</a>
							</div>
							<?php }?>
							</div>	
					
					</div>		
			</div>
			<div class="row">
					<div class="col-12">
							<div class=" topSpacer bottomSpacer with-underline">	
								<div class="topSpacer big black gilroyMedium "><?php echo @$title;?></div>
								<div class="topSpacer medium black gilroyMedium"><?php echo @$subtitle;?></div>
								<?php if($link!=""){?>
							<div class="topSpacer bottomSpacer text-right col-10 ">
								<a href="<?php echo $link; ?>" target="_blank">
									<img src="static/images/Rectangle 22.png" alt="">
								</a>
							</div>
							<?php }?>
							</div>	
					
					</div>		
			</div>




		</div>
	</div>

</div>




<?php
	include ("../includes/bottom.php");
?>
