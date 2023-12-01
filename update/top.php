<?php
    include('../../global/global.php');
    include('../../global/SimpleImage.php');

	if(checkAdminLogin()==0){
		die(header("location:../../"));
	}

	runQuery("SET NAMES 'utf8'");
	runQuery('SET CHARACTER SET utf8');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>UPDATE | LT GALLERY</title>
    <link rel="shortcut icon" href="../../static/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="../../static/css/general.css"/>
    <link rel="stylesheet" type="text/css" href="../../static/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="../../static/css/cms.css"/>
    <link rel="stylesheet" type="text/css" href="../../static/css/popup.css"/>
    
    <script type='text/javascript' src='../../static/js/jquery.js'></script>
    <script type="text/javascript" src="../../static/js/jquery-ui.js"></script>
    
</head>

<body>

    <div id="top" style="position:relative; width:100%; padding:30px 0px;">

        <div class="content">

            <div style="float:left; margin-top:20px;">
                <a href="../home"><img src="../../static/images/logo.png" width="40px" /></a>
            </div>

            <div class="black small" style="float:right;">

                <a class="<?php if(@$section=="HOME"){echo"grey underline";}else{echo"blackGrey";}?>" href="../home/index.php">Home</a> &nbsp;|&nbsp;

                <a class="<?php if(@$section=="TOP BANNER"){echo"grey underline";}else{echo"blackGrey";}?>" href="../topBanner/index.php">Top Banner</a> &nbsp;|&nbsp;

                <a class="<?php if(@$section=="EXEBITIONS"){echo"grey underline";}else{echo"blackGrey";}?>" href="../exebitions/index.php">Exebitions</a> &nbsp;|&nbsp;
                
                <a class="<?php if(@$section=="ARTISTS"){echo"grey underline";}else{echo"blackGrey";}?>" href="../artists/index.php">Artists</a> &nbsp;|&nbsp;

                <a class="<?php if(@$section=="PODCASTS"){echo"grey underline";}else{echo"blackGrey";}?>" href="../podcasts/index.php">Poscasts</a> &nbsp;|&nbsp;
                
                <a class="<?php if(@$section=="NEWS"){echo"grey underline";}else{echo"blackGrey";}?>" href="../news/index.php">News</a> &nbsp;|&nbsp;

                <a class="<?php if(@$section=="ABOUT US"){echo"grey underline";}else{echo"blackGrey";}?>" href="../aboutus/index.php">About Us</a> &nbsp;|&nbsp;

                <br /><br />

                <a class="<?php if(@$section=="CONTACT US"){echo"grey underline";}else{echo"blackGrey";}?>" href="../contactus/index.php">Contact Us</a> &nbsp;|&nbsp;
                
                <a class=" <?php if(@$section=="CHANGE PASSWORD"){echo"grey underline";}else{echo"blackGrey";}?>" href="../home/edit.php">Change Password</a> &nbsp;|&nbsp;

                <a class="blackGrey small" href="../../update/index.php?logout=1">Logout</a>

            </div>

            <div class="clear"></div>

  		</div>

    </div>