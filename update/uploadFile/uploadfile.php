<?php

	$output_dir = "../../exebitions/files/";

	if(isset($_FILES["myfile"])){
		$ret = array();

		$error =$_FILES["myfile"]["error"];
		if(!is_array($_FILES["myfile"]["name"])){ //single file
			$uniqueId=uniqid();
			$filenameArray = explode(".",$_FILES["myfile"]["name"]);
			$fileName =  $filenameArray[0].".".$uniqueId.".".end($filenameArray);//.$_FILES["myfile"]["name"];
			move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
			$ret[]= $fileName;
		}
		else{  //Multiple files, file[]

			$fileCount = count($_FILES["myfile"]["name"]);
			for($i=0; $i < $fileCount; $i++){
				$fileName = $_FILES["myfile"]["name"][$i];
				move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
				$ret[]= $fileName;
			}
		}
		echo json_encode($ret);
	}

 ?>