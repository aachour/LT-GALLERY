<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<?php
	include('../global/global.php');

	if(@$_GET['logout']=="1"){
		//logged in trying to log out
		@$_SESSION['LTG-ADMIN-STATUS']="";
		unset($_SESSION['LTG-ADMIN-STATUS']);
		session_destroy();
		echo "<meta http-equiv='refresh' content='0;url=/update/index.php'>";
	}

	if(isset($_SESSION['LTG-ADMIN-ID'])){
		echo "<meta http-equiv='refresh' content='0;url=/home/'>";
		die();
	}
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>UPDATE | LT GALLERY</title>
    <link rel="shortcut icon" href="../static/icons/favicon.png">
    <link rel="stylesheet" type="text/css" href="../static/css/general.css"/>
    <link rel="stylesheet" type="text/css" href="../static/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="../static/css/cms.css"/>
    <script type='text/javascript' src='../static/js/jquery.js'></script>
</head>

<?php
	extract($_POST);
	$prompt=1;
	//not logged in
	if(@$login){
		@$email=sanitizeInput($email);
		@$password=sanitizeInput($password);

		$query="SELECT `salt` FROM `users` WHERE `email`='".@$email."' AND `status`='1'";

		$result=runQuery($query);
		if(numRows($result)==1){
			$row=fetchArray($result);
			foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}

			@$password=encryptPassword($password,$salt);

			$query="SELECT * FROM `users` WHERE `email`='".@$email."' AND `password`='".@$password."'";

			$result=runQuery($query);

			if(numRows($result)==1){ 
				$row = fetchArray($result);
				foreach($row as $key => $item){$$key = stripslashes(($row[$key]));}
				@session_regenerate_id ();
				$_SESSION['LTG-ADMIN-STATUS']="LOGIN-OK-PROCEED";
				$_SESSION['LTG-ADMIN-ID']=$id;

				echo "<meta http-equiv='refresh' content='0;url=home/'>";
				$prompt=0;
			}
			else{
				$error="Invalid username or password. Please try again.";
			}
		}
		else{
			$error="Invalid username or password. Please try again.";
		}
	}
?>

<?php if(@$prompt){ ?>

	<body>

		<!--Container-->
		<div style="position:relative; margin:0px auto; margin-top:100px; width:850px;">

			<div class="textCenter">

				<a href="index.php">
					<img src="../static/images/logo1-white.png" width="200px"/>
				</a>


				<div class="topSpacerBig medium white">
				Access LT GALLERY's<br  /> 
				update interface.<br />	
				</div>

				<?php if(@$error){echo "<div class='topSpacer red'>".$error."</div>";}?>

				<form action="index.php" method="post" class="topSpacer">

					<div>
						<input class="login small" type="text" name="email" value="Username" maxlength="30" onblur="if (this.value== '' || !this.value) {this.value= 'Username';}" onfocus="if (this.value == 'Username') {this.value= '';}" autocomplete="off" />
					</div>

					<div class="topSpacer">
						<input class="login small" type="password" name="password" value="password" maxlength="20" onblur="if (this.value== '' || !this.value) {this.value= 'Password';}" onfocus="if (this.value == 'password') {this.value= '';}" autocomplete="off" />
					</div>

					<div class="topSpacer">
						<input class="login small" type="submit" name="login" value="LOGIN" />
					</div>
				</form>

			</div>

		</div>
		<!--End Container-->

	</body>

<?php } ?>

</html>