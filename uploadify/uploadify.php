<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/barcode/files'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['the_files']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	/*if(!is_dir($targetPath)){
		mkdir($targetPath);
		}*/
	$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['the_files']['name'];
	
	// Validate the file type
	$fileTypes = array('xls','xlsx'); // File extensions
	$fileParts = pathinfo($_FILES['the_files']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,iconv("UTF-8","gb2312",$targetFile));
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>