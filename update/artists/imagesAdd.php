<?php
	$pageTitle = ' EXHIBITIONS  IMAGES';
	$section = 'ARTISTS';
	$table='artist_images';
	$folder='../../artists/';

	include('../top.php');

    include("../uploadFile/popupUploadImages-artist.php");

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
        <!--Content-->
        <div class="content">

            <p class='medium blue underline'><?php echo $pageTitle;?></p><br /><br />

                <?php
                    if(@$save){

                        for($i=1;$i<=5;$i++){
                            
                            $image="image".$i;
                            
                            $caption="caption".$i;
            
                            if(@$$image!=""){
            
                                $row=fetchArray(runQuery("SELECT max(listorder) FROM `".$table."` WHERE `artist_id`='".@$artistId."' AND `status`='1' "));
                                if($row[0] != null){$listorder = $row[0]+1;}
                                else{$listorder = 1;}
            
                                $query="INSERT INTO `".$table."` (`artist_id` , `image` , `caption` , `datesubmit` , `status` , `listorder`) 
                                    VALUES( '".sanitizeInput($artistId)."' , 
                                            '".sanitizeInput($$image,"HTML")."' , 
                                            '".sanitizeInput($$caption,"HTML")."' , 
                                            NOW() , 
                                            '1',
                                            '".$listorder."')";
            
                                runQuery($query);
            
                            }
                            
                        }
            
                        $msg="<br />Entry saved.<br />";
                        $prompt=0;
                        echo "<meta http-equiv='refresh' content='2;url=images.php?artistId=".@$artistId."'>";
            
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
                                <td width="150px">Image <sup class='red'>*</sup><br /><span class="tiny">[Random size]</span></td>
                                <td width="20px"></td>
                                <td width="600px">
                                    <div>
                                    <input type="text" value="<?php if(@$image!=""){echo "Image uploaded";}?>" id="imageTxt" disabled />
                                    <input type="hidden" value="<?php echo @$image;?>" id="image" name="image" />
                                    <input type="button" class="browseBtn" id="galleryBrowseBtn" value="BROWSE" />
                                    </div>
                                </td>
                            </tr>

                            <?php 
                                
                                for($i=1;$i<=5;$i++){

                                    echo'<tr height="50px" class="image'.$i.'Container hidden"></tr>
                                    <tr class="image'.$i.'Container hidden">
                                        <td>Image '.$i.'</td>
                                        <td width="20px"></td>
                                        <td>
                                            <div>
                                                <input type="text" id="image'.$i.'Txt" disabled />
                                                <input type="hidden" value="" id="image'.$i.'" name="image'.$i.'" />
                                            </div>
                                            <div class="topSpacerSmaller tiny textRight hidden" id="image'.$i.'ViewDelete">
                                                <a class="tiny" href="" id="image'.$i.'View" target="_blank">View</a>
                                                &nbsp;|&nbsp;
                                                <span class="tiny clickable" id="image'.$i.'Delete" class="imageDelete">Delete</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr height="20px" class="image'.$i.'Container hidden"></tr>
                                    <tr class="image'.$i.'Container hidden">
                                        <td>Caption '.$i.'</td>
                                        <td width="20px"></td>
                                        <td><input type="text" class="caption'.$i.'" id="caption'.$i.'" name="caption'.$i.'" /></td>
                                    </tr>';

                                }
                            ?>

                        
                            <tr height="20px"></tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <?php if(isset($entryId)){?>
                                        <input type='hidden' name='id' value='<?php echo $entryId; ?>' />
                                    <?php } ?>
                                    <input type='hidden' name='artistid' value='<?php echo $artistId; ?>' />
                                    <input name='save' class='submit' value='Save' type='submit' />
                                    <input onclick="window.location='images.php?artistid=<?php echo @$artistId; ?>'" class='submit' value='Cancel' type='Button' />
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

        $("#galleryBrowseBtn").click(function(){
            $("#popupUploadArtistImages").removeClass("hidden");
        });

        $(".imageDelete").click(function(){
            $("#imageTxt").val("");
            $("#image").val("");
            $("#imageViewDelete").addClass("hidden");
            $("#imageView").attr("href","");
        });

});
</script>

<?php include("../bottom.php"); ?>