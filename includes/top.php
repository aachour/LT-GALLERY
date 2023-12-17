<?php 
	include("../global/global.php");
?>

<!doctype html>
<html>

<head>

	<base href="../" />

	<!-- <base href="https://domain.com/" /> -->

	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>

	<meta name="viewport" content="width=320, initial-scale=1, user-scalable=yes">

    <title><?php echo @$PAGE_TITLE; ?></title>

	<link rel="shortcut icon" href="static/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="static/css/general.css">
    <link rel="stylesheet" type="text/css" href="static/css/style.css">
	<link rel="stylesheet" type="text/css" href="static/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="static/css/popup.css">
	<link rel="stylesheet" type="text/css" href="static/css/elements.css">

	<script language="javascript" type="text/javascript" src="static/js/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="static/js/jquery-ui.js"></script>
	<script language="javascript" type="text/javascript" src="static/js/bootstrap.js"></script>
	<script language="javascript" type="text/javascript" src="static/js/swiper.min.js"></script>
	<script language="javascript" type="text/javascript" src="static/js/masonry.js"></script>
	
	<?php
		/*if(@$CURRENT_SECTION=="HOME"){
			echo'<meta property="og:url" content="https://domain.com/" />
			<meta property="og:title" content="domain" />
			<meta property="og:image" content="https://domain.comstatic/images/logo-share.png" />
			<meta property="og:description" content="" />';
		}*/
	?>

</head>

<body>
	
	<div id="page">

		<!------Header Desktop-->
		<div class="header onlyDesktop">

			<div class="content">

				<a href="home/">
					<div class="col1">
						<img src="static/images/logo2-black.png" width="150px" />
					</div>
				</a>

				<div class="col2">
					<div class="nav textRight">
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="EXHIBITIONS"){echo "red";}else{echo "blackRed";}?>" href="exhibitions/">Exhibitions</a>
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="ARTISTS"){echo "red";}else{echo "blackRed";}?>" href="artists/">Artists</a>
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="PODCASTS"){echo "red";}else{echo "blackRed";}?>" href="podcasts/">Podcasts</a>
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="NEWS"){echo "red";}else{echo "blackRed";}?>" href="news/">News</a>
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="ABOUT US"){echo "red";}else{echo "blackRed";}?>" href="about/">About</a>
						<a class="small proximaMd <?php if(@$CURRENT_SECTION=="CONTACT US"){echo "red";}else{echo "blackRed";}?>" href="contactus/">Contact Us</a>
					</div>
				</div>

				<div class="clear"></div>

			</div>

		</div>

		<div class="rightLine onlyDesktop"></div>
			
		<!-- <div class="burger clickable onlyMobile" id="burger1"></div> -->

		<!--Menu
		<div id="mobileMenu" class="textRight hidden">

			<div class="burger clickable" id="burger2"></div>
			<div class="clear"></div>

			<div class="topSpacerBigger">
				<a class="small proximaMd <?php if(@$CURRENT_SECTION=="HOME"){echo "red";}else{echo "blackRed";}?>" href="home/">Home</a>
			</div>
			<div class="topSpacerBigger">
				<a class="small proximaMd <?php if(@$CURRENT_SECTION=="PUBLICATIONS"){echo "red";}else{echo "blackRed";}?>" href="publications/">Publications</a>
			</div>
			<div class="topSpacer">
				<a class="small proximaMd <?php if(@$CURRENT_SECTION=="ABOUT US"){echo "red";}else{echo "blackRed";}?>" href="aboutus/">About Us</a>
			</div>
			<div class="topSpacer">
				<a class="small proximaMd <?php if(@$CURRENT_SECTION=="CONTACT US"){echo "red";}else{echo "blackRed";}?>" href="contactus/">Contact Us</a>
			</div>

		</div>-->


		<script>

			$(window).load(function(){
			
			});

			$(window).resize(function(){
			
			});
			
			$(document).ready(function(){	

				$("#burger1").click(function(){
					$("#mobileMenu").removeClass("hidden");
				});

				$("#burger2").click(function(){
					$("#mobileMenu").addClass("hidden");
				});

			});

		</script>
