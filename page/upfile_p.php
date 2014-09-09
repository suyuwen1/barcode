<?php
set_time_limit(0);
date_default_timezone_set('PRC');
include '../phpexcel/Classes/PHPExcel/IOFactory.php';
include '../class/Mydb_class.php';
include '../class/Allfunction_class.php';
$M=new Allfunction();
$d=array();
$d['r']=0;//重复数
$d['all']=0;//总导入数
$d['e']=0;//错误数
$inputFileName = '../files/'.iconv("UTF-8","gb2312",$_GET['n']);
$f=file_put_contents($inputFileName,file_get_contents('php://input'));
if($f){
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	//var_dump($sheetData);
	array_shift($sheetData);
	$d['all']=count($sheetData);
	foreach($sheetData as $v){
		$dt=array();
		$sel=$M->biao('filedata')->where('tiaoma="'.$v['D'].'"')->select('id');
		if(!$sel){
			$A=explode('-',$v['A']);
			$dt['ctime']=date("Y-m-d",mktime(0,0,0,$A[0],$A[1],$A[2]));
			$dt['danhao']=$v['B'];
			$dt['adress']=$v['C'];
			$dt['tiaoma']=$v['D'];
			$dt['uptime']=time();
			$dt['filename']=$_GET['n'];
			$ins=$M->biao('filedata')->insert($dt);
			if(!$ins){
			$d['e']++;
			}
		}else{
		$d['r']++;
		}
	}
	if($d['e']==0){
	$d['s']=1;
	}else{
	$d['s']=0;
	}
}else{
	$d['s']=0;
}
echo json_encode($d);
?>