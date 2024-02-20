<?php
	@$PAGE_TITLE="Exhibitions | LT Gallery";
	@$CURRENT_SECTION="EXHIBITIONS";
	include ("../includes/top.php");
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="exhibitions">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">

				<div class="col1">
					<div class="medium gilroyMedium black">Exhibitions</div>
					<!-- <div class="topSpacer tiny black filterBtn clickable" year="<?php echo date('Y')+1; ?>">Future&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div> -->
					<div class="topSpacerSmall tiny black filterBtn filterBtnActive clickable" year="<?php echo date('Y'); ?>">Present&nbsp;&nbsp;<img src="static/images/rectangle.svg" /></div>
					<!-- <div class="topSpacerSmall tiny black filterBtn clickable" year="<?php echo date('Y')-1; ?>"><?php echo date('Y')-1;?>&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div> -->
					<div class="topSpacerSmall tiny black">Past</div>
					<?php 
						$query="SELECT DISTINCT `from_year` FROM `exhibitions` WHERE `from_year` < '".(date('Y'))."' AND `from_year` > 0 AND `status`='1' ";
						$result=runQuery($query);
						if(numRows($result)>0){
							while($row=fetchArray($result)){
								foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
								echo'<div class="topSpacerSmall micro black filterBtn clickable" year="'.$from_year.'">'.$from_year.'&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>';
							}
						}
					?>
				</div>
				
				<div class="col2">

					<div id="allExhibitions"></div>

					<div class="textCenter hidden" id="loader">
						<img src="static/images/loader.gif" width="150px" />
					</div>

					<div class="topSpacer textCenter">
						<input type="button" class="small blackGreyBtn" id="loadMoreBtn" value="Load More" />
					</div>

				</div>

				<div class="clear"></div>

			</div>
			
		</div>

		<div class="topSpacerBig">&nbsp;</div>
		
	</div>


	<script>

		var limit=4;
		var offset=0;
		var year=new Date().getFullYear();

		function loadExhibitions(year,limit,offset){
			$("#loader").removeClass("hidden");
			$.post("loadExhibitions/",{"year":year , "limit":limit , "offset":offset},function(result){
				$("#loader").addClass("hidden");
				if(result!=""){
					$("#allExhibitions").append(result);
				}else if(offset==0 && result=="") {
					$("#allExhibitions").append('<p class="medium black textCenter">No exhibitions found.</p>');
					$("#loadMoreBtn").addClass("hidden");
				}else{
					$("#loadMoreBtn").addClass("hidden");
				}
			});
		}

		$(document).ready(function(){
			
			loadExhibitions(year,limit,offset);

			$(".filterBtn").click(function(){
				
				$(".filterBtn").each(function(){
					$(this).removeClass("filterBtnActive");
					$(this).find("img").addClass("hidden")
				});

				$(this).addClass("filterBtnActive");
				$(this).find("img").removeClass("hidden")

				offset=0;

				year=$(this).attr("year");

				$("#allExhibitions").html("");
				$("#loadMoreBtn").removeClass("hidden");
				loadExhibitions(year,limit,offset)
				
			});

			$("#loadMoreBtn").click(function(){
				offset+=4;
				loadExhibitions(year,limit,offset);
			});

		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

