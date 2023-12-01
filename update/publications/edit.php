<?php
	$pageTitle = 'PUBLICATIONS';
	$section = 'PUBLICATIONS';
	$table='publications';
	//$folder='../../publications/';

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

    <!--Content-->
	<div class="content">

    	<p class='medium blue underline'><?php echo $pageTitle;?></p><br /><br />

		<?php

        if(@$save){

			if(isEmpty($title) || isEmpty($introduction) || isEmpty($text) || isEmpty($image)){
				$error="Please fill all required fields";
            }

            if(@$error==''){

				if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `title`='".sanitizeInput($title,"HTML")."',
                    `sub_title`='".sanitizeInput(@$sub_title,"HTML")."',
                    `created_by`='".sanitizeInput(@$created_by,"HTML")."',
                    `photographs_by`='".sanitizeInput(@$photographs_by,"HTML")."',
                    `foreworded_by`='".sanitizeInput(@$foreworded_by,"HTML")."',
                    `introduction_by`='".sanitizeInput(@$introduction_by,"HTML")."',
                    `notes_by`='".sanitizeInput(@$notes_by,"HTML")."',
                    `edited_by`='".sanitizeInput(@$edited_by,"HTML")."',
                    `preface_by`='".sanitizeInput(@$preface_by,"HTML")."',
                    `essays_by`='".sanitizeInput(@$essays_by,"HTML")."',
                    `introduction`='".sanitizeInput($introduction,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `extra_details`='".sanitizeInput(@$extra_details,"HTML")."',
                    `type`='".sanitizeInput(@$type,"HTML")."',
                    `cover`='".sanitizeInput(@$cover,"HTML")."',
                    `pages`='".sanitizeInput(@$pages,"HTML")."',
                    `language`='".sanitizeInput(@$language,"HTML")."',
                    `size`='".sanitizeInput(@$size,"HTML")."',
                    `illustrations`='".sanitizeInput(@$illustrations,"HTML")."',
                    `price`='".sanitizeInput(@$price,"HTML")."',
                    `year`='".sanitizeInput(@$year,"HTML")."',
                    `isbn`='".sanitizeInput(@$isbn,"HTML")."',
                    `image`='".sanitizeInput($image,"HTML")."',
                    `dateedit`=NOW()
					WHERE `id`=".$entryId;
                }
                else{
					$query="INSERT INTO `".$table."` (`title` , `sub_title` , `created_by` , `photographs_by` , `foreworded_by` , `introduction_by` ,  `notes_by` , `edited_by` , `preface_by` , `essays_by` , `introduction` , `text` , `extra_details` , `type` , `cover` , `pages` , `language` , `size` , `illustrations` , `price` , `year` , `isbn` , `image` , `datesubmit` , `status`) 
							VALUES( '".sanitizeInput($title,"HTML")."' , 
                                    '".sanitizeInput(@$sub_title,"HTML")."' , 
                                    '".sanitizeInput(@$created_by,"HTML")."' , 
                                    '".sanitizeInput(@$photographs_by,"HTML")."' , 
                                    '".sanitizeInput(@$foreworded_by,"HTML")."' ,
                                    '".sanitizeInput(@$introduction_by,"HTML")."' ,
                                    '".sanitizeInput(@$notes_by,"HTML")."' ,
                                    '".sanitizeInput(@$edited_by,"HTML")."' ,
                                    '".sanitizeInput(@$preface_by,"HTML")."' ,
                                    '".sanitizeInput(@$essays_by,"HTML")."' ,
                                    '".sanitizeInput($introduction,"HTML")."' , 
                                    '".sanitizeInput($text,"HTML")."' , 
                                    '".sanitizeInput(@$extra_details,"HTML")."' , 
                                    '".sanitizeInput(@$type,"HTML")."' ,
                                    '".sanitizeInput(@$cover,"HTML")."' ,
                                    '".sanitizeInput(@$pages,"HTML")."' ,
                                    '".sanitizeInput(@$language,"HTML")."' ,
                                    '".sanitizeInput(@$size,"HTML")."' , 
                                    '".sanitizeInput(@$illustrations,"HTML")."' ,
                                    '".sanitizeInput(@$price,"HTML")."' ,
                                    '".sanitizeInput(@$year,"HTML")."' , 
                                    '".sanitizeInput(@$isbn,"HTML")."' , 
                                    '".sanitizeInput($image,"HTML")."' , 
									NOW() , 
									'1')";
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

        if(@$error){echo "<p class='error'>".$error."<br /></p><br /><br />";}
        if(@$msg){echo "<p class='msg'>".$msg."<br /></p><br /><br /><br /><br /><br /><br /><br /><br />";}

        if($prompt==1){
            if(isset($entryId) && $entryId != ''){
                $query='SELECT * FROM `'.$table.'` WHERE `id`='.$entryId;
                $result=runQuery($query);
                $row=fetchArray($result);
                foreach($row as $key => $item){$$key=stripslashes($row[$key]);}
                
                $title=sanitizeInput($title);
                $sub_title=sanitizeInput($sub_title);
                $created_by=sanitizeInput($created_by);
                $photographs_by=sanitizeInput($photographs_by);
                $foreworded_by=sanitizeInput($foreworded_by);
                $edited_by=sanitizeInput($edited_by);
			}
        ?>

    	<form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing="0" class="prompt small">

                <tr>
                    <td>Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("title", @$title,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Sub Title </td>
                    <td width="20px"></td>
                    <td><?php echoTextField("sub_title", @$sub_title,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("created_by", @$created_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Photographs By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("photographs_by", @$photographs_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Foreword By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("foreworded_by", @$foreworded_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Introduction By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("introduction_by", @$introduction_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Notes By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("notes_by", @$notes_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Edited By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("edited_by", @$edited_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Preface By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("preface_by", @$preface_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Essays By</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("essays_by", @$essays_by,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Introduction <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("introduction", @$introduction,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Text <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Extra Details</td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("extra_details", @$extra_details,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Type</td>
                    <td width="20px"></td> 
                    <td>
                        <input type="radio" name="type" value="1" <?php if(@$type=="" || @$type=="1"){echo "checked";}?> />&nbsp;Forthcoming
                        &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="type" value="0" <?php if(@@$type=="0"){echo "checked";}?> />&nbsp;Publications
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Cover</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("cover", @$cover,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Number of Pages</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("pages", @$pages,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Language</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("language", @$language,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr> 
                <tr>
                    <td>Size</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("size", @$size,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Number of Illustrations</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("illustrations", @$illustrations,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Price</td>
                    <td width="20px"></td> 
                    <td><?php echoTextField("price", @$price,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Year</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("year", @$year,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>ISBN</td>
                    <td width="20px"></td> 
                    <td><?php echoTextField("isbn", @$isbn,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Image <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                            <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                            <input type="button" class="browseBtn" id="publicationBrowseBtn" value="BROWSE" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){echo "hidden";}?>" id="imageViewDelete">
                            <a class="tiny" href="<?php if(@$image!=""){echo "../../publication-images/images/".@$image;}?>" id="imageView" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="tiny clickable" id="imageDelete">Delete</span>
                        </div>
                    </td>
                </tr>

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
	<!--End content-->

</div>

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

