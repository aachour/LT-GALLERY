<?php
	$pageTitle='Change Password';
	$table='users';
	$section='Change Password';

	include('../top.php');

	$prompt=1;

	extract($_POST);

	if(@$save){
		if($old!=NULL  && $new!=NULL && $confirm!=NULL){
			$error="";
			if(strlen($new)<6){
				//password too short
				$error="New password is too short, it should contain at least 6 characters .";
			}

			@$old=sanitizeInput($old);
			@$new=sanitizeInput($new);
			@$confirm=sanitizeInput($confirm);

			$query="SELECT `salt` FROM `users` WHERE `id`='".$_SESSION['LTG-ADMIN-ID']."'";
			$result=runQuery($query);
			$row=fetchArray($result);

			$salt=$row[0];

			@$old=encryptPassword($old,$salt);

			$query="select * from $table where id='".$_SESSION['LTG-ADMIN-ID']."' and password=\"".$old."\" limit 1";
			$result=runQuery($query);
			$rows=numRows($result);
			if($rows==0){
				//old password incorrect
				$error="Old password is incorrect.";
			}

			if($new!=$confirm){
				//passwords don't match
				$error="Password and confirm password don't match.";
			}

			if($error==""){
				@$new=encryptPassword($new,$salt);
				$query="update $table set
				password=\"".$new."\"
				where id=".$_SESSION['LTG-ADMIN-ID']."";
				$result=runQuery($query);

				$error="Password has been updated successfully";
				echo "<meta http-equiv='refresh' content='2;url=../index.php?logout=1'>";
				$prompt=1;
			}
		}

		else{
			$error="Please fill in all entries.";
		}
	}

	if(@$error){
		$prompt=1;
	}
?>

<?php if(@$prompt==1){?>

<div id="middle" style="position:relative; width:100%; padding:50px 0px; background:#FFF;">

	<div class="content" >

        <?php if(@$error){echo'<div class="topSpacer bottomSpacerBig error smalll">'.@$error.'</div>';}?>

        <form action="edit.php" method="post" enctype="multipart/form-data" style="margin-top:20px;">
            <table class="small">
                <tr>
                    <td >Old password</td>
                    <td width="50px"></td>
                    <td><input type="password" class="input" name="old" style="width:500px;height:30px;"/></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>New password</td>
                    <td width="50px"></td>
                    <td><input type="password" class="input" name="new" style="width:500px;height:30px;"/></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td>Confirm password</td>
                    <td width="50px"></td>
                    <td><input type="password" class="input" name="confirm" style="width:500px;height:30px;"/></td>
                </tr>
                <tr height="20px"></tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <input name='save' value='Save' type='submit' />
                        <a href="index.php">
                           <input class='white' value='Cancel' type='button' />
                        </a>
                    </td>
                </tr>
            </table>
        </form>

  	</div>

</div>

<?php }?>

<?php include('../bottom.php'); ?>


