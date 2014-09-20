<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
<?php
set_time_limit(0);
ini_set("memory_limit",-1);
date_default_timezone_set('PRC');
include '../phpexcel/Classes/PHPExcel/IOFactory.php';
include '../class/Mydb_class.php';
include '../class/Allfunction_class.php';
$M=new Allfunction();
$d=array();

//$p='/e/';
$aaa=array('/e/','/15/','/16/');
foreach($aaa as $p){
	$sel=$M->biao('filedata')->where('filename like "%'.$p.'%"')->select('id,filename');
	if($sel){
		foreach($sel as $key => $var){
			$v=str_replace($p,'/',$var['filename']);
			/* echo $v.'<br>';
			if($key==200){
			break;
			} */
			$up=$M->biao('filedata')->where('id="'.$var['id'].'"')->update(array('filename'=>$v));
		}
	}
}
?>
</body>
</html>