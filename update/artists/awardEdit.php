<?php
$pageTitle = 'AWARDS ';
$section = 'ARTISTS';
$table='artist_awards';
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
                    
                if(isEmpty($year) || isEmpty(@$title)){

                    $error="Please fill all required fields";
                }
                
                if(@$error==''){

                    if(!isEmpty($entryId)){
                        $query="UPDATE `".$table."` SET
                        `artist_id`='".sanitizeInput(@$artistId)."',
                        `year`='".sanitizeInput(@$year,"HTML")."',
                        `city`='".sanitizeInput($city,"HTML")."',
                        `country_id`='".sanitizeInput($country_id,"HTML")."',
                        `title`='".sanitizeInput($title,"HTML")."',
                        `link`='".sanitizeInput($link,"HTML")."',
                        `dateedit`=NOW()
                        WHERE `id`=".$entryId;
                    }
                    else{
                        $query="INSERT INTO `".$table."` ( `artist_id` , `year` , `city` , `country_id`, `title` , `link` , `status` )
                        VALUES( '".sanitizeInput(@$artistId)."',
                                '".sanitizeInput(@$year,"HTML")."' , 
                                '".sanitizeInput(@$city,"HTML"). "' ,
                                '".sanitizeInput(@$country_id,"HTML"). "' ,
                                '".sanitizeInput(@$title,"HTML")."' , 
                                '".sanitizeInput(@$link,"HTML"). "' ,
                                '1'
                            )";
                    }
                    
                    if(runQuery($query)){
                        if(isEmpty($entryId)){
                            $entryId=insertedId();
                        }
                        $msg="<br />Entry saved.<br />";
                        $prompt=0;
                        echo "<meta http-equiv='refresh' content='2;url= awards.php?artistid=".@$artistId."'>";
                    } 
                    else{
                        $error="<br />Could not save entry. Please try again.<br />";
                        $prompt=1;
                    }
                }
            }
            else{
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


        <form action=" <?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing="0" class="prompt small">

                <tr>
                    <td>Year <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoYearDropDown("year", @$year, $temp+3, $temp-5,"date","width:250px;");
                        ?>
                    </td>
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

                <tr height="20px"></tr>
                <tr>
                    <td width="150px">Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td width="700px"><?php echoTextField("title", @$title,"ckeditor"); ?></td>
                </tr>

                <tr height="30px"></tr>

                <tr>
                    <td>LINK</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("link", @$link,"ckeditor"); ?></td>
                </tr>

                

                <tr height="20px"></tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if(isset($entryId)){?>
                            <input type='hidden' name='id' value='<?php echo $entryId; ?>'/>
                        <?php } ?>
                        <input type='hidden' name='artistid' value='<?php echo $artistId; ?>' />
                        <input name='save' class='submit' value='Save' type='submit'/>
                        <input onclick="window.location='awards.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button'/>
                    </td>
                </tr>
            </table>

        </form>

        <?php } ?>


        </div>
    </div>

    <script>
    $(document).ready(function(){

        $("#imageDelete").click(function(){
            $("#imageTxt").val("");
            $("#image").val("");
            $("#imageViewDelete").addClass("hidden");
            $("#imageView").attr("href","");
        });

    });
</script>

<?php include("../bottom.php"); ?>

