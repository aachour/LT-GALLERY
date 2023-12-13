<?php

	require_once("connect.php");

	
	if(!isset($_SESSION)) {
		@session_start();
	}


	function checkAdminLogin(){
		if(isset($_SESSION['LTG-ADMIN-STATUS']) && @$_SESSION['LTG-ADMIN-STATUS']=="LOGIN-OK-PROCEED"){
			return 1;//all ok
		}else{
			return 0;
		}
	}



	function checkLetters($var){
		if(preg_match( '/[a-zA-Z]/', $var )){
			return 1;
		}
		else{
			return 0;
		}
	}


	function checkSpecialChar($var){
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $var)){
			return 1;
		}
		else{
			return 0;
		}
	}


	function checkNumbers($var){
		if(preg_match('/[0-9]/', $var)){
			return 1;
		}
		else{
			return 0;
		}
	}


	function checkQueryString($var){

		if(preg_match('/SELECT(.+?)FROM/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/UPDATE(.+?)SET/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/DELETE(.+?)FROM/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/INSERT(.+?)INTO/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/DROP TABLE/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/ALTER TABLE/', strtoupper($var))){
			return 1;
		}

		if(preg_match('/CREATE TABLE/', strtoupper($var))){
			return 1;
		}

		return 0;

	}


	function checkURI(){
		$uri=$_SERVER['REQUEST_URI']; //echo $uri."<br />";

		$slashCount=substr_count($uri, '/'); //echo $slashCount;
		if($slashCount>3){
			echo "<meta http-equiv='refresh' content='0;url=https://www.handiss.com/page/404/'>";
			die();
		}
	}


	function checkURIMobile(){
		$uri=$_SERVER['REQUEST_URI'];

		$slashCount=substr_count($uri, '/');
		if($slashCount>4){
			echo "<meta http-equiv='refresh' content='0;url=https://www.handiss.com/page/404/'>";
			die();
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Input handling
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function isEmpty($text){
		$text = trim($text);
		$text = strip_tags($text);
		if(!isset($text) || trim($text)==""){
			return true;
		}else{
			return false;
		}
	}


	function validEmail( $email ){
		return filter_var( @$email, FILTER_VALIDATE_EMAIL );
	}


	function echoYearDropDown($fieldName,$currentValue,$start,$end,$class="",$style="",$lastValue=""){

		echo "<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
			<option value=''>Year</option>
			";


		$current=$start;
		if($start>$end){
			while(@$current>=$end){
				if($current==$currentValue){
					echo "<option value='".$current."' selected='selected'>".$current."</option>
					";
				}else{
					echo "<option value='".$current."'>".$current."</option>
					";
				}
				$current--;
			}
		}else{
			while(@$current<=$end){
				if($current==$currentValue){
					echo "<option value='".$current."' selected='selected'>".$current."</option>
					";
				}else{
					echo "<option value='".$current."'>".$current."</option>
					";
				}
				$current++;
			}
		}

		if($lastValue!="" && @$currentValue!=$lastValue){
			echo'<option value="Present">Present</option>';
		}else if($lastValue!="" && @$currentValue==$lastValue){
			echo'<option value="Present" selected>Present</option>';
		}

		echo "
		</select>";
	}


	function echoMonthDropDown($fieldName,$currentValue,$class="",$style=""){
		echo "<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
		<option value=''>Month</option>
		";
		$i=1;
		while(@$i<=12){
			if($i==$currentValue){
				echo "<option value='".$i."' selected='selected'>".date("F",mktime(0, 0, 0, ($i)))."</option>
				";
			}else{
				echo "<option value='".$i."'>".date("F",mktime(0, 0, 0, ($i)))."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function echoDayDropDown($fieldName,$currentValue,$class="",$style=""){
		echo "<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
		<option value=''>Day</option>
		";
		$i=1;
		while(@$i<=31){
			if($i==$currentValue){
				echo "<option value='".$i."' selected='selected'>".date("d",mktime(0, 0, 0,0, ($i)))."</option>
				";
			}else{
				echo "<option value='".$i."'>".date("d",mktime(0, 0, 0,0, ($i)))."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function echoFileUpload($fieldName,$currentValue,$folder,$pageVars="",$required="",$image=""){
		global $entryId;
		global $languageToken;
		if(isset($currentValue) && $currentValue!="" ){
			if($image!=""){
				echo "<img align='left' width='40' style='margin-right:10px;' src=".str_replace("images","thumbs",$folder).$currentValue." />";
			}
			echo "<div>A file has been uploaded. ";
			echo "<a href='".$folder.$currentValue."' target='_blank'>View file</a>";
			if($required==""){echo "- <a class='deleteFile' href='".currentPage()."?deleteFile=1&id=".$entryId."&column=".$fieldName.$pageVars."'>Delete file</a>";}

			echo "<br /></div>
				<input type='file' class='input' value='".$currentValue."' name='".$fieldName."' id='".$fieldName."' />";
		}else{
			echo "<input type='file' class='input' name='".$fieldName."' id='".$fieldName."' />";
		}

	}


	function echoTextField($fieldName,$currentValue,$class=""){
		echo "<input type='text' class='input ".$class."' name='".$fieldName."' id='".$fieldName."' value='".$currentValue."' />";
	}


	function echoPassword($fieldName,$currentValue,$class=""){
		echo "<input type='password' class='input ".$class."' name='".$fieldName."' id='".$fieldName."' value='' />";
	}


	function echoTextArea($fieldName,$currentValue,$class=""){
		echo "<textarea class='input ".$class."' name='".$fieldName."' id='".$fieldName."'>".$currentValue."</textarea>";
	}


	function echoCheckBox($fieldName,$currentValue="off"){
		if($currentValue=="on"){
			echo "<input type='checkbox' checked='TRUE' name='".$fieldName."' id='".$fieldName."' />";
		}else{
			echo "<input type='checkbox' name='".$fieldName."' id='".$fieldName."' />";
		}
	}


	function echoDBCheckBox($fieldName,$currentValues,$table,$idColumn,$valueColumn,$extendedQuery=""){
		if($extendedQuery==""){
			$result=runQuery("select * from ".$table."");
		}else{
			$result=runQuery("select * from ".$table." ".$extendedQuery."");
		}
		while($row = fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			if(count($currentValues)>0 && in_array($$idColumn,$currentValues)){
				echo "<input checked type='checkbox' name='".$fieldName."[]' value=\"".$$idColumn."\"> ".$$valueColumn."</option><br /><br />";
			}else{
				echo "<input type='checkbox' name='".$fieldName."[]' value=\"".$$idColumn."\"> ".$$valueColumn."</option><br /><br />";
			}
		}
	}


	function selectExistingDBCheckBox($fieldName,$keysTable,$leftColumn,$rightColumn){
		global $entryId;

		$query="select * from ".$keysTable." where ".$leftColumn."=".$entryId."";
		$result=runQuery($query);
		$temp=array();
		$i=0;
		while ($row=fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			$temp[]=$$rightColumn;
		}
		return $temp;
	}


	function updateDBCheckBox($fieldName,$keysTable,$leftColumn,$rightColumn){
		global $entryId;
		$result=runQuery("delete from ".$keysTable." where ".$leftColumn."=".$entryId."");
		$i=0;
		while($i<count($fieldName)){
			$query="insert into ".$keysTable." (".$leftColumn.", ".$rightColumn.") values (".$entryId.",".$fieldName[$i].")";
			runQuery($query);
			$i++;
		}
	}


	function echoRadioButton($fieldName,$currentValue, $values,$hideValues="YES"){
		$i=0;
		while(@$values[$i]!=NULL){
			$value=$values[$i];
			if($i>0){
				echo "<br />";
			}
			if($currentValue == $value){
				echo "<input type='radio' class='radioInput' checked='TRUE' name='".$fieldName."' id='".$fieldName."' value='".$value."' /> ";
				if($hideValues=="NO"){
					echo $value;
				}
			}else{
				echo "<input type='radio' class='radioInput' name='".$fieldName."' id='".$fieldName."' value='".$value."' /> ";
				if($hideValues=="NO"){
					echo $value;
				}
			}
			$i++;
		}
	}


	function echoDBRadioButton($fieldName,$currentValue,$table,$idColumn,$valueColumn,$extendedQuery="",$overrideQuery=""){
		if($extendedQuery==""){
			$result = runQuery("SELECT * FROM ".$table." order by ".$valueColumn." ASC");
		}else{
			$result = runQuery("SELECT * FROM ".$table." ".$extendedQuery." ");
		}
		if($overrideQuery!=""){
			$result = runQuery($overrideQuery);
		}

		while($row = fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			if($$idColumn==$currentValue){
				echo "<input type='radio' class='radioInput' checked='TRUE' name='".$fieldName."' id='".$fieldName."' value='".$$idColumn."' /> ".$$valueColumn."<br />
				";
			}else{
				echo "<input type='radio' class='radioInput' name='".$fieldName."' id='".$fieldName."' value='".$$idColumn."' /> ".$$valueColumn."<br />
				";
			}
		}
	}


	function echoDropDown($fieldName,$currentValue,$valuesArray,$optional="YES",$class="",$style=""){
		echo "
		<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
		";
		if($optional=="YES"){
		echo "<option value=''></option>";
		}
		$i=0;
		while(@$value=$valuesArray[$i]){
			if($value==$currentValue){
				echo "<option value=\"".$value."\" selected='selected'>".$value."</option>
				";
			}else{
				echo "<option value=\"".$value."\">".$value."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function echoDBDropDown($fieldName,$currentValue,$table,$idColumn,$valueColumn,$extendedQuery="",$overrideQuery="",$class="",$style="",$optionValue=""){
		if($extendedQuery==""){
			$result = runQuery("SELECT * FROM `".$table."` order by ".$valueColumn." ASC");
		}else{
			$result = runQuery("SELECT * FROM `".$table."` ".$extendedQuery." ");
		}
		if($overrideQuery!=""){
			$result = runQuery($overrideQuery);
		}
		echo "
		<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
			<option value=''>".$optionValue."</option>
		";
		$i=0;

		while($row = fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			if($$idColumn==$currentValue){
				echo "<option value=\"".$$idColumn."\" selected='selected'>".$$valueColumn."</option>
				";
			}else{
				echo "<option value=\"".$$idColumn."\">".$$valueColumn."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function echoDBDropDown2($fieldName,$currentValue,$table,$idColumn,$valueColumn1,$valueColumn2,$class="",$style="",$optionValue=""){

		$result = runQuery("SELECT * FROM `".$table."` order by `id` ASC");

		echo "
		<select class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
			<option value=''>".$optionValue."</option>
		";
		$i=0;

		while($row = fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			if($$idColumn==$currentValue){
				echo "<option value=\"".$$idColumn."\" selected='selected'>".$$valueColumn1.", ".$$valueColumn2."</option>
				";
			}else{
				echo "<option value=\"".$$idColumn."\">".$$valueColumn1.", ".$$valueColumn2."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function echoDBMultiple($fieldName,$currentValue,$table,$idColumn,$valueColumn,$extendedQuery="",$overrideQuery="",$class="",$style=""){
		if($extendedQuery==""){
			$result = runQuery("SELECT * FROM ".$table." order by ".$valueColumn." ASC");
		}else{
			$result = runQuery("SELECT * FROM ".$table." ".$extendedQuery." ");
		}
		if($overrideQuery!=""){
			$result = runQuery($overrideQuery);
		}
		echo "
		<select multiple class='input ".$class."' style='".$style."' name='".$fieldName."' id='".$fieldName."'>
			<option value=''></option>
		";
		$i=0;

		while($row = fetchArray($result)){
			foreach($row as $key => $item){$$key = stripslashes(($row[$key] ?? ''));}
			if(in_array($$idColumn,$currentValue)){
				echo "<option value=\"".$$idColumn."\" selected='selected'>".$$valueColumn."</option>
				";
			}else{
				echo "<option value=\"".$$idColumn."\">".$$valueColumn."</option>
				";
			}
			$i++;
		}
		echo "
		</select>";
	}


	function sanitizeInput($input,$html="NO"){
		$input=@trim($input);
		if($html!="HTML"){
			$input = htmlentities($input,ENT_QUOTES,"UTF-8");
		}
		// if (!@get_magic_quotes_gpc()){
		// 	$input=addslashes($input);
		// }

		
		return addslashes(trim($input));
	}


	function fixFileName($fileName){
		$fileName = str_replace("#", "", $fileName);
		$fileName = str_replace("$", "", $fileName);
		$fileName = str_replace("%", "", $fileName);
		$fileName = str_replace("^", "", $fileName);
		$fileName = str_replace("&", "", $fileName);
		$fileName = str_replace("*", "", $fileName);
		$fileName = str_replace("?", "", $fileName);
		$fileName = str_replace("_", "", $fileName);
		$fileName = str_replace("'","",$fileName);
		$fileName = str_replace("\"","",$fileName);
		$fileName = str_replace("\\","",$fileName);
		$fileName = str_replace("/","",$fileName);
		$fileName = str_replace(" ","",$fileName);
		$fileName = preg_replace("/[^A-Za-z0-9. ]/", '', $fileName);
		return($fileName);
	}


	function safeLink($link){
		if(@$link){
			$temp=substr($link, 0,7);
			$temp2=substr($link, 0,8);

			if($temp!="http://" && $temp2!="https://"){
				$link="http://".$link;
			}
		}
		return $link;
	}


	function printArray($array, $sep=", "){
		$i=0;
		$result="";
		while($i<count($array)){
			$result.=$array[$i];
			$i++;
			if($i<count($array)){
				$result.=$sep;
			}
		}
		return $result;
	}


	function allowedExtension($file, $extensions=NULL){
		if($extensions!=NULL){
			//extensions specified
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if(in_array($ext,$extensions)) {
				return 1;
			}else{
				return 0;
			}
		}else{
			//allow all
			return 1;
		}

	}


	function uploadImage($var, $width, $height, $t_width, $t_height){

		global $table, $entryId, $folder,$error, $site_root;
		$image="";
		if(@$_FILES[$var]["name"]){
				//if an image was uploaded

				//check for correct extension
				$extensions=array("jpg", "jpeg", "gif", "png");
				if(!allowedExtension($_FILES[$var]['name'],$extensions)){
					$error.="<br />Please make sure the uploaded file extension is correct.<br />";
					$image="";
				}else{
					//delete existing image
					if(!isEmpty(@$entryId)){
						$query="SELECT ".$var." FROM `".$table."` WHERE id=".$entryId."";
						$row = fetchArray(runQuery($query));
						if(@$row[0]){//if an image exists
							//remove the image
							@unlink($folder."originals/".stripslashes($row[0]));
							@unlink($folder."thumbs/".stripslashes($row[0]));
							@unlink($folder."images/".stripslashes($row[0]));
						}
					}



					$image = date('U')."-".$var."-".$_FILES[$var]["name"];
					$image = fixFileName($image);
					move_uploaded_file($_FILES[$var]["tmp_name"],$folder."originals/".$image);


					/*
					$target_url = $site_root.'/upload.php?';
					$file_name_with_full_path = realpath($folder."originals/".$image);
					$post = array('w' => $width,'h' => $height,'tw' => $t_width,'th' => $t_height, 's' => 'ISL-SECRET-57bee9c2e8ad0ed715a76c9f703f95ee5cc977e3', 'd' => str_replace('.','',str_replace('/','',$folder)),'file_contents'=>'@'.$file_name_with_full_path);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$target_url);
					curl_setopt($ch, CURLOPT_POST,1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					//$result=curl_exec ($ch);
					curl_close ($ch);
					*/



					$temp = new SimpleImage();

					$temp->load($folder."originals/".$image);

					$temp->resize($width,$height);

					$temp->save($folder."images/".$image);

					$temp->load($folder."originals/".$image);
					$temp->resize($t_width,$t_height);
					$temp->save($folder."thumbs/".$image);
					$image = sanitizeInput($image);
				}
			}else{
				//no image uploaded, keep the same
				if($entryId!=NULL && $entryId!=""){
					$query="SELECT `".$var."` FROM `".$table."` WHERE id='".$entryId."'";
					$row = fetchArray(runQuery($query));
					$image = @$row[0];
				}
			}

			return $image;
	}


	function uploadFileSimple($var){
		global $folder;
		$file="";
		if(@$_FILES[$var]["name"]){
			$file = date('U')."-".$var."-".$_FILES[$var]["name"];
			$file = fixFileName($file);
			move_uploaded_file($_FILES[$var]["tmp_name"],$folder."files/".$file);
			$file = sanitizeInput($file);
		}
		return $file;
	}


	function uploadFile($var){
		global $table, $entryId, $folder, $site_root;
		$file="";
		if(@$_FILES[$var]["name"]){
				//if a file was uploaded
				//delete existing file
				if(!isEmpty(@$entryId)){
					$query="SELECT ".$var." FROM `".$table."` WHERE id=".$entryId."";
					$row = fetchArray(runQuery($query));
					if(@$row[0]){//if a file exists
						//remove the file
						@unlink($folder."files/".stripslashes($row[0]));
					}
				}
				$file = date('U')."-".$var."-".$_FILES[$var]["name"];
				$file = fixFileName($file);

				move_uploaded_file($_FILES[$var]["tmp_name"],$folder."files/".$file);

				$file = sanitizeInput($file);
			}else{

				//no file uploaded, keep the same
				if($entryId!=NULL && $entryId!=""){
					$query="SELECT ".$var." FROM `".$table."` WHERE id=$entryId";
					$row = fetchArray(runQuery($query));
					$file = @$row[0];
				}
			}

			return $file;
	}


	function handleFileDelete(){

		global $deleteFile,$doDeleteFile,$entryId,$column,$table,$folder,$prompt;

		$basePage= strtok(currentPage(),"?");

		if(@$deleteFile){
			echo "<div class='content'><div class='error'>";
			echo "<br />Are you sure you want to delete this file?<br /><br /></div>";
			echo "<form action='".$basePage."' method='post'>";
			echo "<input type='hidden' name='id' value='".$entryId."' />";
			echo "<input type='hidden' name='column' value='".$column."' /><br />";
			echo "<input class='button cancel' type='submit' name='doNothing' value='No' />";
			echo "<input class='button ok' type='submit' name='doDeleteFile' value='Yes' />";
			echo "</form></div><br />";

			$prompt=0;
		}
		if(@$doDeleteFile){
		//remove the file first

			$row = fetchArray(runQuery("SELECT ".$column." FROM ".$table." WHERE id='".$entryId."'"));
			if(@$row[0]){//if an image exists
				//remove the file
				@unlink($folder."originals/".stripslashes($row[0]));
				@unlink($folder."thumbs/".stripslashes($row[0]));
				@unlink($folder."images/".stripslashes($row[0]));
				@unlink($folder."files/".stripslashes($row[0]));
			}

			//remove db entry
			$query="UPDATE ".$table." SET
			".$column."=\"\"
			WHERE
			id=".$entryId."";

			runQuery($query);

			echo "<div class='content'><div class='msg'><br />File deleted.<br /><br /></div></div><br />";
			echo "<meta http-equiv='refresh' content='2;url=edit.php?id=".$entryId."'>";

			$prompt=0;
		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Replace last occurance
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function str_lreplace($search, $replace, $subject){
		return preg_replace('~(.*)' . preg_quote($search, '~') . '(.*?)~', '$1' . $replace . '$2', $subject, 1);
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Random string
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	function rand_string( $length ) {
		$str="";
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-.=()[]*:|";

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Truncate
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function wordCount($string){
		//return (str_word_count($string));
		$string = htmlspecialchars_decode(strip_tags($string));
		if (strlen($string)==0){
			return 0;
		}
		$t = array(' '=>1, "\x20"=>1, "\xA0"=>1, "\x0A"=>1, "\x0D"=>1, "\x09"=>1, "\x0B"=>1, "\x2E"=>1, "\t"=>1); // separators
		$count= isset($t[$string[0]])? 0:1;
		if (strlen($string)==1){
			return $count;
		}
		for ($i=1;$i<strlen($string);$i++){
			if (isset($t[$string[$i-1]]) && !isset($t[$string[$i]])){ // if new word starts
				$count++;
			}
		}
		return $count;
	}

	/*
	function truncate($string, $max, $rep){
	$phrase_array = explode(' ',$string);
	if(count($phrase_array) > $max && $max > 0){
		$string = implode(' ',array_slice($phrase_array, 0, $max)).$rep;
	}
	return closeTags($string);
	}
	*/


	//+ Jonas Raoni Soares Silva
	//@ http://jsfromhell.com

	function truncate($text, $length, $suffix = '&hellip;', $isHTML = true) {
		$text= "<div>".cleanBody($text);
		$i = 0;
		$simpleTags=array('br'=>true,'hr'=>true,'input'=>true,'image'=>true,'link'=>true,'meta'=>true);
		$tags = array();
		if($isHTML){
			preg_match_all('/<[^>]+>([^<]*)/', $text, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
			foreach($m as $o){
				if($o[0][1] - $i >= $length){
					break;
				}
				$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
				// test if the tag is unpaired, then we mustn't save them
				if($t[0] != '/' && (!isset($simpleTags[$t])))
					$tags[] = $t;
				elseif(end($tags) == substr($t, 1))
					array_pop($tags);
				$i += $o[1][1] - $o[0][1];
			}
		}

		// output without closing tags
		$output = substr($text, 0, $length = min(strlen($text),  $length + $i));
		// closing tags
		$output2 = (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '');

		// Find last space or HTML tag (solving problem with last space in HTML tag eg. <span class="new">)
		@$pos = (int)end(end(preg_split('/<.*>| /', $output, -1, PREG_SPLIT_OFFSET_CAPTURE)));
		// Append closing tags to output
		$output.=$output2;

		// Get everything until last space
		$one = substr($output, 0, $pos);
		// Get the rest
		$two = substr($output, $pos, (strlen($output) - $pos));
		// Extract all tags from the last bit
		preg_match_all('/<(.*?)>/s', $two, $tags);
		// Add suffix if needed
		if (strlen($text) >= $length) { $one .= $suffix; }
		// Re-attach tags
		$output = $one . implode($tags[0]);

		//added to remove  unnecessary closure
		$output = str_replace('</!-->','',$output);

		return $output;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Close Tags
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function closeTags($html) {
		//put all opened tags into an array
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);

		//put all closed tags into an array
		$openedtags = $result[1];
		preg_match_all('#</([a-z]+)>#iU', $html, $result);

		$closedtags = $result[1];
		$len_opened = count($openedtags);

		//all tags are closed
		if (count($closedtags) == $len_opened) {
			return $html;
		}

		$openedtags = array_reverse($openedtags);

		//close tags
		for ($i=0; $i < $len_opened; $i++) {

			if (!in_array($openedtags[$i], $closedtags)){
				$html .= '</'.$openedtags[$i].'>';
			}else {

				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			}

		}
		return $html;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Get Current Page
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function currentPage() {

		$pageURL = 'http';
		if (@$_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		$pageURL=preg_replace('/&/i', '%26', $pageURL);
		$pageURL=preg_replace('/\'/i', '%27', $pageURL);
		return $pageURL;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Page Numbering
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function createNumbering($current, $total, $perPage=15, $args=""){
		$basePage= strtok(currentPage(),"?");

		if(!$current){
			$current=1;
		}

		@$pages = ceil($total/$perPage);
		if(!$total){
			$pages=0;
		}

		if($pages<2){
			return;
		}else if($pages<6){// 1 - 2 - 3 - 4 - 5
			$i=1;
			while($i<=$pages){
				if($i<$pages){
					//all pages but last
					if($i==$current){
							echo "<a class='currentPage'>$i</a> ";
					}else{
							echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
					}
				}else{
					//last one
					if($i==$current){
							echo "<a class='currentPage'>$i</a>";
					}else{
							echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a>";
					}
				}
				$i++;
			}

		}else{
			if($current<4){// 1 - 2 -3 - 4 - 5 Last
				$i=1;
				while($i<5){
					if($i==$current){
							echo "<a class='currentPage'>$i</a> ";
					}else{
							echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
					}
					$i++;
				}
				if($i==$current){
					echo "<a class='currentPage'>$i</a>";
				}else{
					echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a>&nbsp;&nbsp;&nbsp;";
				}
				echo "<a class='otherPage' href='$basePage?page=$pages$args'>$pages</a>";

			}else if($current > ($pages-3)){// First 2 - 3 - 4 - 5 - 6
				echo "<a class='otherPage' href='$basePage?page=1$args'>1</a>&nbsp;&nbsp;&nbsp;";
				$i=$pages-4;
				while ($i<$pages){
					if($i==$current){
							echo "<a class='currentPage'>$i</a> ";
					}else{
							echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
					}
					$i++;
				}
				if($i==$current){
					echo "<a class='currentPage'>$i</a>";
				}else{
					echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a>&nbsp;&nbsp;&nbsp;";
				}

			}else{// First 2 - 3 - 4 - 5 - 6 Last
				echo "<a class='otherPage' href='$basePage?page=1$args'>1</a>&nbsp;&nbsp;&nbsp;";

				$i=$current-2;
				echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
				$i++;
				echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
				$i++;
				echo "<a class='currentPage'>$i</a> ";	// current page
				$i++;
				echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a> ";
				$i++;
				echo "<a class='otherPage' href='$basePage?page=$i$args'>$i</a>";
				$i++;

				echo "&nbsp;&nbsp;&nbsp;<a class='otherPage' href='$basePage?page=$pages$args'>$pages</a>";
			}

		}

	}


	function cleanBody($text){
		$text = removeStyles($text);
		//$text = strip_tags($text,"<br />,<br>,<b>,<strong>,<i>,<em>,<u>,<ul>,<li>,<ol>,<span>,<a>,<p>,<table>,<tbody>,<tr>,<td>,<img>,<div>");
		$text = strip_tags($text,"<br />,<br>,<b>,<strong>,<i>,<em>,<u>,<ul>,<li>,<ol>,<span>,<a>,<p>");
		return $text;
	}


	function removeStyles($text){
		$text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
		return $text;
	}


	function strToHex($string){
		$hex='';
		for ($i=0; $i < strlen($string); $i++)
		{
			$hex .= dechex(ord($string[$i]))."#";
		}
		return $hex;
	}


	function detectArabic($string){
		//$string = strtok($string, ".");
		//$string.=strtok(".");//first two sentences only
		$hex=strTohex($string);
		//common characters:1234567890
		// .":{}[]()
		//+-=/*%#$!,
		$hex=str_replace('30#','',$hex);$hex=str_replace('31#','',$hex);$hex=str_replace('32#','',$hex);$hex=str_replace('33#','',$hex);$hex=str_replace('34#','',$hex);$hex=str_replace('35#','',$hex);$hex=str_replace('36#','',$hex);$hex=str_replace('37#','',$hex);$hex=str_replace('38#','',$hex);$hex=str_replace('39#','',$hex);

		$hex=str_replace('20#','',$hex);$hex=str_replace('2e#','',$hex);$hex=str_replace('22#','',$hex);$hex=str_replace('3a#','',$hex);$hex=str_replace('7b#','',$hex);$hex=str_replace('7d#','',$hex);$hex=str_replace('5b#','',$hex);$hex=str_replace('5d#','',$hex);$hex=str_replace('28#','',$hex);$hex=str_replace('29#','',$hex);
		$hex=str_replace('2d#','',$hex);$hex=str_replace('3d#','',$hex);$hex=str_replace('2b#','',$hex);$hex=str_replace('2f#','',$hex);$hex=str_replace('2a#','',$hex);$hex=str_replace('25#','',$hex);$hex=str_replace('23#','',$hex);$hex=str_replace('24#','',$hex);$hex=str_replace('21#','',$hex);$hex=str_replace('2c#','',$hex);$hex=str_replace('d#a#','',$hex);

		$arChars=0;
		$length=0;

		$tok = strtok($hex, "#");
		while ($tok != false) {
			$length++;
			if($tok=='d8' || $tok=='d9'){
				$arChars++;
				$tok = strtok("#");//eat up next... arabic characters are 2 hexes
			}
			$tok = strtok("#");
		}
		@$ratio=$arChars/$length;
		if($ratio>0.5){
			return 1;
		}else{
			return 0;
		}
	}


	function arabicMonth($month){
		/*
		if($month==1){
			return "كانون الثاني/يناير";
		}else if($month==2){
			return "شباط/فبراير";
		}else if($month==3){
			return "آذار/مارس";
		}else if($month==4){
			return "نيسان/أبريل";
		}else if($month==5){
			return "أيار/مايو";
		}else if($month==6){
			return "حزيران/يونيو";
		}else if($month==7){
			return "تموز/يوليو";
		}else if($month==8){
			return "آب/أغسطس";
		}else if($month==9){
			return "أيلول/سبتمبر";
		}else if($month==10){
			return "تشرين الأول/أكتوبر";
		}else if($month==11){
			return "تشرين الثاني/نوفمبر";
		}else if($month==12){
			return "كانون الأول/ديسمبر";
		}
		*/
		if($month==1){
			return "كانون الثاني";
		}else if($month==2){
			return "شباط";
		}else if($month==3){
			return "آذار";
		}else if($month==4){
			return "نيسان";
		}else if($month==5){
			return "أيار";
		}else if($month==6){
			return "حزيران";
		}else if($month==7){
			return "تموز";
		}else if($month==8){
			return "آب";
		}else if($month==9){
			return "أيلول";
		}else if($month==10){
			return "تشرين الأول";
		}else if($month==11){
			return "تشرين الثاني";
		}else if($month==12){
			return "كانون الأول";
		}

	}


	function formatDate($date){
		$temp = date("j",strtotime($date))." ";
		$temp .= arabicMonth(date("n",strtotime($date)))." ";
		$temp .= date("Y",strtotime($date));
		return $temp;
	}


	function filesize_formatted($path){
		$size = filesize($path);
		$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$power = $size > 0 ? floor(log($size, 1024)) : 0;
		//return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
		return round($size / pow(1024, $power)) . ' ' . $units[$power];
	}


	function url_exists($url){
		if(isEmpty($url)){
			return false;
		}
		$file_headers = @get_headers($url);
		if($file_headers==false || @$file_headers[0]=='HTTP/1.1 404 Not Found') {
			return false;
		}else {
			return true;
		}
	}


	function in_arrayi($needle, $haystack) {
		return in_array(strtolower($needle), array_map('strtolower', $haystack));
	}


	function can_iframe($url){
		if(isEmpty($url)){
			return false;
		}
		$file_headers = @get_headers($url);
		/*
		if(@$file_headers[0]=='HTTP/1.1 404 Not Found' || @$file_headers[7]=='X-XSS-Protection: 1; mode=block'
		|| @$file_headers[3]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[4]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[5]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[6]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[7]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[8]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[9]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[10]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[11]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[12]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[13]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[14]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[15]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[16]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[17]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[18]=='X-Frame-Options: SAMEORIGIN'
		|| @$file_headers[19]=='X-Frame-Options: SAMEORIGIN' || @$file_headers[20]=='X-Frame-Options: SAMEORIGIN') {
		*/
		if(in_arrayi("X-FRAME-OPTIONS: SAMEORIGIN",$file_headers) || in_arrayi("HTTP/1.1 404 Not Found",$file_headers) || in_arrayi("X-XSS-Protection: 1; mode=block",$file_headers)) {
			return false;
		}else {
			return true;
		}
	}


	function iframe_src($embedCode){
		$src="";
		@$dom = new DOMDocument();
		if(@$dom->loadHTML($embedCode)){
			@$iframe = $dom->getElementsByTagName('iframe')->item(0);
			if(@$iframe->hasAttributes()) {
				foreach ($iframe->attributes as $attr) {
					$name = $attr->nodeName;
					$value = $attr->nodeValue;
					if($name=="src"){
						$src = $value;
					}
				}
			}
		}
		return $src;
	}


	function getimg($url) {
		$headers[] = 'Accept: image/gif, image/png, image/x-bitmap, image/jpeg, image/pjpeg';
		$headers[] = 'Connection: Keep-Alive';
		$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$user_agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($process);
		$mimeType = curl_getinfo($process, CURLINFO_CONTENT_TYPE);
		curl_close($process);

		if($mimeType== "image/gif" || $mimeType== "image/png" || $mimeType== "image/x-bitmap" || $mimeType== "image/jpeg" || $mimeType== "image/pjpeg"){
			return $return;
		}else{
			return false;
		}
	}


	function multiexplode ($delimiters,$string) {
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// Random string
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function encryptPassword($password,$salt){
		$encrypt_method = "AES-256-CBC";
		$secret_iv = md5($salt);
		$key = hash('sha256', $salt);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$encrypPassword = openssl_encrypt($password, $encrypt_method, $key, 0, $iv);
		$encrypPassword = base64_encode($encrypPassword);
		return $encrypPassword;
	}

	function getCountryName($countryid){
		$query="SELECT `name` FROM `countries` WHERE `id`='".@$countryid."'";
		$result=runQuery($query);
		if(numRows($result)==1){
			$row=fetchArray($result);
			foreach($row as $key => $temp){$$key = stripslashes(($row[$key] ?? ''));}
			return $name;
		}
	}
	

?>