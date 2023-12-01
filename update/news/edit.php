<?php
	$pagetitle = 'news';
	$section = 'news';
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

<div id="middle" style="position:relative; width:100%; padding:50px 0xp; background:#FFF;">

    <!-- content -->
    <div class="content">

        <p class='medium blue underline'><?php echo $pagetitle;?></p><br /><br />

        <?php
        if(@$save){
            if(isEmpty($title) ||  isEmpty(@$author) || isEmpty($text) || isEmpty($date) ){
                $error="Please fill required filed";


            }
            if(@$error==''){


                if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `title`='".sanitizeInput($title,"HTML")."',
                    `author`='".sanitizeInput($author,"HTML")."',
                    `text`='".sanitizeInput($text,"HTML")."',
                    `link`='".sanitizeInput($link,"HTML")."',
                    `date`=NOW() 
					 WHERE `id`=".$entryId;
                    
                }else{
                    $query = "INSERT INTO `" .$table. "` (`title` , `author` , `text` , `link` , `date`)
                    VALUES( '" . sanitizeInput($title, "HTML") . "' ,
                            '" . sanitizeInput($author, "HTML") . "' , 
                            '" . sanitizeInput($text, "HTML") . "' , 
                            '" . sanitizeInput(@$link, "HTML") . "' , 
                            NOW()
                            )";
                }
                if(runQuery($query)){
                    if(isEmpty($entryId)){
                        $entryId=insertedId();
                    }
                    $msg="<br /> Entry saved.<br />";
                    $prompt=0;
                    echo"<meta http-equiv='refresh' content='2;url=index.php'";
                }else{
                    $error="<br />Could not save entery.Please try again. <br  />";
                    $prompt=1;
                }
            }else{
                $prompt=1;
            }
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
                    <td><?php echoTextField("text",@$link,"ckeditor"); ?></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Date <sup class="red">*</sup></td>
                    <td width="20px"></td> 
                    <td><input type="text" class="datepicker" id="date" name="date" value="<?php echo @$date;?>" /></td>
                    <td></td>
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



