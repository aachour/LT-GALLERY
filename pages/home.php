<?php
	@$PAGE_TITLE="HOME | LT GALLERY";
	@$CURRENT_SECTION="HOME";
	include ("../includes/top.php");
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="home">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">

				<?php 
					$query="SELECT * FROM `top_banner` WHERE `id`='1' AND `status`='1'";
					$result=runQuery($query);
					if(numRows($result)==1){
						$row=fetchArray($result);
						foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
					}
				?>

				<img src="topbanner/images/<?php echo @$image;?>" width="100%" />

				<div class="topSpacer">
					<div class="col1">&nbsp;</div>
					<div class="col2">
						<div class="proximaSb bigger black"><?php echo sanitizeInput(@$title,"HTML"); ?></div>
					</div>
					<div class="clear"></div>
				</div>

			</div>
			
		</div>

		<div class="topSpacerBig">&nbsp;</div>
		
	</div>


<?php
	include ("../includes/bottom.php");
?>

