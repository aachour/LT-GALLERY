<?php
	@$PAGE_TITLE="HOME | LT GALLERY";
	@$CURRENT_SECTION="HOME";
	include ("../includes/top.php");
?>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->

	<div class="fullContainer" id="home">

		<!--Section1-->
		<div class="section" id="section1" style="padding-top:0px !important;">
			<?php 
				$query="SELECT * FROM `top_banner` WHERE `id`='1' AND `status`='1'";
				$result=runQuery($query);
				if(numRows($result)==1){
					$row=fetchArray($result);
					foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
				}
			?>

			<img src="topbanner-images/images/<?php echo @$image;?>" class="onlyDesktop" width="100%" />

			<img src="topbanner-images/images/<?php echo @$image;?>" class="onlyMobile" height="250px" />

			<div class="cover">
				<div class="content onlyDesktop">
					<div class="proximaSb bigger black"><?php echo sanitizeInput(@$title,"HTML"); ?></div>
					<div class="topSpacerSmall big black halfText"><?php echo sanitizeInput(@$text,"HTML"); ?></div>
					<div class="topSpacer">
						<a href="<?php echo $link;?>">
							<input type="button" value="LEARN MORE" class="small blackRedBtn" />
						</a>
					</div>
				</div>
				<div class="content onlyMobile">
					<div class="proximaSb medium black"><?php echo sanitizeInput(@$title,"HTML"); ?></div>
					<div class="topSpacerSmall small black halfText"><?php echo sanitizeInput(@$text,"HTML"); ?></div>
					<div class="topSpacer">
						<a href="<?php echo $link;?>">
							<input type="button" value="LEARN MORE" class="small blackRedBtn" />
						</a>
					</div>
				</div>
			</div>

		</div>

		<div class="topSpacer">&nbsp;</div>

		<!--Section2-->
		<div class="section" id="section2">

			<div class="content">

				<div class="topSpacerBigger big proximaSb mainTitle"><span class="proximaSb">FORTHCOMING</span><div class="redLine"></div></div>

				<?php 
					$query="SELECT * FROM `publications` WHERE `type`='1' AND `status`='1' ORDER BY `listorder` ASC LIMIT 0,1";
					$result=runQuery($query);
					if(numRows($result)==1){
						$row=fetchArray($result);
						foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
						echo'<div class="row">
							<a href="book/'.$title.'_'.$id.'">
								<div class="topSpacerBig col-lg-3 col-12">
									<img src="publication-images/images/'.$image.'" width="100%" />
								</div>
							</a>
							<div class="topSpacerBig col-lg-4 col-12">
								<div class="details">
									<div class="topSpacer medium black proximaSb">'.$title.'</div>';
									if($created_by!=""){
										echo'<div class="topSpacerSmall tiny black">By '.$created_by.'</div>';
									}
									if($foreworded_by!=""){
										echo'<div class="tiny black">Foreword by '.$foreworded_by.'</div>';
									}
									if($edited_by!=""){
										echo'<div class="tiny black">Edited by '.$edited_by.'</div>';
									}
									echo'<div class="topSpacer small black proximaSb">'.$introduction.'</div>
									<a href="book/'.$title.'_'.$id.'">
										<input type="button" value="LEARN MORE" class="topSpacerSmaller tiny blackRedBtn" />
									</a>
								</div>
							</div>
							
						</div>';
					}
				?>

			</div>

		</div>
		
		<div class="topSpacer">&nbsp;</div>

		<!--Section3-->
		<div class="section" id="section3">

			<div class="content">

				<div class="topSpacerBigger big proximaSb mainTitle"><span class="proximaSb">PUBLICATIONS</span><div class="redLine"></div></div>

			</div>
				
			<div class="topSpacerBig swiper" id="swiperPublications">

				<div class="swiper-wrapper">
					<?php 
						$query="SELECT * FROM `publications` WHERE `status`='1' ORDER BY `listorder` ASC LIMIT 0,10";
						$result=runQuery($query);
						if(numRows($result)>0){
							while($row=fetchArray($result)){
								foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	

								$href="publication/".$title."_".$id;
								if($type==1){$href="book/".$title."_".$id;}
								
								echo'<div class="swiper-slide whiteBg" style="width:180px;">
									<a href="'.$href.'">
										<div><img src="publication-images/images/'.$image.'" width="100%" /></div>
									</a>
								</div>';
								
							}
						}
					?>
				</div>

				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
				
			</div>

			<div class="topSpacerBig textRight rightSpacerBig">
				<a href="publications/">
					<input type="button" value="VIEW ALL PUBLICATIONS" class="small blackRedBtn" />
				</a>
			</div>

		</div>


		<div class="topSpacerBig">&nbsp;</div>
		

	</div>

	<!------------------------------------------------------------------------------------------------->
	<!---------------------------------------------Middle---------------------------------------------->
	<!------------------------------------------------------------------------------------------------->


<?php
	include ("../includes/bottom.php");
?>

<script>

	function setPublicationsSwiper(){

		$(".swiper-slide").each(function(){
			var imageWidth=$(this).find("img").width();
			$(this).width(imageWidth);
		})

		var swiperPublications = new Swiper('#swiperPublications', {
			slidesPerView: "auto",
			spaceBetween: 30,
			loop: true,
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},
		});
	}

	$(window).load(function(){
		setPublicationsSwiper();
	});

</script>


