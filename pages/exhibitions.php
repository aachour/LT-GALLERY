<?php
	@$PAGE_TITLE="EXHIBITIONS | LT GALLERY";
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
					<div class="topSpacer tiny black filterBtn clickable" type="1">Future&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black bold filterBtn clickable" type="2">Present&nbsp;&nbsp;<img src="static/images/rectangle.svg" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="3"><?php echo date('Y')-1;?>&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="4">Past&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
				</div>
				
				<div class="col2">

					<div class="textCenter hidden" id="loader">
						<img src="static/images/loader.gif" width="150px" />
					</div>

					<div id="allExhibitions"></div>

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
		var type=2;

		function loadExhibitions(type,limit,offset){
			$("#loader").removeClass("hidden");
			$.post("loadExhibitions/",{"type":type , "limit":limit , "offset":offset},function(result){
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
			
			loadExhibitions(type,limit,offset);

			$(".filterBtn").click(function(){
				
				$(".filterBtn").each(function(){
					$(this).removeClass("bold");
					$(this).find("img").addClass("hidden")
				});

				$(this).addClass("bold");
				$(this).find("img").removeClass("hidden")

				offset=0;

				type=$(this).attr("type");

				$("#allExhibitions").html("");
				$("#loadMoreBtn").removeClass("hidden");
				loadExhibitions(type,limit,offset)
				
			});

			$("#loadMoreBtn").click(function(){
				offset+=4;
				loadExhibitions(type,limit,offset);
			});

		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

