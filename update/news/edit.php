<?php
	$pagetitle = 'NEWS';
	$section = 'NEWS';
	$table='news';
	
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
            if(isEmpty($title) ||  isEmpty(@$author) || isEmpty($text) || isEmpty($day) || isEmpty($month) || isEmpty($year) ){
                
                $error="Please fill required filed";


            }
            if(@$error==''){


                if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `title`='".sanitizeInput($title,"HTML")."',
                    `author`='".sanitizeInput($author,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `day`='".sanitizeInput($day,"HTML")."',
                    `month`='".sanitizeInput($month,"HTML")."',
                    `year`='".sanitizeInput($year,"HTML")."',
                    `link`='".sanitizeInput($link,"HTML")."',
                    `dateedit`=NOW()
					 WHERE `id`=".$entryId;
                    
                }else{
                    $query = "INSERT INTO `" .$table. "` (`title` , `author` , `text` , `day`, `month`, `year`, `link` , `datesubmit` ,`status`)
                    VALUES( '" . sanitizeInput($title, "HTML") . "' ,
                            '" . sanitizeInput($author, "HTML") . "' , 
                            '" . sanitizeInput($text, "HTML") . "' , 
                            '".sanitizeInput(@$day)."' , 
                            '".sanitizeInput(@$month)."' ,
                            '".sanitizeInput(@$year)."' ,
                            '" . sanitizeInput(@$link, "HTML") . "' , 
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
        }else{
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
                $date=date('d-m-Y',strtotime(@$date));

            }
        ?>

        <form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("title",@$title,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Author<sup class="red">*</sup></td>
                    <td width=20px""></td>
                    <td><?php echoTextField("author",@$author,"ckeditor"); ?></td>
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
                <tr>
                    <td>Date<sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <?php
                            $temp=date("Y");
                            echoDayDropDown("day",@$day,"date","width:250px;");
                            echoMonthDropDown("month", @$month,"date","width:250px;");
                            echoYearDropDown("year",@$year, $temp+3, $temp-23,"date","width:250px;");
                        ?>
                    </td>
                </tr>
                <tr height="10px"></tr>
                <!-- <td>Image <sup class="red">*</sup></td>
                <td width="20px"></td>
                <td>
                    <div>
                        <input type="text" class="" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                        <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                        <input type="button" class="browseBtn" id="newsBrowseBtn" value="BROWSE" />
                    </div>
                    <div class="topSpacerSmaller tiny textRight <?php if(@$image==""){ echo "hidden";} ?>"id="imageViewDelete">
                        <a class="tiny" href=""<?php if(@$image!=""){echo "../../news/images/".@$image;}?>" id="imageView" target="_blank">View</a>
                        &nbsp;|&nbsp;
                        <span class="tiny clickable" id="imageDelete">Delete</span></a>
                    </div>
                </td> -->

                <tr height="20px"></tr>
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
        
        $("#imageDelete").click(function(){
            $("#imageTxt").val("");
            $("#image").val("");
            $("#imageViewDelete").addClass("hidden");
            $("#imageView").attr("href","");
        })
    });
</script>

<?php include("../bottom.php"); ?>



