<?php

	if(!isset($_SESSION)) {
		@session_start();
	}
	$dbLink = new mysqli("localhost", "root", "test","lt-gallery");

	/* check connection */
	if ($dbLink->connect_errno) {
		die("Connect failed: ".$dbLink->connect_error);
	}

	$dbLink->set_charset("UTF8");

	function runQuery($query){
		global $dbLink;
		if($result=$dbLink->query($query)){
			return $result;
		}else{
			echo $dbLink->error;
		}
	}

	function numRows($result){
		return $result->num_rows;
	}
	function insertedId(){
		global $dbLink;
		return $dbLink->insert_id;
	}

	function fetchArray($result){
		return $result->fetch_array();
	}
	
?>