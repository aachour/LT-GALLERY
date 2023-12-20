<?php

	@extract(@$_POST);

	include("../global/global.php");

	$type=sanitizeInput($type);
	$limit=sanitizeInput($limit);
	$offset=sanitizeInput($offset);

	if($type==1){$from_year=date('Y')+1;}
	else if($type==2){$from_year=date('Y');}
	else if($type==3){$from_year=date('Y')-1;}
	else if($type==4){$from_year=date('Y')-2;}
	
	if($type!=4){
		$query="SELECT * FROM `exhibitions` WHERE `from_year`='".$from_year."' AND `status`='1' ORDER BY `from_year` , `from_month` , `from_day` DESC LIMIT $offset , $limit ";
	}else{
		$query="SELECT * FROM `exhibitions` WHERE `from_year`<='".$from_year."' AND `status`='1' ORDER BY `from_year` , `from_month` , `from_day` DESC LIMIT $offset , $limit ";
	}

	$result=runQuery($query); 

	if(numRows($result)>0){

		echo'<div class="row" id="exhibitions">';

			while($row=fetchArray($result)){
				foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}	

				$artists_id=json_decode($artists_id);
				
				$from_date=$from_day."-".$from_month."-".$from_year;
				$from_date=date('d M Y',strtotime($from_date));

				$to_date=$to_day."-".$to_month."-".$to_year;
				$to_date=date('d M Y',strtotime($to_date));

				$date1 = new DateTime($from_date);
				$date2 = new DateTime($to_date);
				$days  = $date2->diff($date1)->format('%a');
				$tmpWidth=(($days*100)/365)*0.45;

				$tmp_title=str_replace(" ","_",$title);
				$tmp_title=str_replace("-","_",$tmp_title);
				$tmp_title=str_replace("&","and",$tmp_title);
				$url=$tmp_title."-".$id;
				
				
				echo'<div class="exhibition bottomSpacer col-lg-6 col-12">
					<a href="exhibition/'.$url.'">
						<div><img src="exhibitions/images/'.@$image.'" width="100%" /></div>
					</a>
					<div class="topSpacer tiny black">
						<div class="floatLeft gilroyLight">'.$from_date.'</div>
						<div class="floatLeft leftSpacer rightSpacer dateLine blackBg" style="width:'.$tmpWidth.'%;"></div>
						<div class="floatLeft gilroyLight">'.$to_date.'</div>
						<div class="clear"></div>
					</div>
					<div class="topSpacerSmall small black gilroyMedium">
						<a class="small blackGrey" href="exhibition/'.$url.'">'.$title.'</a>
					</div>
					<div class="topSpacerSmall small black">';
						if(count($artists_id)>1){echo'Resident Artists';}
						else{echo getArtistName(@$artists_id[0]);}
					echo'</div>
					<div class="topSpacerSmall tiny black">'.truncate($text,130,"...").'</div>
				</div>';
				
			}
		echo'</div>';
	}

?>
