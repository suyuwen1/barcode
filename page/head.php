<?php
session_start();
if(empty($_SESSION['user'])){
header("Location:../index.php");
exit;
}
?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit" />
<title>爱国者产品管理-<?php echo $title;?></title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
var t='<?php echo $bar_list_bg;?>';
</script>
<script type="text/javascript" src="../js/main.js"></script>
<?php
if($bar_list_bg=='3c'){
	echo '<link rel="stylesheet" type="text/css" href="../uploadify/uploadify.css">';
	echo '<script type="text/javascript" src="../uploadify/jquery.uploadify.min.js"></script>';
	}
?>
</head>

<body>
<div id="main">
	<div class="left">
    	<div id="left_body">