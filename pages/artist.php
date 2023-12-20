<?php
	@$PAGE_TITLE="ARTIST | LT GALLERY";
	@$CURRENT_SECTION="ARTIST";
	include ("../includes/top.php");

	@extract(@$_GET);

	$args=explode("-",sanitizeInput($args));
	$title=@$args[0];
	$artist_id=@$args[1];

	if(!isset($artist_id) || $artist_id==""){
		echo "<meta http-equiv='refresh' content='0;url=exhibitions/'>";
		die();
	}	

	$query="SELECT * FROM `artists` WHERE `id`='".$artist_id."' AND `status`='1' ";
	$result=runQuery($query);

	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	

	}else{
		echo "<meta http-equiv='refresh' content='0;url=exhibitions/'>";
		die();
	}

?>

	<!--Gallery Images-->
	<div class="popup hidden" id="popupGallery" style="padding:0px !important;">

		<div class="closeBtn closeBtn2 clickable"></div>

		<div class="swiper" id="swiperGallery">
			<div class="swiper-wrapper">
				<?php
					$query="SELECT `image` as `galleryImage` FROM `artist_images` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `listorder` ASC";
					$result=runQuery($query);
					if(numRows($result)>0){
						while($row=fetchArray($result)){
							foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
							echo'<div class="swiper-slide gallery-slide textCenter">
								<img src="artists/images/'.$galleryImage.'" />
							</div>';
							
						}
					}
				?>
			</div>
			<div class="swiper-button-next swiper-button-next-white onlyDesktop"></div>
			<div class="swiper-button-prev swiper-button-prev-white onlyDesktop"></div>
		</div>

	</div>


	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="exhibition">

		<!--Section1-->
		<div class="section" id="section1">

			<div class="content">

				<div class="col1">
					<div class="medium gilroyMedium black"><?php echo $name; ?></div>
					<div class="topSpacer tiny black bold filterBtn clickable" type="1">Biography&nbsp;&nbsp;<img src="static/images/rectangle.svg" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="2">Gallery&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="3">Honors & Awards&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="4">Solo Exhibitions&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="5">Collective Exhibitions&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="6">Collections&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
				</div>
				
				<div class="col2">

					<div class="bottomSpacer">
						<img src="artists/images/<?php echo $image; ?>" width="100%" />
					</div>
					
					<div class="row">

						<div class="col-lg-6 col-12">

							<div class="topSpacer">
								<input type="button" value="View Available Artworks" class="buttonTriangle small black" />
							</div>

						</div>
						
						<div class="col-lg-6 col-12">
							<div class="topSpacer tiny black"><?php echo sanitizeInput($text,"HTML");?></div>
						</div>
						
					</div>

					<!--Gallery-->
					<div class="topSpacerBigger">
						<?php 
							$query="SELECT * FROM `artist_images` WHERE `artist_id`='".$artist_id."' AND `status`='1' ORDER BY `listorder` ASC ";
							$result=runQuery($query);
							
							if(numRows($result)>0){
								echo'<div class="masonry-container" id="masonry-container">';
									$i=1;
									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										echo'<div class="masonry-item thumb-image topSpacerSmaller clickable" counter="'.$i.'">
											<img src="artists/images/'.$image.'" width="100%" />
										</div>';
										$i++;
									}
								echo'</div>';
							}
						?>
					</div>

					<!--Awards,Exhibitions,Collections-->
					<div class="topSpacerBigger row">
						
						<div class="col-lg-6 col-12">
							
							<div class="bottomSpacer">
								<input type="button" class="artistTab small buttonTriangle" value="HONORS & AWARDS" section="1" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="artistTab small buttonTriangle" value="SOLO EXHIBITIONS" section="2" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="artistTab small buttonTriangle" value="COLLECTIVE EXHIBITIONS" section="3" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="artistTab small buttonTriangle" value="COLLECTIONS" section="4" />
							</div>
							
						</div>

						<div class="col-lg-6 col-12">

							<!--Awards-->
							<?php
								$query="SELECT * FROM `artist_awards` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `id` DESC";
								$result=runQuery($query);
								if(numRows($result)>0){
									echo'<div class="artistSection" section="1">';
										while($row=fetchArray($result)){
											foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
											echo'<div class="bottomSpacer">
												<div class="text tiny black">'.sanitizeInput(@$year,"HTML").'</div>
												<div class="topSpacerSmaller tiny black">
													'.sanitizeInput(@$title,"HTML");
													if(@$city!=""){echo" - ".$city;}
													if(@$country_id!="0"){echo". ".getCountryName($country_id);}
												echo'</div>
											</div>';
										}
									echo"</div>";
								}
							?>

							<!--Solo Exhibitions-->
							<?php
								$query="SELECT `artist_exhibitions`.`year` , `artist_exhibitions`.`title` , `artist_exhibitions`.`city` , `artist_exhibitions`.`country_id` , `exhibitions`.`from_year` as `year2` , `exhibitions`.`title` as `title2` ,`exhibitions`.`city` as `city2`	,`exhibitions`.`country_id` as `country_id2`
								FROM `artist_exhibitions` 
								LEFT JOIN `exhibitions`
								ON `artist_exhibitions`.`exhibition_id`=`exhibitions`.`id`
								WHERE `artist_exhibitions`.`artist_id`='".@$artist_id."' 
								AND `artist_exhibitions`.`status`='1' 
								AND ( (`artist_exhibitions`.`type`='1' AND `exhibitions`.`category_id`='1')
								OR ( `artist_exhibitions`.`type`='2' AND `artist_exhibitions`.`category_id`='1') )
								ORDER BY `artist_exhibitions`.`year` DESC , `exhibitions`.`from_year` DESC ";

								$result=runQuery($query);
								if(numRows($result)>0){
									echo'<div class="artistSection hidden" section="2">';
										while($row=fetchArray($result)){
											foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}
											if($type==1){
												$year=$year2;
												$title=$title2;
												$city=$city2;
												$country_id=$country_id2;
											}
											echo'<div class="bottomSpacer">
												<div class="text tiny black">'.sanitizeInput(@$year,"HTML").'</div>
												<div class="topSpacerSmaller tiny black">
													'.sanitizeInput(@$title,"HTML");
													if(@$city!=""){echo" - ".$city;}
													if(@$country_id!="0"){echo". ".getCountryName($country_id);}
												echo'</div>
											</div>';
										}
									echo"</div>";
								}
							?>

							<!--Collective Exhibitions-->
							<?php
								$query="SELECT `artist_exhibitions`.`year` , `artist_exhibitions`.`title` , `artist_exhibitions`.`city` , `artist_exhibitions`.`country_id` , `exhibitions`.`from_year` as `year2` , `exhibitions`.`title` as `title2` ,`exhibitions`.`city` as `city2`	,`exhibitions`.`country_id` as `country_id2`
								FROM `artist_exhibitions` 
								LEFT JOIN `exhibitions`
								ON `artist_exhibitions`.`exhibition_id`=`exhibitions`.`id`
								WHERE `artist_exhibitions`.`artist_id`='".@$artist_id."' 
								AND `artist_exhibitions`.`status`='1' 
								AND ( (`artist_exhibitions`.`type`='1' AND `exhibitions`.`category_id`='2')
								OR ( `artist_exhibitions`.`type`='2' AND `artist_exhibitions`.`category_id`='2') )
								ORDER BY `artist_exhibitions`.`year` DESC , `exhibitions`.`from_year` DESC ";

								$result=runQuery($query);
								if(numRows($result)>0){
									echo'<div class="artistSection hidden" section="3">';
										while($row=fetchArray($result)){
											foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}
											if($type==1){
												$year=$year2;
												$title=$title2;
												$city=$city2;
												$country_id=$country_id2;
											}
											echo'<div class="bottomSpacer">
												<div class="text tiny black">'.sanitizeInput(@$year,"HTML").'</div>
												<div class="topSpacerSmaller tiny black">
													'.sanitizeInput(@$title,"HTML");
													if(@$city!=""){echo" - ".$city;}
													if(@$country_id!="0"){echo". ".getCountryName($country_id);}
												echo'</div>
											</div>';
										}
									echo"</div>";
								}
							?>

							<!--Collections-->
							<?php
								$query="SELECT * FROM `artist_collections` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `id` DESC";
								$result=runQuery($query);
								if(numRows($result)>0){
									echo'<div class="artistSection hidden" section="4">';
										while($row=fetchArray($result)){
											foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}
											if($day!=0){echo $day."-";}
											if($month!=0){echo $month."-";}
											if($year!=0){echo $year;}
											echo'<div class="bottomSpacer">
												<div class="text tiny black">'.sanitizeInput(@$name,"HTML").'</div>
												<div class="topSpacerSmaller tiny black">
													'.sanitizeInput(@$name,"HTML");
													if(@$city!=""){echo" - ".$city;}
													if(@$country_id!="0"){echo". ".getCountryName($country_id);}
												echo'</div>
											</div>';
										}
									echo"</div>";
								}
							?>

						</div>

					</div>
	
				</div>

				<div class="clear"></div>

			</div>
			
		</div>

		<div class="topSpacerBig">&nbsp;</div>
		
	</div>


	<script>

		function setGallerySwiper(counter=0){
			
			var windowWidth=$(window).width();
			var windowHeight=$(window).height();
			
			$(".gallery-slide").each(function(){
				var imageWidth=$(this).find("img").width();
				$(this).width(imageWidth);
				if(windowWidth>=900){
					// $(this).find("img").width((imageWidth*0.65));
					$(this).find("img").height((windowHeight*0.4));
					$(this).find("img").css('margin-top','10%');
				}else{
					$(this).find("img").width((imageWidth*0.40));
					$(this).find("img").css('margin-top','165px');
				}
			});

			var swiperGallery = new Swiper('#swiperGallery', {
				slidesPerView: "1",
				spaceBetween: 30,
				loop: true,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
			});

			swiperGallery.slideTo(parseInt(counter));

			$(".thumb-image").click(function(){
				var counter=$(this).attr("counter");
				$("#popupGallery").removeClass("hidden");
				setGallerySwiper(counter);
			});
		}

		function fixImages(){
			var $masonryContainer = $('#masonry-container');
			$masonryContainer.masonry({
				itemSelector: '.masonry-item',
				columnWidth: '.masonry-item',
				gutter: 20, // Adjust the space between columns
				fitWidth: true // Set to true for a fluid-width container
			});
		}

		$(window).resize(function(){
			fixImages();
			setGallerySwiper();
		});

		$(window).on('load', function() {
			fixImages();
			setGallerySwiper();
		});


		$(document).ready(function(){

			$(".artistTab").click(function(){
				$(".artistSection").addClass("hidden"); 
				var value=$(this).attr("section");

				$('.artistSection[section="'+value+'"]').removeClass("hidden");
			});

			$("#popupGallery").find(".closeBtn").click(function(){
				$("#popupGallery").addClass("hidden");
				$(".swiper1Btn").removeClass("hidden");
			});

		});

	</script>

<?php
	include ("../includes/bottom.php");
?>

