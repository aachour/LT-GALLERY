<?php
	@$PAGE_TITLE="Home | LT Gallery";
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

				<div class="">
					<img src="topbanner/images/<?php echo @$image;?>" width="100%" />
				</div>
	
				<div class="topSpacer">
					<div class="col1 noPadding">&nbsp;</div>
					<div class="col2">
						<div class="proximaSb bigger black"><?php echo sanitizeInput(@$title,"HTML"); ?></div>
					</div>
					<div class="clear"></div>
				</div>

			</div>
			
		</div>

		<!--Section2-->
		<div class="section" id="section2">

			<div class="content">

				<div class="col1">
					<div class="medium gilroyMedium black">Exhibitions</div>
					<div class="topSpacer tiny black filterBtn clickable" type="1">Future&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn filterBtnActive clickable" type="2">Present&nbsp;&nbsp;<img src="static/images/rectangle.svg" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="3"><?php echo date('Y')-1;?>&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="4">Past&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
				</div>
				
				<div class="col2">

					<div class="textCenter hidden" id="loader">
						<img src="static/images/loader.gif" width="150px" />
					</div>

					<div id="allExhibitions"></div>

				</div>

				<div class="clear"></div>

			</div>
			
		</div>

		<div class="topSpacerBig">&nbsp;</div>
		
	</div>


	<script>

		var limit=4;
		var offset=0;
		var type=2;

		function loadExhibitions(type,limit,offset){
			$("#loader").removeClass("hidden");
			$.post("loadExhibitions/",{"type":type , "limit":limit , "offset":offset},function(result){
				$("#loader").addClass("hidden");
				if(result!=""){
					$("#allExhibitions").append(result);
				}else{
					$("#allExhibitions").append('<p class="medium black textCenter">No exhibitions found.</p>');
				}
			});
		}

		$(document).ready(function(){
			
			loadExhibitions(type,limit,offset);

			$(".filterBtn").click(function(){
				
				$(".filterBtn").each(function(){
					$(this).removeClass("filterBtnActive");
					$(this).find("img").addClass("hidden")
				});

				$(this).addClass("filterBtnActive");
				$(this).find("img").removeClass("hidden")

				offset=0;

				type=$(this).attr("type");

				$("#allExhibitions").html("");
				loadExhibitions(type,limit,offset)
				
			});

		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

