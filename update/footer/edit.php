<?php
	$pageTitle = 'FOOTER';
	$section = 'FOOTER';
	$table='footer';
	//$folder='../../footer/';

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

			if(isEmpty($address) || isEmpty($working_hours) || isEmpty($phone) || isEmpty($email)){
				$error="Please fill all required fields";
            }

            if(@$error==''){

				if(!isEmpty($entryId)){
                    $query="UPDATE `".$table."` SET
                    `address`='".sanitizeInput($address,"HTML")."',
                    `working_hours`='".sanitizeInput($working_hours,"HTML")."',
                    `phone`='".sanitizeInput($phone,"HTML")."',
                    `email`='".sanitizeInput($email,"HTML")."',
                    `asocial`='".sanitizeInput($asocial,"HTML")."',
                    `instagram`='".sanitizeInput($instagram,"HTML")."',
                    `youtube`='".sanitizeInput($youtube,"HTML")."',
                    `linkedin`='".sanitizeInput($linkedin,"HTML")."',
                    `dateedit`=NOW()
					WHERE `id`=".$entryId;
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
			}
        ?>

    	<form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data">

            <table cellpadding="0" cellspacing"0" class="prompt small">

                <tr>
                    <td>Address <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td width="500px"><?php echoTextField("address", @$address,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Working Hours</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("working_hours", @$working_hours,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Phone</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("phone", @$phone,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Email</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("email", @$email,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>A-social</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("asocial", @$asocial,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Instagram</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("instagram", @$instagram,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Youtube</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("youtube", @$youtube,"ckeditor"); ?></td>
                </tr>

                <tr height="20px"></tr>
                <tr>
                    <td>Linkedin</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("linkedin", @$linkedin,"ckeditor"); ?></td>
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

