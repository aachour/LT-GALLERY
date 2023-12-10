<?php
	$pageTitle = 'EXEBITIONS';
	$section = 'ARTISTS';
	$table='artist_exebitions';
    $folder='../../exebitions/';

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

            if(@$error==''){
                if($type==1 && !isset($exebitions_id)){
                    $error="Please fill all required fields";
                }
                else if($type==2 && (isEmpty($year) || isEmpty($text))){
                    $error="Please fill all required fields";
                }

                if(@$error==""){

                    if(!isEmpty($entryId)){
                        $query="UPDATE `".$table."` SET 
                        `type`='".sanitizeInput(@$type,"HTML")."',
                        `exebitions_id`='".json_encode(@$exebitions_id)."',
                        `year`='".sanitizeInput(@$year,"HTML")."',
                        `text`='".sanitizeInput(@$text,"HTML")."',
                        `link`='".sanitizeInput(@$link,"HTML")."',
                        `dateedit`=NOW()
                        WHERE `id`=".$entryId;
                    }
                    else{
                        $query="INSERT INTO `".$table."` ( `artist_id` , `type`, `exebitions_id` , `year` , `text` , `link` , `datesubmit` , `status`)
                            VALUE(
                            '".sanitizeInput(@$artistId)."', 
                            '".sanitizeInput(@$type,"HTML")."' , 
                            '".json_encode(@$exebitions_id)."' , 
                            '".sanitizeInput(@$year,"HTML")."' , 
                            '".sanitizeInput(@$text,"HTML")."' , 
                            '".sanitizeInput(@$link,"HTML")."' ,
                            NOW() , 
                            '1'
                        )";
                    }

                    if(runQuery($query)){
                        if(isEmpty($entryId)){
                            $entryId=insertedId();
                        }
                        $msg="<br />Entry saved.<br />";
                        $prompt=0;
                        echo "<meta http-equiv='refresh' content='2;url=exebitions.php?artistid=".$artistId."'>";
                    }else{
                        $error="<br  />Could not save . Please try again.<br  />";
                        $prompt=1;
                    }
                }

            }
        } else{
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
                if($exebitions_id=="null"){ 
                    $exebitions_id=[];
                }else{
                    $exebitions_id=json_decode($exebitions_id,true);
                }
            }
            else{
                @$exebitions_id=[];
            }

        ?>

        <form action="<?php echo currentPage(); ?>" method="POST" enctype="multipart/form-data" >
                
            <table cellpadding="0" cellspacing="0" class="prompt small">
                
                <tr>
                    <td>Type <sup class="red">*</sup></td>
                    <td width="20px"></td>
                    <td>
                        <input type="radio" class="typeRBtn" name="type" value="1" <?php if(@$type=="" || @$type=="1"){echo "checked";}?> />&nbsp;LT Exebitions
                        &nbsp;&nbsp;&nbsp;
                        <input type="radio" class="typeRBtn" name="type" value="2" <?php if(@$type=="2"){echo "checked";}?> />&nbsp;External Exebitions
                    </td>
                </tr>

                <tr height="20px" class="internal"></tr>
                <tr class="internal">
                    <td>Exebitions <sup class="red">*</sup></td>
                    <td width="20px"></td> 
                    <td>
                        <select id="exebitions_id" name="exebitions_id[]" class="select2" multiple>
                            <option value=""></option>
                            <?php
                                $query2 = "SELECT `id` as `exebitionId`, `title` as `exebitionTitle` FROM `exebitions` WHERE `status`='1' ORDER BY `id` DESC";
                                $result2 = runQuery($query2);
                                if (numRows($result2) > 0) {
                                    while ($row2 = fetchArray($result2)) {
                                        foreach ($row2 as $key => $item) {$$key = stripslashes($row2[$key]);}
                                        $selected = "";
                                        if(in_array($exebitionId,$exebitions_id)){$selected="selected";}
                                        echo '<option value="' . $exebitionId . '" ' . $selected . '>' . $exebitionTitle . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                                
                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>Year <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextField("year", @$year,"ckeditor"); ?></td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>Text <sup class='red'>*</sup></td>
                    <td width="20px"></td>
                    <td><?php echoTextArea("text", @$text,"ckeditor"); ?></td>
                </tr>

                <tr height="20px" class="external"></tr>
                <tr class="external">
                    <td>link</td>
                    <td width="20px"></td>
                    <td><?php echoTextField("link", @$link,"ckeditor"); ?></td>
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
                        <input type='hidden' name='artistid' value='<?php echo $artistId; ?>' />
                        <input onclick="window.location='exebitions.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button' />
                    </td>
                </tr>              

            </table>

        </form>

        <?php } ?>

    </div>

</div>


<script>
    
    function showHideSections(type){
        if(type=="1"){
            $(".internal").show();
            $(".external").hide();
            $("#year,#link").val("");
            CKEDITOR.instances['text'].setData('');
        }else if(type=="2"){
            $(".internal").hide();
            $(".external").show();
            $(".select2").val("");
        }
    }

    $(document).ready(function(){

        var type=$(".typeRBtn:checked").val();
        showHideSections(type);

        $(".typeRBtn").click(function(){
            var type=$(this).val();
            showHideSections(type);
        });

        $(".select2").select2({
            selectOnClose: true,
            allowClear: true,
            width: '100%'
        });

        
        
    });
</script>

<?php include("../bottom.php"); ?>

