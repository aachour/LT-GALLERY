<?php
	@$PAGE_TITLE="PODCASTS | LT GALLERY";
	@$CURRENT_SECTION="PODCASTS";

	include ("../includes/top.php");
		
	$query="SELECT * FROM `podcast` WHERE `status`='1' ORDER BY `id` DESC LIMIT 0,1";
	$result=runQuery($query);
	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
	}
?>

<div class="fullContainer" id="podcasts">

	<!--Section1-->
	<div class="section" id="section1">

		<div class="content">

			<div class="col1">
				<div class="medium black gilroyMedium ">PODCASTS</div>
			</div>

			<div class="col2">

				<div class="big black ">Beirut-based contemporary art gallery, <br />featuring exclusive works by renowned and emerging talent &nbsp;<img src="static/images/Group 40.svg" alt=""></div>
			
				<div class="row">
					
					<div class="topSpacer col-lg-3 col-12 ">
						<img class="topSpacer" src="podcasts/images/<?php echo @$image;?>" width ="100%" />
					</div>

					<div class="topSpacer col-lg-9 col-12">
						<div class="topSpacer medium black gilroyMedium"><?php echo @$title;?></div>
						<div class="topSpacer small black"><?php echo @$subtitle;?></div>
						<div class="topSpacer tiny black halfText"><?php echo @$text;?></div>
						<?php if($link!=""){?>
						<div class="topSpacerBig textRight">
							<a href="<?php echo $link; ?>" target="_blank">
								<input type="button" value="Go to Episode" class="buttonTriangle small black" />
							</a>
						</div>
						<?php }?>
					</div>

				</div>
				
				<div class="topSpacerBig">&nbsp;</div>

				<?php 
					$query="SELECT * FROM `podcast` WHERE `id`!='".$id."' AND `status`='1' ORDER BY `id` DESC";
					$result=runQuery($query);
					if(numRows($result)>0){
						while($row=fetchArray($result)){
							foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
							echo'<div class="topSpacerBig podcast" status="0">
								<div class="title clickable">
									<div class="floatLeft medium black gilroyMedium">'.@$title.'</div>
									<div class="floatRight">	
										<img src="static/images/triangle-right-big.png" width="25px"></div>
									<div class="clear"></div>
									<div class="topSpacer small black">'.@$subtitle.'</div>
									<div class="topSpacerSmall text tiny black hidden">'.sanitizeInput(@$text,"HTML").'</div>
								</div>
							</div>';
						}
					}
				?>

			</div>

			<div class="clear"></div>

		</div>

	</div>

	<div class="topSpacerBig">&nbsp;</div>

</div>

<script>

	$(document).ready(function(){

		$(".podcast").click(function(){
			var status=$(this).attr("status");
			if(status==0){
				$(this).find(".text").removeClass("hidden");
				$(this).attr("status","1");
			}else{
				$(this).find(".text").addClass("hidden");
				$(this).attr("status","0");
			}
		})

	});

</script>

<?php
	include ("../includes/bottom.php");
?>
