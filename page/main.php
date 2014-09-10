<?php
function __autoload($className){
	include '../class/'.$className.'_class.php';
	}
//$mydb=new Mydb();
$M=new Allfunction();
date_default_timezone_set('PRC');
$d=$d1=$_POST;
$info=array();
session_set_cookie_params(604800);
session_start();
if($d1['name']=='l'){//如果用户登陆
$sel=$M->biao('login')->where('user="'.$d['e'].'"')->limit(0,1)->select('id,pw,gl,u_k');
if(!login_error_check($sel[0]['u_k'])){
	$info['t']=0;
	$info['n']='你的密码输错3次,请30分钟后再试！';
	}else{
	
	if($sel){
		if(md5('aigo'.$d['p'])==$sel[0]['pw']){
			$info['t']=1;
			$_SESSION['name'] = 'aigo';
			$_SESSION['user'] = $d['e'];
			$_SESSION['gl'] = $sel[0]['gl'];
			$_SESSION['login_error'] = 0;
			$_SESSION['ltime'] = 0;
			}else{
				$info['t']=0;
				if(!empty($_SESSION['login_error'])){
					if($_SESSION['login_error']==2){
						$_SESSION['ltime'] = time();
						$info['n']='你的密码输错3次,请30分钟后再试！';
						$_SESSION['login_error']++;
						$gx=$M->biao('login')->where('user="'.$d['e'].'"')->update(array('u_k'=>3));
						}else{
							$_SESSION['login_error']++;
							$info['n']='用户密码错误，还剩1次机会！';
							}
					}else{
						$_SESSION['login_error'] = 1;
						$info['n']='用户密码错误，还剩2次机会！';
						//$in_session_id=$M->biao('user_session')->insert(array('user_id'=>$sel[0]['id'],'session_id'=>session_id()));
						}
				}
		}else{
			$info['t']=0;
			$info['n']='无此用户，请联系管理员开通！';
			}
	}
	}
function login_error_check($u){
	global $M,$d;
	//if(!empty($_SESSION['login_error'])){
		if($u==3){
			if(time()-$_SESSION['ltime']>1800){
				//$_SESSION['login_error'] = 0;
				unset($_SESSION['login_error']);
				$gx=$M->biao('login')->where('user="'.$d['e'].'"')->update(array('u_k'=>0));
				return true;
				}else{
					return false;
					}
			}else if($u==4){
				unset($_SESSION['login_error']);
				//$M=new Allfunction();
				$M->biao('login')->where('user="'.$d['e'].'"')->update(array('u_k'=>0));
				return true;
				}else{
					return true;
				}
		/* }else{
			return true;
			} */
}
if($d1['name']=='i'){//如果是添加用户
	if(preg_match("/^[\w\-\.]+@[\w]+(\.\w+)+$/",$d['user'])){
		$sel=$M->biao('login')->where('user="'.$d['user'].'"')->limit(0,1)->select('id,gl');
		if($sel){
			$info['t']=0;
			$gl=$sel[0]['gl']?'end':'set';
			$gl2=$sel[0]['gl']?'取消管理员权限':'设置为管理员';
			$info['n']='<p class="info_p">此用户已存在！</p><a href="javascript:user_gl(\''.$gl.'\','.$sel[0]['id'].')" class="con_gl">'.$gl2.'</a><br><a href="javascript:user_gl(\'uk\','.$sel[0]['id'].')">解除锁定</a><br><a href="javascript:user_gl(\'rpw\','.$sel[0]['id'].')">重置密码</a><br><a href="javascript:user_gl(\'del\','.$sel[0]['id'].')" class="del_user">删除用户</a>';
			}else{
				unset($d['name']);
				$d['pw']=md5('aigo123456');
				$into=$M->biao('login')->insert($d);
				if($into){
					$info['t']=1;
					$info['d']='<p class="info_p">已添加，用户 '.$d['user'].' 的密码为 123456<br>请登陆后即时更改密码！</p><a href="javascript:user_gl(\'set\','.$into[0].')" class="con_gl">设置为管理员</a><br><a href="javascript:user_gl(\'del\','.$into[0].')" class="del_user">删除用户</a>';
					}else{
						$info['t']=0;
						$info['n']='添加失败，请稍后再试！';
						}
				}
		}else{
			$info['t']=0;
			$info['n']='你输入的不是Email';
			}
	}
if($d1['name']=='s'){//如果是查询条码
	$sel=$M->biao('filedata')->where('danhao="'.$d['dt'].'" or adress like "%'.$d['dt'].'%" or tiaoma="'.$d['dt'].'"')->limit(0,20)->order()->select('id,ctime,danhao,adress,tiaoma,uptime,filename');
	if($sel){
		$info['t']=1;
		$info['d']='';
		foreach($sel as $v){
			$info['d'].='<div class="sel_list"><div title="出货公司" class="sel_list_t">'.$v['adress'].'</div><div class="sel_list_c"><p title="产品条码">'.$v['tiaoma'].'<span class="sel_list_info">产品条码</span></p><p title="出库单号">'.$v['danhao'].'<span class="sel_list_info">出库单号</span></p><p title="订单日期">'.$v['ctime'].'<span class="sel_list_info">订单日期</span></p><p title="上传日期">'.date('Y-m-d',$v['uptime']).'<span class="sel_list_info">上传日期</span></p><p title="原文件下载"><a href="../files/'.$v['filename'].'">原文件下载</a></p></div></div>';
			}
	}else{
		$info['t']=0;
		$info['n']='未找到您想要的！';
	}
	}
if($d1['name']=='p'){
	$p_c=$M->biao('login')->where('user="'.$_SESSION['user'].'"')->update(array('pw'=>md5('aigo'.$d['dt'])));
	if($p_c){
		$info['t']=1;
		$info['d']='密码修改成功！';
	}else{
		$info['t']=0;
		$info['n']='密码修改失败，请稍后再试！';
	}
}
echo json_encode($info);
?>