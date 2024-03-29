<?php
	@$PAGE_TITLE="Artists | LT Gallery";
	@$CURRENT_SECTION="ARTISTS";
	include ("../includes/top.php");
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="artists">

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
								$tmp_name=str_replace("-","_",$tmp_name);
								$tmp_name=str_replace("&","and",$tmp_name);
								$url=$tmp_name."-".$id;
								echo'<div class="topSpacerSmall">
									<a href="artist/'.$url.'" class="black filterBtn tiny">'.$name.'</a>
								</div>';
							}
						}
					?>
				</div>
				
				<div class="col2">

					<div class="">
						<?php 
							$query="SELECT * FROM `artists` WHERE `status`='1' ORDER BY `name` ASC ";

							$result=runQuery($query);
							
							if(numRows($result)>0){
								
								echo'<div class="masonry-container" id="masonry-container">';

									while($row=fetchArray($result)){
										foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
										$tmp_name=str_replace(" ","_",$name);
										$tmp_name=str_replace("-","_",$tmp_name);
										$tmp_name=str_replace("&","and",$tmp_name);
										$url=$tmp_name."-".$id;
		
										echo'<div class="masonry-item-artist topSpacerSmaller">
											<a href="artist/'.$url.'">
												<div class="artist">
													<img src="artists/images/'.$image.'" width="100%" />
													<div class="name tiny black hidden">'.$name.'</div>
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
			var windowWidth=$(window).width();
			if(windowWidth>=900){
				var $masonryContainer = $('#masonry-container');
				$masonryContainer.masonry({
					itemSelector: '.masonry-item-artist',
					columnWidth: '.masonry-item-artist',
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

			$(".artist").hover(function(){
				$(this).find(".name").removeClass("hidden");
			},function(){
				$(this).find(".name").addClass("hidden");
			});
		});

	</script>


<?php
	include ("../includes/bottom.php");
?>

