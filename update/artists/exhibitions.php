<?php
	$pageTitle = 'EXHIBITION';
	$section = 'ARTISTS';
	$table='artist_exhibitions';
	$folder='../../exhibitions/';

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
        
            @$artistId=sanitizeInput($artistid);
    
            if(@$delete){
                echo "<div class='error'>Are you sure you want to delete this entry?<br /><br />
                    <form action='exhibitions.php' method='POST'>
                    <input type='hidden' name='id' value='".$entryId."' />
                    <input type='hidden' name='artistid' value='".$artistId."' />
                    <input class='submit' type='submit' name='doDelete' value='Yes' />
                    &nbsp;&nbsp;<input class='submit' type='submit' name='' value='No' />
                </form></div>";
                $list=0;
            }
    
            if(@$doDelete){
                $query="UPDATE `".$table."` SET `status`='0' WHERE `id`=".$entryId;
                runQuery($query);
    
                echo "<div class='msg'>Entry deleted successfully</div><br /><br />";
                echo "<meta http-equiv='refresh' content='2;url=".currentPage()."?artistid=".@$artistId."'>";
                $list=0;
            }


            if($list){
                echo "<p class='medium blue underline'>".$pageTitle."<br /><br /></p>";

                echo "<a href='exhibitionEdit.php?artistid=".@$artistId."''><input type='submit' class='submit' name='Add' value='Add Entry' /></a>
                <a href='index.php'><input type='submit' class='submit' name='Back' value='Back' /></a>
                <br /><br />";

                $query = "SELECT * FROM `" . $table . "` WHERE `artist_id`='".@$artistId."'AND `status`='1' ORDER BY `id` DESC";

                $result=runQuery($query);
        
                $rows=numRows($result);

                if($rows==0){
                    echo "<p class='error'>No entries found.</p>";
                }
                else if($rows>0){
                    echo "<table cellpadding='0' cellspacing='0' border='0' class='listingTable' width='100%'>
                        <tr class='head blue'>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Year</th>
                            <th>Venue</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>";
                        while($row=fetchArray($result)){
                            foreach($row as $key => $temp){$$key = stripslashes(($row[$key]));}
                            echo '<tr>';
                                if($type==1){
                                    $query2="SELECT `title` , `from_year` ,`venue` , `city` , `country_id` FROM `exhibitions` WHERE `id`='".@$exhibition_id."' ";
                                    $result2=runQuery($query2);
                                    if(numRows($result2)==1){
                                        $row2=fetchArray($result2);
                                        foreach($row2 as $key => $temp){$$key = stripslashes(($row2[$key]));}
                                    }
                                    echo "<td>LT Exhibition</td>";
                                    echo "<td>".sanitizeInput($title)."</td>";
                                    echo "<td>".@$from_year."</td>";
                                    echo "<td>".sanitizeInput($venue)."</td>";
                                    echo "<td>".sanitizeInput($city)."</td>";
                                    echo "<td>".getCountryName($country_id)."</td>";
                                }else{
                                    echo "<td>External Exhibition</td>";
                                    echo "<td>".sanitizeInput($title)."</td>";
                                    echo "<td>".@$year."</td>";
                                    echo "<td>".sanitizeInput($venue)."</td>";
                                    echo "<td>".sanitizeInput($city)."</td>";
                                    echo "<td>".getCountryName($country_id)."</td>";
                                }
                                echo"<td>
                                    <form action='exhibitionEdit.php' method='post'>
                                        <input type='hidden' name='id' value='".$id."'/>
                                        <input type='hidden' name='artistid' value='".$artistId."'/>
                                        <input type='submit' class='submit' name='edit' value='Edit' style='width:150px;'/>
                                    </form>";
                                    echo"<form action='exhibitions.php' method='post'>
                                        <input type='hidden' name='id' value='".$id."'/>
                                        <input type='hidden' name='artistid' value ='".$artistId."'/>
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