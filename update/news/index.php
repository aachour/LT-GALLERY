<?php
	$pageTitle = 'news';
	$section = 'news';
	$table='news';
	

	include('../top.php');
    
	$itemsPerPage=20;
	@$current=$_GET['page'];
	if(@$current==0){
		$page=1;
	}
	else{
		$page=@$current;
	}

	if(!$current){$current=0;$offset=0;}
	else{$offset=($current-1)*$itemsPerPage;}
?>
<div id="middle" style="position:relative; width:100%; padding:50px 0px; background:#FFF;">
<!-- content -->
        <div class="content">
            <?php
                 $list=1;
                 @extract($_POST);
                 @extract($_GET);
         
                 @$entryId=sanitizeInput($id);
     
                 if(@$delete){
                     echo "<div class='error'>Are you sure you want to delete this entry?<br /><br />
                         <form action='index.php' method='POST'>
                         <input type='hidden' name='id' value='".$entryId."' />
                         <input class='submit' type='submit' name='doDelete' value='Yes' />
                         &nbsp;&nbsp;<input class='submit' type='submit' name='' value='No' />
                     </form></div>";
                     $list=0;
                 }
                 if(@$doDelete){
                     $query="DELETE FROM `".$table."` WHERE `id`=".$entryId;
                     runQuery($query);
         
                     echo "<div class='msg'>Entry deleted successfully</div><br /><br />";
                     echo "<meta http-equiv='refresh' content='2;url=".currentPage()."'>";
                     $list=0;
                 }
                 
                 if($list){
                    echo"<p class='medium blue underline'>".$pageTitle."<br /><br /></p>";

                    echo"<a href='edit.php'><input type='submit' class='submit' name='Add' value='Add Entry' /></a><br  /><br />";
                    
                 $query="SELECT * FROM `".$table."`";
                 $result=runQuery($query);

                 $rows=numRows($result);
                 
                 if($rows==0){
                    
                 }
                 
                 
                 
                 
                 
                   }









            ?>

        </div>
</div>































<!--End middle-->


<?php include('../bottom.php'); ?>
