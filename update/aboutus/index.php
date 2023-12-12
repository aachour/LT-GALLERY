<?php
	$pageTitle = 'ABOUT US';
	$section = 'ABOUT US';
	$table='aboutus';
	//$folder='../../aboutus/';

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

    <!--Content-->
	<div class="content">

	<?php
        $list=1;

		@extract($_POST);
		@extract($_GET);

		@$entryId=sanitizeInput($id);

		if($list){

			echo "<p class='medium blue underline'>".$pageTitle."<br /><br /></p>";

			// echo "<a href='edit.php'><input type='submit' class='submit' name='Add' value='Add Entry' /></a><br /><br />";

			$query="SELECT * FROM `".$table."` WHERE `id`='1' AND `status`='1' ";

			$result=runQuery($query);

            $rows=numRows($result);

            if($rows==0){
        		echo "<p class='error'>No entries found.</p>";
            }else if($rows>0){
                echo "<table cellpadding='0' cellspacing='0' border='0' class='listingTable' width='100%'>
                    <tr class='head blue'>
						<th>Title</th>
						<th>Sub Title</th>
						<th>Text</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>";
                while($row=fetchArray($result)){
                    foreach($row as $key => $temp){$$key = stripslashes(($row[$key]));}
					echo '<tr>';
						echo "<td>".sanitizeInput(@$title)."</td>";
						echo "<td>".sanitizeInput(@$sub_title)."</td>";
						echo "<td>".sanitizeInput(@$text,"HTML")."</td>";
						echo "<td>
							<img src='../../aboutus/images/".$image."' width='200px' />
						</td>";
						echo "<td>";
							echo"<form action='edit.php' method='post'>
                                <input type='hidden' name='id' value='".$id."'/>
                                <input type='submit' class='submit' name='edit' value='Edit' style='width:150px;'/>
							</form>";
						echo"</td>";
					echo"</tr>";
                }
                echo "</table>";

            }
        }
    ?>

	</div>
  	<!--End content-->

</div>
<!--End middle-->


<?php include('../bottom.php'); ?>