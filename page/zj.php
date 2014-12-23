<?php
date_default_timezone_set('PRC');
class LogText {
	private $p;
	private $files;
    
    function __construct(){
        $this->p='../files/';
        $this->readtext(date("Y").'/'.date("n").'/');
    }
    function readtext($a){
    	$d=@opendir($this->p.$a);
    	if ($d) {
    		while ($f=readdir($d)) {
    			$fe=pathinfo($f);
    			if ($f != '.' && $f != '..' && $fe['extension'] == 'text') {
    				$this->files['f'][]=iconv("gb2312","UTF-8",$f);
    				$this->files['p'][]=$a;
    				$this->files['c'][]=filectime($this->p.$a.$f);
    			}
    		}
    		closedir($d);
			//var_dump($this->files);
    		if (count($this->files['f'])<15) {
    			$this->selpath(count($this->files['f']));
    		}else{
    			$this->files_sort();
    		}
    	}
    }
    function files_sort(){
    	array_multisort($this->files['c'],SORT_DESC,SORT_NUMERIC,$this->files['f'],$this->files['p']);
    }
    function selpath($a){
    	$y=15-$a;//余数
    	$s=strtotime("-1 month");//上个月Unix 时间戳
    	$p=date('Y',$s).'/'.date('n',$s).'/';//新的地址
    	if ($y>0) {
    		$this->readtext($p);
    	}
    }
    function rd(){
    	$d=array();
    	$d['n']='';
    	if (!empty($this->files['f'])) {
    		foreach ($this->files['f'] as $key => $value) {
    			$d['n'].='<span class="logtextlist"><a target="_blank" href="'.$this->p.$this->files['p'][$key].$value.'">'.$value.'</a></span>';
    			if ($key==14) {
    				break;
    			}
    		}
    		$d['t']=1;
    	}else{
    		$d['t']=0;
    	}
    	return $d;
    }
}
$t=new LogText();
echo json_encode($t->rd());
?>