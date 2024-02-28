<?php
	@$PAGE_TITLE="News | LT Gallery";
	@$CURRENT_SECTION="NEWS";

	include ("../includes/top.php");
		
	// $query="SELECT * FROM `news` WHERE `status`='1' ORDER BY `id` DESC LIMIT 0,1";
	// $result=runQuery($query);
	// if(numRows($result)==1){
	// 	$row=fetchArray($result);
	// 	foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
	// 	$date=$day."-".$month."-".$year;
    //     $date=date('d-m-Y',strtotime(@$date));
	// }
?>

<div  class="fullContainer" id="news">

    <!--Section1-->
	<div class="section" id="section1">

        <div class="content">

            <div class="col1">

                <div class="medium black gilroyMedium">NEWS</div>
            </div>

            <div class="col2">
         
				<!-- <div class="row">

					<div class=" col-lg-6 col-12 ">
						
						<div class="small black gilroyLight"><?php echo $date; ?></div>

						<a href="">
							<div class="topSpacer big black gilroyMedium clickable"><?php echo @$title;?></div>
						</a>
							
						<div class="topSpacer medium black gilroyMedium "><?php echo @$author;?></div>	

						<div class="topSpacer col-lg-5 col-12 ">
							<img class="topSpacer" src="news/images/<?php echo @$image;?>" width ="100%" />
						</div>  
						
						<?php if($link!=""){?>
						<div class="topSpacerBigger ">
							<a href="<?php echo $link; ?>" target="_blank">
								<input type="button" value="Go to Article" class="buttonTriangle small black" />
							</a>
						</div>
						<?php }?>

					</div>	

					</div>

				<div class="topSpacerBig">&nbsp;</div> -->

                <?php 
					$query="SELECT * FROM `news` WHERE  `status`='1' ORDER BY `year` DESC , `month` DESC , `day` DESC";
					$result=runQuery($query);
					if(numRows($result)>0){
						while($row=fetchArray($result)){
							foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
							$date=$day."-".$month."-".$year;
					        $date=date('d-M-Y',strtotime(@$date));
							echo'<div class="bottomSpacerBig article" status="0">
								<div class="title">
									<div class="tiny black gilroyLight">'.$date.'</div>
									<div class="topSpacerSmaller">
										<div class="floatLeft medium gilroyMedium">';
											if($link!=""){echo'<a class="blackGrey gilroyMedium" href="'.$link.'" target="_blank">';}
											echo @$title;
											if($link!=""){echo'</a>';}
										echo'</div>
										<div class="floatRight">	
											<img src="static/images/triangle-right-big.png" width="25px"></div>
										<div class="clear"></div>
									</div>
									<div class="topSpacerSmaller small black gilroyLight">'.$author.'</div>
									<div class="topSpacerSmall text tiny black">'.sanitizeInput(@$text,"HTML").'</div>
								</div>
							</div>';
						}
					}
				?>

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
