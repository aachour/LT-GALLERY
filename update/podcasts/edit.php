<?php
	$pagetitle = 'PODCASTS';
	$section = 'PODCASTS';
	$table='podcast';
	

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

    <!-- content -->
    <div class="content">

        <p class='medium blue underline'><?php echo $pagetitle;?></p><br /><br />

        <?php
        if(@$save){
            if(isEmpty($title) || isEmpty($subtitle) || isEmpty($text) || isEmpty($image) ){
                $error="Please fill required filed";
            }
            if(@$error==''){
                if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `title`='".sanitizeInput($title,"HTML")."',
                    `subtitle`='".sanitizeInput($subtitle,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `image`='".sanitizeInput($image,"HTML")."',
                    `link`='".sanitizeInput(@$link,"HTML")."',
                    `dateedit`=NOW()
                    WHERE `id`='".@$entryId."'
                    ";
                    
                }else{
                    $query="INSERT INTO `".$table."`(`title` , `subtitle` , `text` , `image` , `link` , `datesubmit` , `status`)
                             VALUES( '".sanitizeInput($title,"HTML")."' ,
                                    '".sanitizeInput(@$subtitle,"HTML")."', 
                                    '".sanitizeInput(@$text,"HTML")."' , 
                                    '".sanitizeInput(@$image,"HTML")."' , 
                                    '".sanitizeInput(@$link,"HTML"). "',
                                    NOW(),
                                    '1'
                                )";
                    }



                if(runQuery($query)){
                    if(isEmpty($entryId)){
                        $entryId=insertedId();
                    }
                    $msg="<br />Entry saved.<br />";
                    $prompt=0;
					echo "<meta http-equiv='refresh' content='2;url=index.php'>";
                }else{
                    $error="<br />Could not save entry. Please try again.<br />";
                    $prompt=1;
                }
            }
            
        }
        else{
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

        <form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>title <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("title",@$title,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Subtitle <sup class="red">*</sup></td>
                    <td width=20px""></td>
                    <td><?php echoTextField("subtitle",@$subtitle,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Text <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text",@$text,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Link<sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("link",@$link,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <td>Image <sup class="red">*</sup></td>
                <td width="20px"></td>
                <td>
                    <div>
                        <input type="text" class="" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                        <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                        <input type="button" class="browseBtn" id="podcastBrowseBtn" value="BROWSE" />
                    </div>
                    <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){ echo "hidden";} ?>"id="imageViewDelete">
                        <a class="tiny" href=""<?php if(@$image!=""){echo "../../podcasts/images/".@$image;}?>" id="imageView" target="_blank">View</a>
                        &nbsp;|&nbsp;
                        <span class="tiny clickable" id="imageDelete">Delete</span></a>
                    </div>
                </td>
                <tr height="10px"></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if(isset($entryId)){?>
                            <input type='hidden' name='id' value='<?php echo $entryId; ?>' />
                        <?php } ?>
                        <input name='save' class='submit' value='Save' type='submit' />
                        <input onclick="window.location='index.php'" class='submit' value='Cancel' type='Button' />
                    </td>
                </tr>
            </table>
        </form>

        <?php } ?>
            
    </div>

</div>

<!-- End_section -->
<script>
    $(document).ready(function(){
        $("#imageDelete").click(function(){
            $("#imageTxt").val("");
            $("#image").val("");
            $("#imageViewDelete").addClass("hidden");
            $("#imageView").attr("href","");
        })
    });
</script>

<?php include("../bottom.php"); ?>



