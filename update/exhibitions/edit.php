<?php
	$pageTitle = 'LT EXHIBITIONS ';
	$section = 'EXHIBITIONS';
	$table='exhibitions';
    $folder='../../exhibitions/';

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

            if(isEmpty($category_id) || isEmpty($title) || isEmpty($image)){
				$error="Please fill all required fields";
            }
            
            if(@$error==''){

				if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `category_id`='".sanitizeInput(@$category_id)."',
                    `artists_id`='".json_encode(@$artists_id)."',
                    `other_artists`='".sanitizeInput($other_artists)."',
                    `title`='".sanitizeInput($title,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `venue`='".sanitizeInput($venue,"HTML")."',
                    `city`='".sanitizeInput($city,"HTML")."',
                    `country_id`='".sanitizeInput($country_id,"HTML")."',
                    `from_day`='".sanitizeInput($from_day,"HTML")."',
                    `from_month`='".sanitizeInput($from_month,"HTML")."',
                    `from_year`='".sanitizeInput($from_year,"HTML")."',
                    `to_day`='".sanitizeInput($to_day,"HTML")."',
                    `to_month`='".sanitizeInput($to_month,"HTML")."',
                    `to_year`='".sanitizeInput($to_year,"HTML")."',
                    `file`='".sanitizeInput(@$file,"HTML")."',
                    `file2`='".sanitizeInput(@$file2,"HTML")."',
                    `file3`='".sanitizeInput(@$file3,"HTML")."',
                    `image`='".sanitizeInput($image,"HTML")."',
                    `dateedit`=NOW()
					WHERE `id`=".$entryId;
                }
                else{
					$query="INSERT INTO `".$table."` (`category_id` , `artists_id` , `other_artists` , `title` , `text` , `venue` , `city` , `country_id` , `from_day` , `from_month`  , `from_year` , `to_day` , `to_month` , `to_year` , `file` , `file2` , `file3` , `image` , `datesubmit` , `status`) 
							VALUES( '".sanitizeInput($category_id)."' , 
                                    '".json_encode(@$artists_id)."' ,
                                    '".sanitizeInput($other_artists)."' , 
                                    '".sanitizeInput($title,"HTML")."' , 
                                    '".sanitizeInput($text,"HTML")."' , 
                                    '".sanitizeInput($venue,"HTML")."' , 
                                    '".sanitizeInput($city,"HTML")."' , 
                                    '".sanitizeInput($country_id,"HTML")."' , 
                                    '".sanitizeInput(@$from_day)."' , 
                                    '".sanitizeInput(@$from_month)."' ,
                                    '".sanitizeInput(@$from_year)."' ,
                                    '".sanitizeInput(@$to_day)."' ,
                                    '".sanitizeInput(@$to_month)."' ,
                                    '".sanitizeInput(@$to_year)."' ,
                                    '".sanitizeInput(@$file,"HTML")."' ,
                                    '".sanitizeInput(@$file2,"HTML")."' ,
                                    '".sanitizeInput(@$file3,"HTML")."' ,
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
                if(@$artists_id!="null"){
                    $artists_id=json_decode($artists_id,true);
                }else{
                    @$artists_id=[];
                }
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
                                    if(@$categoryId==@$category_id){$selected="selected";}
                                    echo'<option value="'.$categoryId.'" '.$selected.'>'.$categoryName.'</option>';
                                }
                            }
                        ?>
                    </select>

                    </td>
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
                    <td>Other Artists<br />[comma separator]</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("other_artists", @$other_artists,"ckeditor"); ?></td>
                </tr>
                
                <tr height="20px"></tr>
                <tr>
                    <td>Title <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("title", sanitizeInput(@$title),"ckeditor"); ?></td>
                </tr>


                <tr height="20px"></tr>
                <tr>
                    <td>Text</td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Venue </td>
                    <td width="20px"></td>
                    <td><?php echoTextField("venue", @$venue,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>City </td>
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

                <tr height="10px"></tr>
        		<tr>
                    <td>Date From</td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoDayDropDown("from_day",@ $from_day,"date","width:250px;");
                            echoMonthDropDown("from_month", @$from_month,"date","width:250px;");
                            echoYearDropDown("from_year",@ $from_year, $temp+3, 1950,"date","width:250px;");
                        ?>
                    </td>
                </tr>

                <tr height="10px"></tr>
        		<tr>
                    <td>Date To</td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoDayDropDown("to_day", @$to_day,"date","width:250px;");
                            echoMonthDropDown("to_month", @$to_month,"date","width:250px;");
                            echoYearDropDown("to_year",@$to_year, $temp+3, 1950,"date","width:250px;");
                        ?>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>File</td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$file!=""){echo "File uploaded";}?>" id="file1Txt" disabled />
                            <input type="hidden" value="<?php echo @$file;?>" id="file1" name="file" />
                            <input type="button" class="browseBtn exhibitionFileBrowseBtn" value="BROWSE" file="1" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$file==""){echo "hidden";}?>" id="file1ViewDelete">
                            <a class="tiny" href="<?php if(@$file!=""){echo "../../exhibitions/files/".@$file;}?>" id="file1View" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="fileDelete tiny clickable" file="1">Delete</span>
                        </div>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>File2 </td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$file2!=""){echo "File uploaded";}?>" id="file2Txt" disabled />
                            <input type="hidden" value="<?php echo @$file2;?>" id="file2" name="file2" />
                            <input type="button" class="browseBtn exhibitionFileBrowseBtn" value="BROWSE" file="2" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$file2==""){echo "hidden";}?>" id="file2ViewDelete">
                            <a class="tiny" href="<?php if(@$file2!=""){echo "../../exhibitions/files/".@$file2;}?>" id="file2View" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="fileDelete tiny clickable" file="2">Delete</span>
                        </div>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>File3 </td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$file3!=""){echo "File uploaded";}?>" id="file3Txt" disabled />
                            <input type="hidden" value="<?php echo @$file3;?>" id="file3" name="file3" />
                            <input type="button" class="browseBtn exhibitionFileBrowseBtn" value="BROWSE" file="3" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$file3==""){echo "hidden";}?>" id="file3ViewDelete">
                            <a class="tiny" href="<?php if(@$file3!=""){echo "../../exhibitions/files/".@$file3;}?>" id="file3View" target="_blank">View</a>
                            &nbsp;|&nbsp;
                            <span class="fileDelete tiny clickable" file="3">Delete</span>
                        </div>
                    </td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Image <sup class='red'>*</sup><br /><span class="tiny">[1760x1100px]</span></td>
                    <td width="20px"></td>
                    <td>
                        <div>
                            <input type="text" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                            <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                            <input type="button" class="browseBtn" id="exhibitionBrowseBtn" value="BROWSE" />
                        </div>
                        <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){echo "hidden";}?>" id="imageViewDelete">
                            <a class="tiny" href="<?php if(@$image!=""){echo "../../exhibitions/images/".@$image;}?>" id="imageView" target="_blank">View</a>
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

        $(".exhibitionFileBrowseBtn").click(function(){
            fileNumb=$(this).attr("file");
            $("#popupUploadFile").removeClass("hidden");
        })

        $(".fileDelete").click(function(){
            var fileCount=$(this).attr("file");
            $("#file"+fileCount+"Txt").val("");
            $("#file"+fileCount+"").val("");
            $("#file"+fileCount+"ViewDelete").addClass("hidden");
            $("#file"+fileCount+"View").attr("href","");
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

