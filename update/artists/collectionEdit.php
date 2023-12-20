<?php
	$pageTitle = 'COLLECTION';
	$section = 'ARTISTS';
	$table='artist_collections';
    $folder='../../artists/';

	include('../top.php');
  
	$prompt=1;
	extract($_POST);
	extract($_GET);

	@$entryId=sanitizeInput($id);
    @$artistId=sanitizeInput($artistid);
   
	$error='';

	handleFileDelete();
?>


<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>

        <div id="middle" style="position:relative; width:100%; padding:50px 0px; background:#FFF;">

                <div class="content">
                    <p class='medium blue underline'><?php echo $pageTitle;?></p><br /><br />

                    <?php
                     if(@$save){
                        if(isEmpty($name) ){
                            $error="Please fill required filed";
                        }
                        if(@$error==""){
                            if(!isEmpty($entryId)){
                                $query="UPDATE `".$table."` SET
                                `name`='".sanitizeInput(@$name,"HTML")."',
                                `location`='".sanitizeInput(@$location,"HTML")."',
                                `city`='".sanitizeInput(@$city,"HTML")."',
                                `country_id`='".sanitizeInput(@$country_id,"HTML")."',
                                `day`='".sanitizeInput(@$day,"HTML")."',
                                `month`='".sanitizeInput(@$month,"HTML")."',
                                `year`='".sanitizeInput(@$year,"HTML")."',
                                `dateedit`=NOW()
                                WHERE `id`=".$entryId;
                                }else{
                                    $query="INSERT INTO `".$table."` ( `name` ,`artist_id`, `location`, `city` , `country_id`, `day` , `month`, `year` , `datesubmit` , `status`)
                                            VALUE(
                                            '".sanitizeInput(@$name ,"HTML")."', 
                                            '".sanitizeInput(@$artistId)."', 
                                            '".sanitizeInput(@$location,"HTML")."' , 
                                            '".sanitizeInput(@$city,"HTML")."' ,
                                            '".sanitizeInput(@$country_id,"HTML")."' , 
                                            '".sanitizeInput(@$day,"HTML")."' ,
                                            '".sanitizeInput(@$month,"HTML")."' , 
                                            '".sanitizeInput(@$year,"HTML")."' ,
                                            NOW() , 
                                            '1'
                                        )";
                                    }

                                    if(runQuery($query)){
                                        if(isEmpty($entryId)){
                                            $entryId=insertedId();
                                        }
                                        $msg="<br />Entry saved.<br />";
                                        $prompt=0;
                                        echo "<meta http-equiv='refresh' content='2;url=collections.php?artistid=".@$artistId."'>";
                                    }else{
                                        $error="<br />Could not save entry. Please try again.<br />";
                                        $prompt=1;
                                    }

                        }
                        
                    }else{
                        $prompt=1;
                    }
                        if(@$erro){echo"<p class='error'>".$erro."<br  /></p><br  /><br  />";}
                        if(@$msg){echo "<p class='msg'>".$msg."<br /></p><br /><br /><br /><br /><br /><br /><br /><br />";}
                        
                        if($prompt==1){
                            if(isset($entryId) && $entryId != ''){
                                $query='SELECT * FROM `'.$table.'` WHERE `id`='.$entryId;
                                $result=runQuery($query);
                                $row=fetchArray($result);
                                foreach($row as $key => $item){$$key=stripcslashes($row[$key]);};

                            }
                    ?>

        <form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data" >
                        
                <table cellpadding="0" cellspacing="0" class="prompt small">

                <tr>
                <td width="150px">Name <sup class='red'>*</sup></td>
                    <td width="30px"></td>
                    <td width="800px"><?php echoTextField("name", @$name,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>

                <tr>
                    <td>location <sup class="red">*</sup></td>
                    <td width=20px""></td>
                    <td><?php echoTextField("location",@$location,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>

                <tr>
                    <td>city <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("city",@$city,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>

                <tr>
                <td>Country</td>
                    <td width="20px"></td> 
                    <td>
                    <select id="country_id" name="country_id">
                        <option value=""></option>
                        <?php
                            $query2="SELECT `id` as `countryId` , `name` as `countryName`  FROM `countries` WHERE `status`='1' ORDER BY `name` ASC" ;
                            $result2=runQuery($query2);
                            if(numRows($result2)>0){
                                while($row2=fetchArray($result2)){
                                    foreach($row2 as $key => $item){$$key=stripslashes($row2[$key]);}
                                    $selected="";
                                    if(@$countryId==@$country_id){$selected="selected";}
                                    echo'<option value="'.$countryId.'" '.$selected.'>'.$countryName.'</option>';
                                }
                            }
                        ?>
                    </select>

                    </td>
                </tr>
                <tr height="20px"></tr>
        		<tr>
                    <td>Date From <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoDayDropDown("day", @$day,"date","width:200px;");
                            echoMonthDropDown("month", @$month,"date","width:200px;");
                            echoYearDropDown("year", @$year, $temp+3, 1950,"date","width:200px;");
                        ?>
                    </td>
                </tr>
                <tr height="30px"></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if(isset($entryId)){?>
                            <input type='hidden' name='id' value='<?php echo $entryId; ?>' />
                        <?php } ?>
                        <input name='save' class='submit' value='Save' type='submit' />
                        <input type='hidden' name='artistid' value='<?php echo $artistId; ?>' />
                        <input onclick="window.location='collections.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button' />
                    </td>
                </tr>        


            </table>
        </form>      
            <?php }  ?>                 
        </div>
    </div>


<?php include("../bottom.php"); ?>

