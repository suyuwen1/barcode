<?php
set_time_limit(0);
<<<<<<< HEAD
ini_set("memory_limit",-1);
date_default_timezone_set('PRC');

=======
date_default_timezone_set('PRC');
>>>>>>> github/master
include '../phpexcel/Classes/PHPExcel/IOFactory.php';
include '../class/Mydb_class.php';
include '../class/Allfunction_class.php';
$M=new Allfunction();
$d=array();
<<<<<<< HEAD
$d['q']=0;//缺少数据数
=======
>>>>>>> github/master
$d['r']=0;//重复数
$d['all']=0;//总导入数
$d['e']=0;//错误数
$d['e_n']='';//错误行
$d['r_n']='';//重复行
<<<<<<< HEAD
$d['q_n']='';//缺少数据行
$p='../files/'.date("Y").'/';
if(!is_dir($p)){
mkdir($p);
}
$p.=date("n").'/';
if(!is_dir($p)){
mkdir($p);
}
$d['url']=$p.'log_'.$_GET['t'].'.text';
$inputFileName = $p.iconv("UTF-8","gb2312",$_GET['n']);
=======

$inputFileName = '../files/'.iconv("UTF-8","gb2312",$_GET['n']);
>>>>>>> github/master
chmod(dirname($inputFileName), 0777);//以最高操作权限操作当前目录
$f=file_put_contents($inputFileName,file_get_contents('php://input'));
if($f){
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
<<<<<<< HEAD
	$worksheet = $objPHPExcel->getActiveSheet();
	$AllRow = $worksheet->getHighestRow();
	$worksheet->getStyle('A1:A'.$AllRow)
		->getNumberFormat()
        ->setFormatCode('yyyy-mm-dd');
	$dt['uptime']=time();
	//$f=iconv("gb2312","UTF-8",$f);
	$dt['filename']=iconv("gb2312","UTF-8",$inputFileName);
	for($i=2;$i<=$AllRow;$i++){
		$dt['ctime']=$worksheet->getCell('A'.$i)->getFormattedValue();
		$dt['danhao']=$worksheet->getCell('B'.$i)->getFormattedValue();
		$dt['adress']=$worksheet->getCell('C'.$i)->getFormattedValue();
		$dt['tiaoma']=$worksheet->getCell('D'.$i)->getFormattedValue();
		if($dt['ctime']!='' && $dt['danhao']!='' && $dt['adress']!='' && $dt['tiaoma']!=''){
			$sel=$M->biao('filedata')->where('tiaoma="'.$dt['tiaoma'].'" and ctime="'.$dt['ctime'].'" and adress="'.$dt['adress'].'" and danhao="'.$dt['danhao'].'"')->limit(0,1)->select('id');
			if(!$sel){
				$ins=$M->biao('filedata')->insert($dt);
				if(!$ins){
					$d['e']++;
					$d['e_n'].=$i.',';
				}
			}else{
				$d['r']++;
				$d['r_n'].=$i.',';
			}
		}else{
			$d['q']++;
			$d['q_n'].=$i.',';
		}
	}
	//chmod(dirname(__FILE__), 0777); // 以最高操作权限操作当前目录
	$file = fopen($d['url'], 'a+'); // a模式就是一种追加模式
	if($d['e']==0 && $d['r']==0 && $d['q']==0){
		$d['s']=1;
		$c = $_GET['n'].' 总行数：'.($AllRow-1)." 导入成功！\r\n------------------------------------------------------------------\r\n";
	}else{
		$d['s']=0;
		$c = $_GET['n'].' 总行数：'.($AllRow-1);
		if($d['r']){
		$c.="\r\n重复数：".$d['r'];
		}
		if($d['e']){
		$c.="\r\n错误行：".$d['e_n'];
		}
		if($d['q']){
		$c.="\r\n缺少数据行：".$d['q_n'];
		}
		$c.="\r\n------------------------------------------------------------------\r\n";
	}
	fwrite($file, iconv("UTF-8","gb2312",$c));
	fclose($file);
	unset($file);
=======
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
			$dt['filename']=$_GET['n'];
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
	$file = fopen('../files/error_log.text', 'a+'); // a模式就是一种追加模式
	$c = $_GET['n'].' 总行数：'.$d['all']."\r\n重复行：".$d['r_n']."\r\n错误行：".$d['e_n']."\r\n";
	fwrite($file, iconv("UTF-8","gb2312",$c));
	fclose($file);
	unset($file);
	}
>>>>>>> github/master
}else{
	$d['s']=0;
}
echo json_encode($d);
?>