<?php
	$pageTitle = 'EXEBITIONS';
	$section = 'EXEBITIONS';
	$table='exebitions';
	$folder='../../exebitions/';

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
			$query="UPDATE `".$table."` SET `status`='0' `".$table."` WHERE `id`=".$entryId;
			runQuery($query);

			echo "<div class='msg'>Entry deleted successfully</div><br /><br />";
			echo "<meta http-equiv='refresh' content='2;url=".currentPage()."'>";
			$list=0;
		}

		// if(@$up){
		// 	$previous=$listorder-1;
		// 	runQuery("UPDATE `".$table."` SET `listorder`=".$listorder." WHERE `listorder`=".$previous);
		// 	runQuery("UPDATE `".$table."` SET `listorder`=".$previous." WHERE `id`=".$entryId);
		// }
		
		// if(@$down){
		// 	$next=$listorder+1;
		// 	runQuery("UPDATE `".$table."` SET `listorder`=".$listorder." WHERE `listorder`=".$next);
		// 	runQuery("UPDATE `".$table."` SET `listorder`=".$next." WHERE `id`=".$entryId);
		// }

		if($list){

			echo "<p class='medium blue underline'>".$pageTitle."<br /><br /></p>";

			echo "<a href='edit.php'><input type='submit' class='submit' name='Add' value='Add Entry' /></a><br /><br />";

			$query="SELECT * FROM `".$table."` WHERE `status`='1' ORDER BY `id` DESC";
			
			$result=runQuery($query);
			
            $rows=numRows($result);

            if($rows==0){
        		echo "<p class='error'>No entries found.</p>";
            }else if($rows>0){
                echo "<table cellpadding='0' cellspacing='0' border='0' class='listingTable' width='100%'>
                    <tr class='head blue'>
						<th>Title</th>
						<th>Sub Title</th>
						<th>Date From</th>
						<th>Date To</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>";
				
                while($row=fetchArray($result)){
                    foreach($row as $key => $temp){$$key = stripslashes(($row[$key]));}
					echo '<tr>';
						echo "<td>".sanitizeInput($title)."</td>";
						echo "<td>".sanitizeInput($sub_title)."</td>";
						echo "<td>".date('d-m-Y',strtotime($date_from))."</td>";
						echo "<td>".date('d-m-Y',strtotime($date_to))."</td>";
						echo "<td>
							<img src='../../exebitions/images/".$image."' width='200px' />
						</td>";
						echo "<td>";
							echo"<form action='edit.php' method='post'>
                                <input type='hidden' name='id' value='".$id."'/>
                                <input type='submit' class='submit' name='edit' value='Edit' style='width:150px;'/>
							</form>";
							echo"<form action='images.php' method='post'>
								<input type='hidden' name='exebitionid' value='".$id."'/>
                                <input type='submit' class='submit' name='image' value='Gallery' style='width:150px;'/>
                            </form>";
							echo"<form action='index.php' method='post'>
                                <input type='hidden' name='id' value='".$id."'/>
                                <input type='submit' class='submit' name='delete' value='Delete' style='width:150px;'/>
                            </form>";
							
							// $row2=fetcharray(runQuery("select min(listorder) from `".$table."` WHERE `status`='1'"));
							// if($listorder>$row2[0]){
							// 	echo "<form action='index.php' method='post'>
							// 		<input type='hidden' name='id' value='".$id."' />
							// 		<input type='hidden' name='listorder' value='".$listorder."' />
							// 		<input type='submit' class='submit' name='up' value='&uArr;' />
							// 	</form>";
							// }
							// $row2=fetcharray(runQuery("select max(listorder) from `".$table."` WHERE `status`='1'"));
							// if($listorder<$row2[0]){
							// 	echo "<form action='index.php' method='post'>
							// 		<input type='hidden' name='id' value='".$id."' />
							// 		<input type='hidden' name='listorder' value='".$listorder."' />
							// 		<input type='submit' class='submit' name='down' value='&dArr;' />
							// 	</form>";
							// }
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