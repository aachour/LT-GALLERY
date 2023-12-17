<?php
	@$PAGE_TITLE="ABOUT US | LT GALLERY";
	@$CURRENT_SECTION="ABOUT US";
	include ("../includes/top.php");
	
	$query="SELECT * FROM `aboutus` WHERE `id`='1'";
	$result=runQuery($query);
	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
		$textArray=explode('</p>', sanitizeInput($text,"HTML"));
		$textCount=count($textArray);
		$halfTextCount=round($textCount/2)-1;

		$text1=$textArray[0];
		$text2=$textArray[1];
		
	}
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="aboutus">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">
				<img src="aboutus/images/<?php echo @$image;?>" width ="100%" />
			</div>
			
			<div class="content">

				<div class="col1">&nbsp;</div>

				<div class="col2">

					<div class="topSpacerBig big black gilroyMedium"><?php echo @$title;?></div>

					<?php if(@$sub_title!=""){?>
					<div class="topSpacer small black"><?php echo @$sub_title;?></div>
					<?php }?>

					<div class="row">
						<div class="topSpacer col-lg-6 col-12">
							<div class="small black">
								<?php 
									for($i=0;$i<$halfTextCount;$i++){
										echo $textArray[$i];
									}
								?>
							</div>
						</div>
						<div class="topSpacer  col-lg-6 col-12">
							<div class="small black">
								<?php 
									for($i=$halfTextCount;$i<$textCount;$i++){
										echo $textArray[$i];
									}
								?>
							</div>
						</div>
					</div>

				</div>

				<div class="clear"></div>

			</div>

		</div>

		<div class="topSpacerBigger">&nbsp;</div>

	</div>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->


<?php
	include ("../includes/bottom.php");
?>

<script>

	

</script>


