<?php
	@$PAGE_TITLE="ABOUT US | LT GALLERY";
	@$CURRENT_SECTION="ABOUT US";
	include ("../includes/top.php");
	
	$query="SELECT * FROM `aboutus` WHERE `id`='1'";
	$result=runQuery($query);
	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
		$textArray=explode(' ', sanitizeInput($text,"HTML"));
		$textCount=count($textArray);
		$text1=implode(' ', array_slice($textArray, 0, 81));
		$text2=implode(' ', array_slice($textArray, 81, $textCount));
		
	}
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="aboutus">

		<!--Section1-->
		<div class="section" id="section1" style="padding-top:0px !important;">

			<div class="content">

				<div class="topSpacerBigger big proximaSb mainTitle"><span class="proximaSb"></span><div class="redLine">

							<div class="image textRight">

							<img src="aboutus/images/<?php echo @$image;?>" width ="80%"/>

							</div>

				</div>
			</div>	

				<div class="topSpacerBig medium black proximaSb"><?php echo @$title;?></div>

				<div class="topSpacer small black"><?php echo @$sub_title;?></div>

				<div class="row">
					
					<div class="topSpacer col-lg-3 col-12">
						<div class="tiny black justified"><?php echo @$text1;?></div>
					</div>

					<div class="topSpacer col-lg-3 col-12">
						<div class="tiny black justified"><?php echo @$text2;?></div>
					</div>
										
				</div>
<!-- 
				<div class="image textRight">
					<img src="aboutus-images/images/<?php echo @$image;?>" />
				</div> -->

			</div>

		</div>

		<div class="topSpacerBigger">&nbsp;</div>
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


