<?php

	@extract(@$_POST);

	include("../global/global.php");

	$fname=sanitizeInput($fname);
	$lname=sanitizeInput($lname);
	$email=sanitizeInput($email);
	$phone=sanitizeInput($phone);
	$reason=sanitizeInput($reason);
	$message=sanitizeInput($message);

	$subject="New Contact Message";

	$messageTxt.="First Name: ".$fname."<br />";
	$messageTxt.="Last Name: ".$lname."<br />";
	$messageTxt.="Email: ".$email."<br />";
	$messageTxt.="Phone: ".$phone."<br />";
	$messageTxt.="Reason: ".$reason."<br />";
	$messageTxt.="Message: ".$message."<br />";

	runQuery("INSERT INTO `contactus` (`fname`,`lname`,`email`,`phone`,`reason`,`message`) VALUES('".$fname."' , '".$lname."' , '".$email."' , '".$phone."' , '".$reason."' , '".$message."')");
		
	// $headers = [
	// 	'From' => 'LT GALLERY <info@domain.com>',
	// 	'X-Sender' => 'LT GALLERY <info@domain.com>',
	// 	'X-Mailer' => 'PHP/' . phpversion(),
	// 	'X-Priority' => '1',
	// 	'Return-Path' => 'info@domain.com',
	// 	'MIME-Version' => '1.0',
	// 	'Content-Type' => 'text/html; charset=iso-8859-1'
	// ];

	// mail('info@domain.com', $subject, $messageTxt, $headers);
	
	echo "1";

?>
