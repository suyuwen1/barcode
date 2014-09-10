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
<<<<<<< HEAD
$d['e_n']='';//错误行
$d['r_n']='';//重复行
$inputFileName = '../files/'.iconv("UTF-8","gb2312",$_GET['n']);
chmod(dirname($inputFileName), 0777);//以最高操作权限操作当前目录
=======
$inputFileName = '../files/'.iconv("UTF-8","gb2312",$_GET['n']);
>>>>>>> g/master
$f=file_put_contents($inputFileName,file_get_contents('php://input'));
if($f){
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	//var_dump($sheetData);
	array_shift($sheetData);
	$d['all']=count($sheetData);
<<<<<<< HEAD
	foreach($sheetData as $k => $v){
		$dt=array();
		$A=explode('-',$v['A']);
		$dt['ctime']=date("Y-m-d",mktime(0,0,0,$A[0],$A[1],$A[2]));
		$sel=$M->biao('filedata')->where('tiaoma="'.$v['D'].'" and ctime="'.$dt['ctime'].'" and adress="'.$v['C'].'" and danhao="'.$v['B'].'"')->select('id');
		if(!$sel){
=======
	foreach($sheetData as $v){
		$dt=array();
		$sel=$M->biao('filedata')->where('tiaoma="'.$v['D'].'"')->select('id');
		if(!$sel){
			$A=explode('-',$v['A']);
			$dt['ctime']=date("Y-m-d",mktime(0,0,0,$A[0],$A[1],$A[2]));
>>>>>>> g/master
			$dt['danhao']=$v['B'];
			$dt['adress']=$v['C'];
			$dt['tiaoma']=$v['D'];
			$dt['uptime']=time();
			$dt['filename']=$_GET['n'];
			$ins=$M->biao('filedata')->insert($dt);
			if(!$ins){
			$d['e']++;
<<<<<<< HEAD
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
	$file = fopen('../files/error_log.text', 'a+'); // a模式就是一种追加模式
	$c = $_GET['n'].' 总行数：'.$d['all']."\r\n重复行：".$d['r_n']."\r\n错误行：".$d['e_n']."\r\n";
	fwrite($file, iconv("UTF-8","gb2312",$c));
	fclose($file);
	unset($file);
=======
			}
		}else{
		$d['r']++;
		}
	}
	if($d['e']==0){
	$d['s']=1;
	}else{
	$d['s']=0;
>>>>>>> g/master
	}
}else{
	$d['s']=0;
}
echo json_encode($d);
?>