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
									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										echo'<div class="masonry-item topSpacerSmaller">
											<img src="exhibitions/images/'.$image.'" width="100%" />
										</div>';
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
		});

		$(window).on('load', function() {
			fixImages();
		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

