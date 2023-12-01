<?php

	@extract(@$_POST);

	include("../global/global.php");

	$reason=sanitizeInput($reason);
	$fullname=sanitizeInput($fullname);
	$phone=sanitizeInput($phone);
	$email=sanitizeInput($email);
	$message=sanitizeInput($message);

	$subject="New Contact Message";

	$messageTxt="Reason: ".$reason."<br />";
	$messageTxt.="Full Name: ".$fullname."<br />";
	$messageTxt.="Phone: ".$phone."<br />";
	$messageTxt.="Email: ".$email."<br />";
	$messageTxt.="Message: ".$message."<br />";

	runQuery("INSERT INTO `contactus` (`reason`,`name`,`phone`,`email`,`message`) VALUES('".$reason."' , '".$fullname."' , '".$phone."' , '".$email."' , '".$message."')");
		
	$headers = [
		'From' => 'LT GALLERY <info@domain.com>',
		'X-Sender' => 'LT GALLERY <info@domain.com>',
		'X-Mailer' => 'PHP/' . phpversion(),
		'X-Priority' => '1',
		'Return-Path' => 'info@domain.com',
		'MIME-Version' => '1.0',
		'Content-Type' => 'text/html; charset=iso-8859-1'
	];

	mail('info@domain.com', $subject, $messageTxt, $headers);
	
	echo "1";

?>
