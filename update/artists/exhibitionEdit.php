<?php
	$pageTitle = 'EXHIBITION';
	$section = 'ARTISTS';
	$table='artist_exhibitions';
    $folder='../../exhibitions/';

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

            if(@$error==''){
                if($type==1 && isEmpty($exhibition_id)){
                    $error="Please fill all required fields";
                }
                else if($type==2 && (isEmpty($category_id) || isEmpty($year) || isEmpty($title))){
                    $error="Please fill all required fields";
                }

                if(@$error==""){

                    if(!isEmpty($entryId)){
                        $query="UPDATE `".$table."` SET 
                        `type`='".sanitizeInput(@$type,"HTML")."',
                        `exhibition_id`='".sanitizeInput(@$exhibition_id)."',
                        `category_id`='".sanitizeInput(@$category_id,"HTML")."',
                        `year`='".sanitizeInput($year,"HTML")."',
                        `title`='".sanitizeInput(@$title,"HTML")."',
                        `link`='".sanitizeInput(@$link,"HTML")."',
                        `venue`='".sanitizeInput(@$venue,"HTML")."',
                        `city`='".sanitizeInput(@$city,"HTML")."',
                        `country_id`='".sanitizeInput($country_id,"HTML")."',
                       `dateedit`=NOW()
                        WHERE `id`=".$entryId;
                    }
                    else{
                        $query="INSERT INTO `".$table."` ( `artist_id` , `type`, `exhibition_id` , `category_id` , `year`, `title` , `link` , `venue`, `city`, `country_id` , `datesubmit` , `status`)
                            VALUE(
                            '".sanitizeInput(@$artistId)."', 
                            '".sanitizeInput(@$type,"HTML")."' , 
                            '".sanitizeInput(@$exhibition_id)."' ,
                            '".sanitizeInput(@$category_id)."' ,
                            '".sanitizeInput(@$year,"HTML")."' , 
                            '".sanitizeInput(@$title,"HTML")."' , 
                            '".sanitizeInput(@$link,"HTML")."' ,
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
                        echo "<meta http-equiv='refresh' content='2;url=exhibitions.php?artistid=".$artistId."'>";
                    }else{
                        $error="<br  />Could not save . Please try again.<br  />";
                        $prompt=1;
                    }
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
                    <td width="150px">Type <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td width="600px">
                        <input type="radio" class="typeRBtn" name="type" value="1" <?php if(@$type=="" || @$type=="1"){echo "checked";}?> />&nbsp;LT Exhibitions
                        &nbsp;&nbsp;&nbsp;
                        <input type="radio" class="typeRBtn" name="type" value="2" <?php if(@$type=="2"){echo "checked";}?> />&nbsp;External Exhibitions
                    </td>
                </tr>

                <tr height="20px" class="internal"></tr>
                <tr class="internal">
                    <td>Exhibitions <sup class="red">*</sup></td>
                    <td width="20px"></td> 
                    <td>
                        <select id="exhibition_id" name="exhibition_id">
                            <option value=""></option>
                            <?php
                                $query2 = "SELECT `id` as `exhibitionId`, `title` as `exhibitionTitle` FROM `exhibitions` WHERE `status`='1' ORDER BY `id` DESC";
                                $result2 = runQuery($query2);
                                if (numRows($result2) > 0) {
                                    while ($row2 = fetchArray($result2)) {
                                        foreach ($row2 as $key => $item) {$$key = stripslashes($row2[$key]);}
                                        $selected = "";
                                        if($exhibitionId==@$exhibition_id){$selected="selected";}
                                        echo '<option value="' . $exhibitionId . '" ' . $selected . '>' . $exhibitionTitle . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>Category <sup class="red">*</sup></td>
                    <td width="20px"></td> 
                    <td>
                        <select id="category_id" name="category_id">
                            <option value=""></option>
                            <?php
                                $query2="SELECT `id` as `categoryId` , `name` as `categoryName`  FROM `categories`" ;
                                $result2=runQuery($query2);
                                if(numRows($result2)>0){
                                    while($row2=fetchArray($result2)){
                                        foreach($row2 as $key => $item){$$key=stripslashes($row2[$key]);}
                                        $selected="";
                                        if(@$categoryId==@$category_id){$selected="selected";}
                                        echo'<option value="'.$categoryId.'" '.$selected.'>'.$categoryName.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr height="20px" class="external"></tr> 
                <tr class="external">
                    <td width="150px">Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td width="700px"><?php echoTextField("title", @$title,"ckeditor"); ?></td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>link</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("link", @$link,"ckeditor"); ?></td>
                </tr>
 
                <tr height="20px" class="external"></tr> 
                <tr class="external">
                    <td>Year <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoYearDropDown("year", @$year, $temp+3, 1950,"date","width:250px;");
                        ?>
                    </td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>venue</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("venue", @$venue,"ckeditor"); ?></td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>City</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("city", @$city,"ckeditor"); ?></td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
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
                        <input onclick="window.location='exhibitions.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button' />
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

