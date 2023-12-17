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
							$query="SELECT * FROM `artist_images` WHERE `artist_id`='".$artist_id."' AND `status`='1' ORDER BY `listorder` ASC ";
							$result=runQuery($query);
							
							if(numRows($result)>0){
								echo'<div class="masonry-container" id="masonry-container">';
									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										echo'<div class="masonry-item topSpacerSmaller">
											<img src="artists/images/'.$image.'" width="100%" />
										</div>';
									}
								echo'</div>';
							}
						?>
					</div>

					<!--Gallery-->
					<div class="topSpacerBigger row">
						
						<div class="col-lg-6 col-12">
							<div class="topSpacer">
								<input type="button" class="small buttonTriangle" value="HONORS & AWARDS" />
							</div>
							<div class="topSpacerSmall">
								<input type="button" class="small buttonTriangle" value="SOLO EXHIBITIONS" />
							</div>
							<div class="topSpacerSmall">
								<input type="button" class="small buttonTriangle" value="COLLECTIVE EXHIBITIONS" />
							</div>
							<div class="topSpacerSmall">
								<input type="button" class="small buttonTriangle" value="COLLECTIONS" />
							</div>
							
						</div>

						<div class="col-lg-6 col-12">

						</div>
						
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

