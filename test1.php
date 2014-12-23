<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php 
	echo basename(basename('123.xlsx','.xlsx'),'.xls');
	echo date('Y-n-d',strtotime("-1 month"));
	echo $a=pathinfo('123.php');
	echo $a['extension'];
?>
</body>
</html>