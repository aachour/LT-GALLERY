<?php
$pageTitle = 'AWARDS ';
$section = 'AWARDS';
$table='artists_awards';
$folder='../../artists/';

	include('../top.php');
    
    include("../cropImage/index.html");
	$prompt=1;
	extract($_POST);
	extract($_GET);
	@$entryId=sanitizeInput($id);
	$error='';

	handleFileDelete();
?>


<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>

    <div id="middle" style="position:relative; width:100%; padding:50px 0px; background:#FFF;">
    

        <div class="content">
        
        
        <p class='medium blue underline'><?php echo $pageTitle;?></p><br /><br />
           
         <?php

                        if(@$save){
                            
                        if(isEmpty($name) || isEmpty($text) || isEmpty($image)){
                            $error="Please fill all required fields";
                        }
                        
                        if(@$error==''){

                            if(!isEmpty($entryId)){
                                $query="UPDATE `".$table."` SET
                            `title`='".sanitizeInput($artists_id,"HTML")."',
                            `text`='".sanitizeInput($years,"HTML")."',
                            `image`='".sanitizeInput($text,"HTML")."',
                            `link`='".sanitizeInput($link,"HTML")."',
                            `dateedit`=NOW()
                            WHERE `id`=".$entryId;
                            }
                            else{
                                $query="INSERT INTO `".$table."` (`artists_id` , `years` , `text` , `link` )
                                VALUES( '".sanitizeInput($artists_id,"HTML")."' , 
                                        '".sanitizeInput(@$years,"HTML")."' , 
                                        '".sanitizeInput(@$text,"HTML")."' , 
                                        '".sanitizeInput(@$link,"HTML"). "' 
                                        )";
                            }
                            
                            if(runQuery($query)){
                                if(isEmpty($entryId)){
                                    $entryId=insertedId();
                                }
                                $msg="<br />Entry saved.<br />";
                                $prompt=0;
                                echo "<meta http-equiv='refresh' content='2;url=index_awards.php'>";
                            }else{
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
                            $artists_id=json_decode($artists_id);
                        }
                ?>



        <from action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">
             <table cellpadding="0" cellspacing="0" class="prompt small">

            
           
            <tr>
                <td>Text <sup class='red'>*</sup></td>
                <td width="20px"></td>
                <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
            </tr>
            <tr heght="20px"></tr>
            <tr>
                <td>YEARS<sup class='red'>*</sup></td>
                <td width="20px"></td>
                <td><?php echoTextField("years", @$years,"ckeditor"); ?></td>
            </tr>
            <tr height="20px"></tr>
            <tr>
                <td>LINK<sup class='red'>*</sup></td>
                <td width="20px"></td>
                <td><?php echoTextField("link", @$link,"ckeditor"); ?></td>
            </tr>
            <tr height="30px"></tr>
            <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if(isset($entryId)){?>
                            <input type='hidden' name='id' value='<?php echo $entryId; ?>'/>
                        <?php } ?>
                        <input type='hidden' name='artistid' value='<?php echo $artistId; ?>'/>
                        <input name='save' class='submit' value='Save' type='submit'/>
                        <input onclick="window.location='index_awards.php'" class='submit' value='Cancel' type='Button'/>
                    </td>
                </tr>
            </table>

        </from>

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

