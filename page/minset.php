<?php
function __autoload($className){
	include '../class/'.$className.'_class.php';
	}
//$mydb=new Mydb();
$M=new Allfunction();
date_default_timezone_set('PRC');
$d=$d1=$_POST;
$info=array();
if($d1['name']=='set'||$d1['name']=='end'){//如果是设置为管理员或取消
	$gl=$d1['name']=='set'?1:0;
	$gl_set=$M->biao('login')->where('id="'.$d['id'].'"')->update(array('gl'=>$gl));
	if($gl_set){
		$info['t']=1;
		$gl=$d1['name']=='set'?'end':'set';
		$gl_set=$d1['name']=='set'?'取消管理员权限':'设置为管理员';
		$info['d']='<a href="javascript:user_gl(\''.$gl.'\','.$d['id'].')" class="con_gl">'.$gl_set.'</a>';
		$info['bfd']=$d;
		}else{
			$info['t']=0;
			$info['n']='设置失败，请稍后再试！';
			}
	}
if($d1['name']=='del'){//如果是删除用户
	$user_del=$M->biao('login')->where('id="'.$d['id'].'"')->delete();
	if($user_del){
		$info['t']=1;
		$info['d']='已删除！';
		$info['bfd']=$d;
		/* $sel=$M->biao('user_session')->where('user_id="'.$d['id'].'"')->select('session_id');
		unlink(); */
		}else{
			$info['t']=0;
			$info['n']='删除失败，请稍后再试！';
			}
	}
if($d1['name']=='tuichu'){
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	$info['t']=1;
}
if($d1['name']=='uk'){
	$gl_set=$M->biao('login')->where('id="'.$d['id'].'"')->update(array('u_k'=>4));
	if($gl_set){
		$info['t']=0;
		$info['n']='已解锁！';
	}else{
		$info['t']=0;
		$info['n']='解锁出错，请稍后再试！';
	}
}
if($d1['name']=='rpw'){
	$gl_set=$M->biao('login')->where('id="'.$d['id'].'"')->update(array('u_k'=>md5('aigo123456')));
	if($gl_set){
		$info['t']=0;
		$info['n']='新密码为 123456';
	}else{
		$info['t']=0;
		$info['n']='重置密码出错，请稍后再试！';
	}
}
echo json_encode($info);
?>