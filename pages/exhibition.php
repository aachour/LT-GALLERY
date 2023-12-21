<?php
	@$PAGE_TITLE="EXHIBITION | LT GALLERY";
	@$CURRENT_SECTION="EXHIBITION";
	include ("../includes/top.php");

	@extract(@$_GET);

	$args=explode("-",sanitizeInput($args));
	$title=@$args[0];
	$exhibition_id=@$args[1];

	if(!isset($exhibition_id) || $exhibition_id==""){
		echo "<meta http-equiv='refresh' content='0;url=exhibitions/'>";
		die();
	}	

	$query="SELECT * FROM `exhibitions` WHERE `id`='".$exhibition_id."' AND `status`='1' ";
	$result=runQuery($query);

	if(numRows($result)==1){
		$row=fetchArray($result);
		foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	

		if(@$artists_id!="null"){
			@$artists_id=json_decode($artists_id,true);
		}else{
			@$artists_id=[];
		}


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
					$query="SELECT `image` as `galleryImage` FROM `exhibition_images` WHERE `exhibition_id`='".@$exhibition_id."' AND `status`='1' ORDER BY `listorder` ASC";
					$result=runQuery($query);
					if(numRows($result)>0){
						while($row=fetchArray($result)){
							foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
							echo'<div class="swiper-slide gallery-slide textCenter">
								<img src="exhibitions/images/'.$galleryImage.'" />
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
					<div class="medium gilroyMedium black"><?php echo $title; ?></div>
					<div class="topSpacer tiny black bold filterBtn clickable" type="1">Details&nbsp;&nbsp;<img src="static/images/rectangle.svg" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="2">Artists&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
					<div class="topSpacerSmall tiny black filterBtn clickable" type="3">Gallery&nbsp;&nbsp;<img src="static/images/rectangle.svg" class="hidden" /></div>
				</div>
				
				<div class="col2">

					<div class="bottomSpacer">
						<img src="exhibitions/images/<?php echo $image; ?>" width="100%" />
					</div>
					
					<div class="row">

						<div class="col-lg-6 col-12">

							<?php if($file!=""){?>
							<div class="topSpacer">
								<a href="exhibitions/files/<?php echo $file; ?>" target="_blank">
									<input type="button" value="Download Press File" class="buttonTriangle small black" />
								</a>
							</div>
							<?php }?>

							<?php 
								if(count($artists_id)>0){
									echo'<div class="topSpacer">
										<input type="button" value="View Available Artworks" class="buttonTriangle small black" />
									</div>';
									foreach($artists_id as $artist_id){
										echo'<a href="" class="blackGrey tiny">
											<div class="topSpacerSmall">'.getArtistName($artist_id).'</div>
										</a>';	
									}
								}
							?>

						</div>
						
						<div class="col-lg-6 col-12">
							<div class="topSpacer tiny black"><?php echo sanitizeInput($text,"HTML");?></div>
						</div>
						
					</div>

					<!--Gallery-->
					<div class="topSpacerBigger">
						<?php 
							$query="SELECT * FROM `exhibition_images` WHERE `exhibition_id`='".$exhibition_id."' AND `status`='1' ORDER BY `listorder` ASC ";
							$result=runQuery($query);
							
							if(numRows($result)>0){
								echo'<div class="masonry-container" id="masonry-container">';
									$i=1;
									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										echo'<div class="masonry-item thumb-image topSpacerSmaller clickable" counter="'.$i.'">
											<img src="exhibitions/images/'.$image.'" width="100%" />
										</div>';
										$i++;
									}
								echo'</div>';
							}
						?>
					</div>

				</div>

				<div class="clear"></div>

			</div>
			
		</div>

		<div class="topSpacerBig">&nbsp;</div>
		
	</div>


	<script>
			// galley slide show
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
		
			if(windowWidth>=900){
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

		// end of slidesow iamges  
		function fixImages(){
			var windowWidth=$(window).width();
			if(windowWidth>=900){
				var $masonryContainer = $('#masonry-container');
				$masonryContainer.masonry({
					itemSelector: '.masonry-item',
					columnWidth: '.masonry-item',
					gutter: 20, // Adjust the space between columns
					fitWidth: true // Set to true for a fluid-width container
				});
			}
		}

		$(window).resize(function(){
			fixImages();
		});

		$(window).on('load', function() {
			fixImages();
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

