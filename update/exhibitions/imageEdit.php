<?php
	$pageTitle = 'EXHIBITION IMAGES';
	$section = 'EXHIBITIONS';
	$table='exhibition_images';
	$folder='../../exhibitions/';

	include('../top.php');

    include("../cropImage/index.html");
    
	$prompt=1;
	extract($_POST);
	extract($_GET);
	@$entryId=sanitizeInput($id);
    @$exhibitionsId=sanitizeInput($exhibitionsid); 
    
	$error='';

	handleFileDelete();
?>

<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>

<div id="middle" style="position:relative; width:100%; padding:50px 0px; background:#FFF;">

    <!--Content-->
	<div class="content">

    	<p class='medium blue underline'><?php echo $pageTitle;?></p><br /><br />

		<?php

        if(@$save){

			if(isEmpty(@$image)){
				$error="Please fill all required fields";
            }

            if(@$error==''){

				if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `image`='".sanitizeInput($image,"HTML")."',
                    `caption`='".sanitizeInput($caption,"HTML")."',
                    `dateedit`=NOW()
					WHERE `id`=".$entryId;
                }
                else{
                    $row=fetchArray(runQuery("SELECT max(listorder) FROM `".$table."` WHERE `exhibitions_id`='".@$exhibitionsId."' AND `status`='1' "));
					if($row[0] != null){$listorder = $row[0]+1;}
					else{$listorder = 1;}
					$query="INSERT INTO `".$table."` (`exhibitions_id` , `image` , `caption` , `datesubmit` , `status` , `listorder`) 
							VALUES( '".sanitizeInput($exhibitionsId)."' , 
                                    '".sanitizeInput($image,"HTML")."' , 
                                    '".sanitizeInput($caption,"HTML")."' , 
									NOW() , 
									'1',
                                    '".$listorder."')";
				}
				
                if(runQuery($query)){
                    if(isEmpty($entryId)){
                        $entryId=insertedId();
                    }
                    $msg="<br />Entry saved.<br />";
                    $prompt=0;
					echo "<meta http-equiv='refresh' content='2;url=images.php?exhibitionsid=".@$exhibitionsId."'>";
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
			}
        ?>

    	<form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing="0" class="prompt small">

                <tr height="20px"></tr>
                <tr>
                    <td>Image <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                    <div>
                        <input type="text" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                        <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                        <input type="button" class="browseBtn" id="galleryBrowseBtn" value="BROWSE" />
                    </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){echo "hidden";}?>" id="imageViewDelete">
                            <a class="tiny" href="<?php if(@$image!=""){echo "../../exhibitions/images/".@$image;}?>" id="imageView" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="tiny clickable" id="imageDelete">Delete</span>
                        </div>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Caption</td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("caption", @$caption,"ckeditor"); ?></td>
                </tr>
              
                <tr height="20px"></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <?php if(isset($entryId)){?>
                            <input type='hidden' name='id' value='<?php echo $entryId; ?>' />
                        <?php } ?>
                        <input type='hidden' name='exhibitionsid' value='<?php echo $exhibitionsId; ?>' />
                        <input name='save' class='submit' value='Save' type='submit' />
                        <input onclick="window.location='images.php?exhibitionsid=<?php echo @$exhibitionsId; ?>'" class='submit' value='Cancel' type='Button' />
                    </td>
                </tr>

            </table>

        </form>

		<?php } ?>

	</div>
	<!--End content-->

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