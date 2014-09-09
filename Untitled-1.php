<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
class abc{
function __construct(){
echo 'start';
}
function aaa(){
echo 'aaa';
}
function __destruct(){
echo 'end';
}
}
$a=new abc();
$a->aaa();
?>
</body>
</html>