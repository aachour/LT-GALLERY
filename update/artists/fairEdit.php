<?php
	$pageTitle = 'FAIRS';
	$section = 'FAIRS';
	$table='artist_fairs';
    $folder='../../artist_fairs/';

	include('../top.php');

    include("../cropImage/index.html");
  
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

            if(isEmpty($title) ){
                $error="Please fill required filed";
            }

            if(@$error==""){

                if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET 
                    `title`='".sanitizeInput(@$title,"HTML")."',
                    `link`='".sanitizeInput(@$link,"HTML")."',
                    `year`='".sanitizeInput($year,"HTML")."',
                    `venue`='".sanitizeInput(@$venue,"HTML")."',
                    `city`='".sanitizeInput(@$city,"HTML")."',
                    `country_id`='".sanitizeInput($country_id,"HTML")."',
                    `dateedit`=NOW()
                    WHERE `id`=".$entryId;
                }
                else{
                    $query="INSERT INTO `".$table."` ( `artist_id` , `title` , `link` , `year`, `venue`, `city`, `country_id` , `datesubmit` , `status`)
                        VALUE(
                        '".sanitizeInput(@$artistId)."', 
                        '".sanitizeInput(@$title,"HTML")."' , 
                        '".sanitizeInput(@$link,"HTML")."' ,
                        '".sanitizeInput(@$year,"HTML")."' , 
                        '".sanitizeInput(@$venue,"HTML")."' , 
                        '".sanitizeInput(@$city,"HTML")."' , 
                        '".sanitizeInput(@$country_id,"HTML")."', 
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
                    echo "<meta http-equiv='refresh' content='2;url=fairs.php?artistid=".$artistId."'>";
                }else{
                    $error="<br  />Could not save . Please try again.<br  />";
                    $prompt=1;
                }
            }

            
        } else{
            $prompt=1;
        }

        if(@$error){echo "<p class='error'>".$error."<br /></p><br /><br />";}
        if(@$msg){echo "<p class='msg'>".$msg."<br /></p><br /><br /><br /><br /><br /><br /><br /><br />";}

        if($prompt==1){
            if(isset($entryId) && $entryId != ''){
                $query='SELECT * FROM `'.$table.'` WHERE `id`='.$entryId;
                $result=runQuery($query);
                $row=fetchArray($result);
                foreach($row as $key => $item){$$key=stripslashes($row[$key]);}
            }
        ?>

        <form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data" >
                
            <table cellpadding="0" cellspacing="0" class="prompt small">
                
                <tr>
                    <td width="150px">Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td width="700px"><?php echoTextField("title", @$title,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>link</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("link", @$link,"ckeditor"); ?></td>
                </tr>
 
                <tr height="20px"></tr> 
                <tr>
                    <td>Year</td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoYearDropDown("year", @$year, $temp+3, 1950,"date","width:250px;");
                        ?>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>venue</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("venue", @$venue,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>City</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("city", @$city,"ckeditor"); ?></td>
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
                        <input onclick="window.location='fairs.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button' />
                    </td>
                </tr>              

            </table>

        </form>

        <?php } ?>

    </div>

</div>


<script>
    
    function showHideSections(type){
        if(type=="1"){
            $(".internal").show();
            $(".external").hide();
            $("#category_id,#title,#link,#year,#venue,#city,#country_id").val("");
        }else if(type=="2"){
            $(".internal").hide();
            $(".external").show();
            $("#exhibition_id").val("");
        }
    }

    $(document).ready(function(){

        var type=$(".typeRBtn:checked").val();
        showHideSections(type);

        $(".typeRBtn").click(function(){
            var type=$(this).val();
            showHideSections(type);
        });
        
    });
</script>

<?php include("../bottom.php"); ?>

