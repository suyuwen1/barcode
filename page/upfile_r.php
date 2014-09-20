<<<<<<< HEAD
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>
<?php
set_time_limit(0);
ini_set("memory_limit","-1");
=======
<?php
set_time_limit(0);
>>>>>>> github/master
date_default_timezone_set('PRC');
include '../phpexcel/Classes/PHPExcel/IOFactory.php';
include '../class/Mydb_class.php';
include '../class/Allfunction_class.php';
$M=new Allfunction();
$d=array();
<<<<<<< HEAD

$p='../files/2013/13/';
$h=opendir($p);

while(($f=readdir($h))!==false){
	$d['q']=0;//缺少数据数
	$d['r']=0;//重复数
	$d['all']=0;//总导入数
	$d['e']=0;//错误数
	$d['e_n']='';//错误行
	$d['r_n']='';//重复行
	$d['q_n']='';//缺少数据行
	if($f=='.'||$f=='..') continue;
	//echo $f;
	//$f=iconv("gb2312","UTF-8",$f);
	//echo $f;
	$inputFileName=$p.$f;
	//echo $inputFileName;
	$ty=pathinfo($inputFileName,PATHINFO_EXTENSION);
	echo $ty.'<br>';
	if($ty=='xls'||$ty=='xlsx'){
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
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
	/* $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
=======
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
>>>>>>> github/master
	//var_dump($sheetData);
	array_shift($sheetData);
	$d['all']=count($sheetData);
	foreach($sheetData as $k => $v){
		$dt=array();
<<<<<<< HEAD
		$A=explode('-',trim($v['A']));
		if(empty($A[1])){
		$d['error_info'].=$inputFileName.':'.($k+2).':'.$v['A'].";\r\n";
		//echo $d['error_info'];
		continue;
		}
		$dt['ctime']=date("Y-m-d",mktime(0,0,0,$A[0],$A[1],$A[2]));
		$dt['danhao']=trim($v['B']);
		$dt['adress']=trim($v['C']);
		$dt['tiaoma']=trim($v['D']);
		$dt['uptime']=time();
		$dt['filename']=iconv("gb2312","UTF-8",$inputFileName);
			
		$sel=$M->biao('filedata')->where('tiaoma="'.$dt['tiaoma'].'" and ctime="'.$dt['ctime'].'" and adress="'.$dt['adress'].'" and danhao="'.$dt['danhao'].'"')->limit(0,1)->select('id');
		if(!$sel){
			
			$ins=$M->biao('filedata')->insert($dt);
			if(!$ins){
			$d['e']++;
			$d['e_n'].=($k+2).',';
			}
		}else{
		$d['r']++;
		$d['r_n'].=($k+2).',';
		}
	} */
	//chmod(dirname(__FILE__), 0777); // 以最高操作权限操作当前目录
	$file = fopen($p.'error_log.text', 'a+'); // a模式就是一种追加模式
	$f=iconv("gb2312","UTF-8",$f);
	if($d['e']==0 && $d['r']==0 && $d['q']==0){
		$d['s']=1;
		$c = $f.' 总行数：'.($AllRow-1)." 导入成功！\r\n------------------------------------------------------------------\r\n";
	}else{
		$d['s']=0;
		$c = $f.' 总行数：'.($AllRow-1);
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
=======
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
>>>>>>> github/master
	fwrite($file, iconv("UTF-8","gb2312",$c));
	fclose($file);
	unset($file);
	}
<<<<<<< HEAD
}
closedir($h);
//echo json_encode($d);
?>
</body>
</html>
=======
	}
}
closedir($h);
echo json_encode($d);
?>
>>>>>>> github/master
