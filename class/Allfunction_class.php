<?php
	class Allfunction extends Mydb{
		protected $sql_b='';
		protected $sql_w='';
		protected $sql_o='';
		protected $sql_l='';
		protected $sql_e='';
		
		public function fenge_data($data){//分割数据
			$d=explode(";",$data);
			$dt=array();
			foreach($d as $d_val){
				if($d_val!=''){
					$d1=explode(":",$d_val);
					$dt[$d1[0]]=$d1[1];
					}
				}
			return $dt;
			}
		public function validate_email($email){//判断Email是否正确
			if(!preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $email))
				return false;

			list($prefix, $domain) = explode("@",$email);

			if(function_exists("getmxrr") && getmxrr($domain, $mxhosts)){
				return true;
				}elseif (@fsockopen($domain, 25, $errno, $errstr, 5)){
					return true;
					}else{
						return false;
						}

			}
		public function clearCookies(){//将cookie清除
			setCookie('name','',time()-3600,'/');
			setCookie('user','',time()-3600,'/');
			setCookie('islogin','',time()-3600,'/');
			}
		//------------------数据库操作---------------------
		public function biao($data){//要查询的表
			$this->sql_b=$data;
			return $this;
			}
		public function where($data){//条件字条串
			$this->sql_w='where '.$data;
			return $this;
			}
		public function order($data="id",$data2='DESC'){//data字段  data2按什么方式排序
			$this->sql_o='ORDER BY '.$data;
			$this->sql_e=$data2;
			return $this;
			}
		public function limit($data,$data2){//data开始，data2结束
			$this->sql_l='limit '.$data.','.$data2;
			return $this;
			}
		public function d_all(){//删除已定义的变量
			$sql_b='';
			$sql_w='';
			$sql_o='';
			$sql_l='';
			$sql_e='';
			return $this;
			}
		public function delete(){//删除
			$sql = "delete from $this->sql_b $this->sql_w";
			$result=mysqli_query($this->mysql,$sql);
			if($result&&mysqli_affected_rows($this->mysql)>0){
				return true;
				}else{
					return false;
					}
			}
		public function insert($data){//将数组数据插入表  insert(要插入的数组)
			$key = array_keys($data);
			$data = array_map("addslashes",$data);
			$key = array_map("addslashes",$key);
			$keyString = implode(",",$key);
			$dataString = implode("','",$data);
			$sql = "insert into $this->sql_b ($keyString) values ('$dataString')";
			$result=mysqli_query($this->mysql,$sql);
			if($result && mysqli_affected_rows($this->mysql)>0){
				return mysqli_fetch_row(mysqli_query($this->mysql,"SELECT LAST_INSERT_ID()"));
				}else{
					return false;
					}
			}
		public function select($data='*'){//查询表  select(要查询的字段)
			$sql = "select $data from $this->sql_b $this->sql_w $this->sql_o $this->sql_e $this->sql_l";
			$result=mysqli_query($this->mysql,$sql);
			if($result && mysqli_num_rows($result)){
				$a=array();
				while($row=mysqli_fetch_assoc($result)){
					$a[]=$row;
				}
				return $a;
				}else{
					return false;
					}
			}
		public function update($data){//更新数据 $data 组数
			$data2='';
			$js=0;
			foreach($data as $key => $val){
				$data2.=$key.'="'.$val.'"';
				$js++;
				if(count($data)!=$js){
					$data2=$data2.',';
					}
				}
			$sql = "update $this->sql_b set $data2 $this->sql_w";
			$result=mysqli_query($this->mysql,$sql);
			if($result&&mysqli_affected_rows($this->mysql)>0){
				return true;
				}else{
					//$aaa=mysqli_error();
					return false;
					}
			}
		//-----------------数据库操作结束---------------------
		//------------------发邮件函数开始--------------------
		public function send_email($data){//$data是一个数组
			require('PHPMailer/class.phpmailer.php');//包含发邮件类
			$mail = new PHPMailer();
			$mail->CharSet ="UTF-8";
			$mail->IsSMTP();
			$mail->Host = "smtp.126.com";
			$mail->Port = 25;
			$mail->Username = "suyuwen1@126.com";
			$mail->Password = "suyuwen2012";
			$mail->From = $data['from']; //发件人邮箱
			$mail->FromName = $data['fromname']; //发件人名称
			$mail->SMTPAuth = true; //设置SMTP是否需要认证，使用Username和Password变量
			//$mail->SMTPSecure = "ssl"; //ssl安全连接
			$mail->AltBody = $data['con']; //当不支持html邮件时显示的内容
			$mail->Subject = $data['title']; //邮件标题
			$mail->Body = $data['con']; //邮件内容
			$mail->IsHTML(true); //设置为HTML格式邮件
			$mail->AddAddress($data['address']); //收件人邮箱
			if(!$mail->Send()) {//发送邮件
				return false;
				}else{
					return true;
					}
			}
		//-------------发邮件函数结束---------------------
		//-------------获取客户端IP---------------------
		function GetIP(){
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
			else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
			else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
			else
			$ip = "unknown";
			return($ip);
			}
		
		 /**
 * 等比缩放函数（以保存的方式实现）
 * @param string $picname 被缩放的处理图片源
 * @param int $maxx 缩放后图片的最大宽度
 * @param int $maxy 缩放后图片的最大高度
 * @param string $pre 缩放后图片名的前缀名
 * @return String 返回后的图片名称(带路径)，如a.jpg=>s_a.jpg
 */
		function imageUpdateSize($picname,$maxx=100,$maxy=100,$pre="s_"){
			$info = getimageSize($picname); //获取图片的基本信息
			
			$w = $info[0];//获取宽度
			$h = $info[1];//获取高度
			
			//获取图片的类型并为此创建对应图片资源	
			switch($info[2]){
				case 1: //gif
					$im = imagecreatefromgif($picname);
					break;
				case 2: //jpg
					$im = imagecreatefromjpeg($picname);
					break;
				case 3: //png
					$im = imagecreatefrompng($picname);
					break;
				default:
					die("图片类型错误！");
			}
			
			//计算缩放比例
			if(($maxx/$w)>($maxy/$h)){
				$b = $maxy/$h;
			}else{
				$b = $maxx/$w;
			}
			
			//计算出缩放后的尺寸
			$nw = floor($w*$b);
			$nh = floor($h*$b);
			
			//创建一个新的图像源(目标图像)
			$nim = imagecreatetruecolor($nw,$nh);
				
			//执行等比缩放
			imagecopyresampled($nim,$im,0,0,0,0,$nw,$nh,$w,$h);
			
			//输出图像（根据源图像的类型，输出为对应的类型）
			$picinfo = pathinfo($picname);//解析源图像的名字和路径信息
			$newpicname= $picinfo["dirname"]."/".$pre.$picinfo["basename"];
			switch($info[2]){
				case 1:
					imagegif($nim,$newpicname);
					break;
				case 2:
					imagejpeg($nim,$newpicname);
					break;
				case 3:
					imagepng($nim,$newpicname);
					break;
			}
			//释放图片资源
			imagedestroy($im);
			imagedestroy($nim);
			//返回结果
			return $newpicname;
		}
		}
?>