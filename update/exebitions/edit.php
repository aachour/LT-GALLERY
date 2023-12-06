<?php
	$pageTitle = 'EXEBITIONS';
	$section = 'EXEBITIONS';
	$table='exebitions';
    $folder='../../exebitions/';

	include('../top.php');

    include("../cropImage/index.html");
    include("../uploadFile/popupUploadFile.php");
    
    
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

            if(isEmpty($title) || isEmpty($text) || isEmpty($image)){
				$error="Please fill all required fields";
            }
            
            if(@$error==''){

				if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `title`='".sanitizeInput($title,"HTML")."',
                    `sub_title`='".sanitizeInput(@$sub_title,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `date_from`='".date('Y-m-d',strtotime(@$date_from))."',
                    `date_to`='".date('Y-m-d',strtotime(@$date_to))."',
                    `artists_id`='".json_encode(@$artists_id)."',
                    `file`='".sanitizeInput(@$file,"HTML")."',
                    `image`='".sanitizeInput($image,"HTML")."',
                    `dateedit`=NOW()
					WHERE `id`=".$entryId;
                }
                else{
					$query="INSERT INTO `".$table."` (`title` , `sub_title` , `text` , `date_from` , `date_to` , `artists_id` , `file` , `image` , `datesubmit` , `status`) 
							VALUES( '".sanitizeInput($title,"HTML")."' , 
                                    '".sanitizeInput(@$sub_title,"HTML")."' , 
                                    '".sanitizeInput($text,"HTML")."' , 
                                    '".date('Y-m-d',strtotime(@$date_from))."' , 
                                    '".date('Y-m-d',strtotime(@$date_to))."' ,
                                    '".json_encode(@$artists_id)."' ,
                                    '".sanitizeInput(@$file,"HTML")."' ,
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
                $artists_id=json_decode($artists_id);
                $date_from=date('d-m-Y',strtotime(@$date_from));
                $date_to=date('d-m-Y',strtotime(@$date_to));
			}
            else{
                @$artists_id=[];
            }
        ?>

    	<form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing="0" class="prompt small">
                
                <tr>
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
                                    if($categoryId==$category_id){$selected="selected";}
                                    echo'<option value="'.$categoryId.'" '.$selected.'>'.$categoryName.'</option>';
                                }
                            }
                        ?>
                    </select>

                    </td>
                </tr>
                
                <tr height="20px"></tr>
                <tr>
                    <td>Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("title", sanitizeInput(@$title),"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Sub Title </td>
                    <td width="20px"></td>
                    <td><?php echoTextField("sub_title", sanitizeInput(@$sub_title),"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Text <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Date From</td>
                    <td width="20px"></td> 
                    <td><input type="text" class="datepicker" id="date_from" name="date_from" value="<?php echo @$date_from;?>" /></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Date To</td>
                    <td width="20px"></td> 
                    <td><input type="text" class="datepicker" id="date_to" name="date_to" value="<?php echo @$date_to;?>" /></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Artists</td>
                    <td width="20px"></td> 
                    <td>
                    <select id="artists_id" name="artists_id[]" class="select2" multiple>
                        <option value=""></option>
                        <?php
                            $query2="SELECT `id` as `artistId` , `name` as `artistName` FROM `artists` WHERE `status`='1' ORDER BY `name` ASC" ;
                            $result2=runQuery($query2);
                            if(numRows($result2)>0){
                                while($row2=fetchArray($result2)){
                                    foreach($row2 as $key => $item){$$key=stripslashes($row2[$key]);}
                                    $selected="";
                                    if(in_array($artistId,$artists_id)){$selected="selected";}
                                    echo'<option value="'.$artistId.'" '.$selected.'>'.$artistName.'</option>';
                                }
                            }
                        ?>
                    </select>

                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>File <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$file!=""){echo "File uploaded";}?>" id="fileTxt" disabled />
                            <input type="hidden" value="<?php echo @$file;?>" id="file" name="file" />
                            <input type="button" class="browseBtn" id="exebitionFileBrowseBtn" value="BROWSE" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$file==""){echo "hidden";}?>" id="fileViewDelete">
                            <a class="tiny" href="<?php if(@$file!=""){echo "../../exebitions/images/".@$file;}?>" id="fileView" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="tiny clickable" id="fileDelete">Delete</span>
                        </div>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Image <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                            <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                            <input type="button" class="browseBtn" id="exebitionBrowseBtn" value="BROWSE" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){echo "hidden";}?>" id="imageViewDelete">
                            <a class="tiny" href="<?php if(@$image!=""){echo "../../exebitions/images/".@$image;}?>" id="imageView" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="tiny clickable" id="imageDelete">Delete</span>
                        </div>
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

        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy', // Date format
            beforeShow: function (input, inst) {
                setTimeout(function () {
                    inst.dpDiv.css({
                        width: '850px'
                    });
                }, 0);
            }
        });
        
        $(".select2").select2({
            selectOnClose: true,
            allowClear: true,
            width: '100%'
        });

        $("#exebitionFileBrowseBtn").click(function(){
            $("#popupUploadFile").removeClass("hidden");
        })

        $("#fileDelete").click(function(){
            $("#fileTxt").val("");
            $("#file").val("");
            $("#fileViewDelete").addClass("hidden");
            $("#fileView").attr("href","");
        });
        

        $("#imageDelete").click(function(){
            $("#imageTxt").val("");
            $("#image").val("");
            $("#imageViewDelete").addClass("hidden");
            $("#imageView").attr("href","");
        });

    });
</script>

<?php include("../bottom.php"); ?>

