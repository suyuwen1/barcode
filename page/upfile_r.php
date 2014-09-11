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
$d['e_n']='';//错误行
$d['r_n']='';//重复行
$p='../files/';
$h=opendir($p);
while(($f=readdir($h))!==false){
	if($f=='.'||$f=='..') continue;
	//echo $f;
	$inputFileName=$p.$f;
	//echo $inputFileName;
	$ty=pathinfo($inputFileName,PATHINFO_EXTENSION);
	
	if($ty=='xls'||$ty=='xlsx'){
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	//var_dump($sheetData);
	array_shift($sheetData);
	$d['all']=count($sheetData);
	foreach($sheetData as $k => $v){
		$dt=array();
		$A=explode('-',$v['A']);
		$dt['ctime']=date("Y-m-d",mktime(0,0,0,$A[0],$A[1],$A[2]));
		$sel=$M->biao('filedata')->where('tiaoma="'.$v['D'].'" and ctime="'.$dt['ctime'].'" and adress="'.$v['C'].'" and danhao="'.$v['B'].'"')->select('id');
		if(!$sel){
			$dt['danhao']=$v['B'];
			$dt['adress']=$v['C'];
			$dt['tiaoma']=$v['D'];
			$dt['uptime']=time();
			$dt['filename']=$f;
			$ins=$M->biao('filedata')->insert($dt);
			if(!$ins){
			$d['e']++;
			$d['e_n'].=$k.',';
			}
		}else{
		$d['r']++;
		$d['r_n'].=$k.',';
		}
	}
	if($d['e']==0 && $d['r']==0){
	$d['s']=1;
	}else{
	$d['s']=0;
	//chmod(dirname(__FILE__), 0777); // 以最高操作权限操作当前目录
	$file = fopen($p.'error_log.text', 'a+'); // a模式就是一种追加模式
	$c = $f.' 总行数：'.$d['all']."\r\n重复行：".$d['r_n']."\r\n错误行：".$d['e_n']."\r\n";
	fwrite($file, iconv("UTF-8","gb2312",$c));
	fclose($file);
	unset($file);
	}
	}
}
closedir($h);
echo json_encode($d);
?>