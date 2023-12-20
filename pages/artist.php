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
							// $query="SELECT * FROM `artist_images` WHERE `artist_id`='".$artist_id."' AND `status`='1' ORDER BY `listorder` ASC ";
							// $result=runQuery($query);
							
							// if(numRows($result)>0){
							// 	echo'<div class="masonry-container" id="masonry-container">';
							// 		while($row=fetchArray($result)){
							// 			foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
							// 			echo'<div class="masonry-item topSpacerSmaller">
							// 				<img src="artists/images/'.$image.'" width="100%" />
							// 			</div>';
							// 		}
							// 	echo'</div>';
							// }
						?>
					</div>

					<!--Awards,Exhibitions,Collections-->
					<div class="topSpacerBigger row">
						
						<div class="col-lg-6 col-12">
							
							<div class="bottomSpacer">
								<input type="button" class="small buttonTriangle" value="HONORS & AWARDS" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="small buttonTriangle" value="SOLO EXHIBITIONS" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="small buttonTriangle" value="COLLECTIVE EXHIBITIONS" />
							</div>
							<div class="bottomSpacer">
								<input type="button" class="small buttonTriangle" value="COLLECTIONS" />
							</div>
							
						</div>

						<div class="col-lg-6 col-12">

							<?php
								//Awards
								$query="SELECT * FROM `artist_awards` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `id` DESC";
								$result=runQuery($query);
								if(numRows($result)>0){
									echo'<div id="awards" class="hidden">';
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

						</div>

						<div class="col-lg-6 col-12">
								<?php
									$query="SELECT * FROM `artist_collections` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `id` DESC";
									$result=runQuery($query);
									if(numRows($result)>0){
										echo'<div id="collection" class="">';
											while($row=fetchArray($result)){
												foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}
												echo "<td>";
												if($day!=0){echo $day."-";}
												if($month!=0){echo $month."-";}
												if($year!=0){echo $year;}
										echo "</td>";	
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
								<?php
								    
								?>

								
						</div>
						
					</div>
						<!--Section2-->
		<?php 
			$query="SELECT `image` as `galleryImage` FROM `artist_images` WHERE `artist_id`='".@$artist_id."' AND `status`='1' ORDER BY `listorder` ASC";
			$result=runQuery($query);
			if(numRows($result)>0){
		?>

			<div class="section" id="section2">

				<div class="content">
					<div class="topSpacerBigger big proximaSb mainTitle gallery-slide "><span>SPREADS</span><div class="redLine"></div></div>
				</div>
					
				<div class="topSpacerBig swiper" id="swiperPublications">

					<div class="swiper-wrapper">
						<?php 
							$counter=1;
							while($row=fetchArray($result)){
								foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
								
								echo'<div class="swiper-slide thumb-slide whiteBg clickable gallery-slide " style="width:180px;" counter="'.$counter.'">
									<img src="artists/images/'.$galleryImage.'" />
								</div>';
								
								$counter++;
							}
						?>
					</div>

					<div class="swiper-button-next swiper1Btn"></div>
					<div class="swiper-button-prev swiper1Btn"></div>
					
				</div>

			</div>

		<?php }?>

		<div class="topSpacerBigger">&nbsp;</div>
		<div class="topSpacerBigger">&nbsp;</div>			
					

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





		// function fixImages(){
		// 	var $masonryContainer = $('#masonry-container');
		// 	$masonryContainer.masonry({
		// 		itemSelector: '.masonry-item',
		// 		columnWidth: '.masonry-item',
		// 		gutter: 20, // Adjust the space between columns
		// 		fitWidth: true // Set to true for a fluid-width container
		// 	});
		// }

		// $(window).resize(function(){
		// 	fixImages();
		// });

		// $(window).on('load', function() {
		// 	fixImages();
		// });
		

	function setGallerySwiper(counter){
		
		var windowWidth=$(window).width();
		var windowHeight=$(window).height();
		
		$(".gallery-slide").each(function(){
			var imageWidth=$(this).find("img").width();
			$(this).width(imageWidth);
			if(windowWidth>=900){
				// $(this).find("img").width((imageWidth*0.65));
				$(this).find("img").height((windowHeight*0.8));
				$(this).find("img").css('margin-top','5%');
			}else{
				$(this).find("img").width((imageWidth*0.80));
				$(this).find("img").css('margin-top','165px');
			}
		})

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
	}

	function setPublicationsSwiper(){

		$(".thumb-slide").each(function(){
			var imageWidth=$(this).find("img").width();
			$(this).width(imageWidth);
		})

		var swiperPublications = new Swiper('#swiperPublications', {
			slidesPerView: "auto",
			spaceBetween: 30,
			centeredSlides: true,
			loop: true,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
		});

		$(".thumb-slide").click(function(){
			var counter=$(this).attr("counter");
			$("#popupGallery").removeClass("hidden");
			setGallerySwiper(counter);
			$(".swiper1Btn").addClass("hidden");
		});
		
	}

	$(window).load(function(){
		setPublicationsSwiper();
	});

	$(document).ready(function(){

		$("#popupGallery").find(".closeBtn").click(function(){
			$("#popupGallery").addClass("hidden");
			$(".swiper1Btn").removeClass("hidden");
		});

	});





	</>


<?php
	include ("../includes/bottom.php");
?>

