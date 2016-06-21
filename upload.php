<?php
// В PHP 4.1.0 и более ранних версиях следует использовать $HTTP_POST_FILES
// вместо $_FILES.


$uploaddir = '/var/www/uploads/';
$wasProblems = false;

echo '<meta charset="utf-8"><pre>';

foreach ($_FILES["files"]["error"] as $key => $error) {
	echo $key;
	if($error == UPLOAD_ERR_OK){
		$tmp_name = $_FILES["files"]["tmp_name"][$key];
		$basename = basename($_FILES['files']['name'][$key]);
		$uploadfile = $uploaddir . $basename;
		if(move_uploaded_file($tmp_name, $uploadfile)){
			echo "\tЗагружено - ".$basename."\n";
		}else{
			echo "\tОшибка - ".$basename."\n";
			$wasProblems =true;
		}
	}
}

if($wasProblems){
	echo 'Debug info:';
	print_r($_FILES);
}

print "</pre>";

?> 
