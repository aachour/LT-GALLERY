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
					$query="SELECT * FROM `top_banner` WHERE `status`='1' ORDER BY `id` DESC";
					$result=runQuery($query);
					if(numRows($result)>0){
						echo'<div class="swiper" id="homeSwiper" style="overflow: hidden !important;">
							<div class="swiper-wrapper">';
								while($row=fetchArray($result)){
									foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
									echo'<div class="swiper-slide">
										<div class="">
											<img src="topbanner/images/'.@$image.'" width="100%" />
										</div>
									</div>';
								}
							echo'</div>

							<div class="swiper-pagination" id="homeSwiper-pagination"></div>

						</div>';

						
					}
				?>

			</div>

			<div class="content">
				<div class="topSpacer">
					<div class="col1 noPadding">&nbsp;</div>
					<div class="col2">
						<?php 
							$query="SELECT * FROM `home_text` WHERE `id`='1'";
							$result=runQuery($query);
							if(numRows($result)==1){
								$row=fetchArray($result);
								foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
								echo'<div class="proximaSb bigger black">
									<div class="floatLeft"><img src="static/images/rectangle.svg" width="35px" /></div>
									<div class="floatRight" style="width:calc(100% - 50px); line-height:170%;">'.sanitizeInput(@$text).'</div>
									<div class="clear"></div>
								</div>';
							}
						?>
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
				}else{
					$("#allExhibitions").append('<p class="medium black textCenter">No exhibitions found.</p>');
				}
			});
		}

		function setTopSliderSwiper(){
			var swiperTestimonials = new Swiper('#homeSwiper', {
				slidesPerView: '1',
				spaceBetween: 30,
				loop: true,
				autoplay: {
					delay: 4500,
					disableOnInteraction: false,
				},
				pagination: {
					el: '#homeSwiper-pagination',
					clickable: true
				},
			});
		}
		

		$(document).ready(function(){
			
			loadExhibitions(year,limit,offset);

			setTopSliderSwiper();

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
				loadExhibitions(year,limit,offset)
				
			});

		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

