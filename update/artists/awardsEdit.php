<?php
$pageTitle = 'AWARDS ';
$section = 'ARTISTS';
$table='artist_awards';
$folder='../../artists/';

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
                    
                if(isEmpty($years) || isEmpty($text)){

                    $error="Please fill all required fields";
                }
                
                if(@$error==''){

                    if(!isEmpty($entryId)){
                        $query="UPDATE `".$table."` SET
                        `artist_id`='".sanitizeInput(@$artistId)."',
                        `years`='".sanitizeInput($years,"HTML")."',
                        `text`='".sanitizeInput($text,"HTML")."',
                        `link`='".sanitizeInput($link,"HTML")."',
                        `dateedit`=NOW()
                        WHERE `id`=".$entryId;
                    }
                    else{
                        $query="INSERT INTO `".$table."` ( `artist_id` ,`years` , `text` , `link` ,`status` )
                        VALUES( '".sanitizeInput(@$artistId)."',
                                '".sanitizeInput(@$years,"HTML")."' , 
                                '".sanitizeInput(@$text,"HTML")."' , 
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
                        echo "<meta http-equiv='refresh' content='2;url= awardsindex.php?artistid=".@$artistId."'>";
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
                    $artists_id=json_decode(@$artistsid);
                }
        ?>


        <form action=" <?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing="0" class="prompt small">

                <tr>
                    <td>Text <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
                </tr>
                
                <tr height="20px"></tr>
                <tr>
                    <td>YEARS<sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("years", @$years,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>LINK</td>
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
                        <input type='hidden' name='artistid' value='<?php echo $artistId; ?>' />
                        <input name='save' class='submit' value='Save' type='submit'/>
                        <input onclick="window.location='awardsindex.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button'/>
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

