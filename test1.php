<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
$p='files/'.date("Y").'/';
if(!is_dir($p)){
mkdir($p);
}
$p.=date("n").'/';
if(!is_dir($p)){
mkdir($p);
}
echo $p;
?>
</body>
</html>