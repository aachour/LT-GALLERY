<?php
	$pageTitle = 'COLLECTION';
	$section = 'ARTISTS';
	$table='collection_artists';
    $folder='../../artists/';

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

        <div class="content">
            <?php
                 $list=1;

                 @extract($_POST);
                 @extract($_GET);
         
                 @$entryId=sanitizeInput($id);
                 if(@$delete){
                    echo "<div class='error'>Are you sure you want to delete this entry?<br /><br />
                        <form action='collection.php' method='POST'>
                        <input type='hidden' name='id' value='".$entryId."' />
                        <input class='submit' type='submit' name='doDelete' value='Yes' />
                        &nbsp;&nbsp;<input class='submit' type='submit' name='' value='No' />
                    </form></div>";
                    $list=0;
                }
        
                if(@$doDelete){
                    $query="UPDATE `".$table."` SET `status`='0' WHERE `id`=".$entryId;
                    runQuery($query);
        
                    echo "<div class='msg'>Entry deleted successfully</div><br /><br />";
                    echo "<meta http-equiv='refresh' content='2;url=".currentPage()."'>";
                    $list=0;
                }

                if($list){
                    echo "<p class='medium blue underline'>".$pageTitle."<br /><br /></p>";

                    echo "<a href='collectionEdit.php'><input type='submit' class='submit' name='Add' value='Add Entry' /></a>
                        <a href='index.php'>
                            <input type='submit' class='submit' name='Add' value='Back' />
                        </a>
                    <br /><br />
                    <br /><br />";

                    $query="SELECT * FROM `".$table."` WHERE `status`='1' ORDER BY `id` DESC";

                    $result=runQuery($query);

                    $rows=numRows($result);

                    if($rows==0){
                        echo "<p class='error'>No entries found.</p>";
                    }else if($rows>0){
                        echo "<table cellpadding='0' cellspacing='0' border='0' class='listingTable' width='100%'>
                            <tr class='head blue'>
                                <th>Name</th>
                                <th>Location</th>
                                <th>City</th>
                                <th>County</th>
                                <th>Date</th>
                               <th>Actions</th>
                            </tr>";
                        while($row=fetchArray($result)){
                            foreach($row as $key => $temp){$$key = stripslashes(($row[$key]));}
                            echo "<tr>";
                            echo "<td>".sanitizeInput($name)."</td>";
                            echo "<td>".sanitizeInput($location)."</td>";
                            echo "<td>".sanitizeInput($city)."</td>";
                            echo "<td>".getCountryName($country_id)."</td>";
                            echo "<td>";
                                    if($from_day!=0){echo $from_day."-";}
                                    if($from_month!=0){echo $from_month."-";}
                                    if($from_year!=0){echo $from_year;}
                            echo "</td>";
                            echo"<td>";
                                    echo"<form action='collectionEdit.php' method='post'>
                                        <input type='hidden' name='id' value='".$id."'/>
                                        <input type='submit' class='submit' name='edit' value='Edit' style='width:150px;'/>
                                        </form>";
                                    echo"<form action='collection.php' method='post'>
                                        <input type='hidden' name='id' value='".$id."'/>
                                        <input type='submit' class='submit' name='delete' value='Delete' style='width:150px;'/>
                                        </form>";
                                echo"</td>";
                            echo"</tr>";
                        }
                        echo "</table>";
        
                    }
                }








                ?>


        </div>

    </div>

    
<?php include('../bottom.php'); ?>