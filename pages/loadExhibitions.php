<?php

	@extract(@$_POST);

	include("../global/global.php");

	$year=sanitizeInput($year);
	$limit=sanitizeInput($limit);
	$offset=sanitizeInput($offset);
	
	$query="SELECT * FROM `exhibitions` WHERE `from_year`='".$year."' AND `status`='1' ORDER BY `from_year` DESC , `from_month` DESC , `from_day` DESC LIMIT $offset , $limit ";

	$result=runQuery($query); 

	$rows=numRows($result);

	$current_year=date('Y');

	if($rows==0 && $year==$current_year && $offset==0){

		$query="SELECT * FROM `exhibitions`  WHERE `status`='1' ORDER BY `from_year` DESC , `from_month` DESC , `from_day` DESC LIMIT $offset , $limit ";
		$result=runQuery($query); 

		$rows=numRows($result);
	}

	if($rows>0){

		echo'<div class="row" id="exhibitions">';

			$i=0;

			while($row=fetchArray($result)){
				foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	
				if(@$artists_id!=""){
					$artists_id=json_decode($artists_id);
				}
				else{
					@$artists_id=[];
				}
				
				$from_date=$from_day."-".$from_month."-".$from_year;
				$from_date=date('d M Y',strtotime($from_date));

				$to_date=$to_day."-".$to_month."-".$to_year;
				$to_date=date('d M Y',strtotime($to_date));

				$date1 = new DateTime($from_date);
				$date2 = new DateTime($to_date);
				$days  = $date2->diff($date1)->format('%a');
				$tmpWidth=(($days*100)/42)*0.45;

				$tmp_title=str_replace(" ","_",$title);
				$tmp_title=str_replace("-","_",$tmp_title);
				$tmp_title=str_replace("&","and",$tmp_title);
				$url=$tmp_title."-".$id;
								
				echo'<div class="col-lg-6 col-12" days='.$days.'>
					<div class="exhibition bottomSpacerBigger">
						<a href="exhibition/'.$url.'">
							<div class="blackBg"><img src="exhibitions/images/'.@$image.'" width="100%" /></div>
						</a>
						<div class="topSpacer tiny black">
							<div class="floatLeft gilroyLight">'.$from_date.'</div>
							<div class="floatLeft leftSpacer rightSpacer dateLine blackBg" style="width:'.$tmpWidth.'%;"></div>
							<div class="floatLeft gilroyLight">'.$to_date.'</div>
							<div class="clear"></div>
						</div>
						<div class="topSpacerSmall small black gilroyMedium">
							<a class="medium blackGrey" href="exhibition/'.$url.'">'.$title.'</a>
						</div>
						<div class="topSpacerSmall small black">';
							if($artists_id !== null && is_array($artists_id) && count(@$artists_id)>1){echo'Resident Artists';}
							else if(isset($artists_id[0])){echo getArtistName(@$artists_id[0]);}
						echo'</div>
						<div class="topSpacerSmall tiny black">'.truncate($text,130,"...").'</div>
					</div>
				</div>';
				
				$i++;

				if($i%2==0){
					echo'<div class="clear"></div>';
				}
				
			}
		echo'</div>';
	}

?>
