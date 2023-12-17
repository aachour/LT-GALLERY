<?php
	@$PAGE_TITLE="ARTISTS | LT GALLERY";
	@$CURRENT_SECTION="ARTISTS";
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
					<div class="medium gilroyMedium black">Artists</div>
					<?php 
						$query="SELECT * FROM `artists` WHERE `status`='1' ORDER BY `name` ASC ";
						$result=runQuery($query);
						if(numRows($result)>0){
							while($row=fetchArray($result)){
								foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
								$tmp_name=str_replace(" ","_",$name);
								$tmp_name=str_replace("&","and",$tmp_name);
								$tmp_name=str_replace("-","_",$tmp_name);
								$url=$tmp_name."-".$id;

								echo'<div class="topSpacerSmall">
									<a href="artist/'.$url.'" class="blackGrey tiny">'.$name.'</a>
								</div>';
							}
						}
					?>
				</div>
				
				<div class="col2">

					<div class="topSpacerBigger">
						<?php 
							$query="SELECT * FROM `artists` WHERE `status`='1' ORDER BY `name` ASC ";

							$result=runQuery($query);
							
							if(numRows($result)>0){
								echo'<div class="masonry-container" id="masonry-container">';
									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										$tmp_name=str_replace(" ","_",$name);
										$tmp_name=str_replace("&","and",$tmp_name);
										$url=$tmp_name."-".$id;

										echo'<div class="masonry-item-artist topSpacerSmaller">
											<a href="artist/'.$url.'">
												<div>
													<img src="artists/images/'.$image.'" width="100%" />
												</div>
											</a>
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
				itemSelector: '.masonry-item-artist',
				columnWidth: '.masonry-item-artist',
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

