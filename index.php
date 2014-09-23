<?php
session_start();
if(!empty($_SESSION['user'])){
header("Location:page/sel.php");
exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>爱国者产品管理系统-登陆</title>
<link type="text/css" rel="stylesheet" href="css/main.css">
<style type="text/css">
body {
	overflow: hidden;
}
</style>
<script type="text/javascript">
var t='l';
</script>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</head>

<body>
<div id="login">
	<div id="left" unselectable="on"><img id="bg" src="img/<?php echo rand(1,3);?>.jpg"></div>
  <div id="right">
    	<div id="logo"><img class="logo_img1" src="img/aigo.png"><div class="cls"></div></div>
        <div id="login_input">
        	<div class="div_position">
        	<span class="input_text e">Email</span>
        	<input n="e" class="input_self" type="text" maxlength="20">
            <span class="input_text p">密码</span>
            <input n="p" class="input_self" type="password" maxlength="20">
            </div>
        </div>
        <div id="login_submit">
        	<button id="login_button" type="button">提交</button>
        </div>
        <div class="error_info"></div>
        <div id="right_text">声明：图片来自网络</div>
    </div>
    <div class="cls"></div>
</div>
</body>
</html>