<?php
if(empty($_GET['key']) || empty($_GET['h'])){
exit;
}
function __autoload($className){
	include '../class/'.$className.'_class.php';
	}
//$mydb=new Mydb();
$M=new Allfunction();
date_default_timezone_set('PRC');
$info=array();
if($_GET['key']=='myaigo20141106'){
	$get_p=$M->biao('filedata')->where('tiaoma="'.$_GET['h'].'"')->limit(0,1)->select('id');
	if($get_p){
		$info['code']=1;
	}else{
		$info['code']=0;
	}
}else{
	$info['code']=2;
}

echo json_encode($info);
?>