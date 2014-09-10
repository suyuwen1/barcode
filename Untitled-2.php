<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<form name="demoForm" id="demoForm" method="post" enctype="multipart/form-data"
 action="123.php">
 <p>Upload File: <input type="file" name="file[]" id="file" multiple></p>
 <p><input type="submit" value="Submit"></p>
 </form>
 <div>Progessing (in Bytes): <span id="bytesRead">
 </span> / <span id="bytesTotal"></span>
 </div>
 <div id="info"></div>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
var SYW = {
	fileFilter:[],
	uploadAndSubmit : function () {
		var form = document.forms["demoForm"];
		if(form["file"].files.length>0){
			for(var i=0,file; file=form["file"].files[i]; i++){
				document.getElementById("info").innerHTML+=file.name+'<br>';
				}
			}else{
				alert('请上传文件！');
				}
	},
	fileSelect:function(e){
		var f_h='';
		e = e || window.event;
		for(var i=0,file; file=e.target.files[i]; i++){
			if(file.type.indexOf("application/vnd.ms-excel")==0||file.type.indexOf("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")==0){
				if(file.size>=2097152){
					alert('你的这个文件"'+file.name+'"过大，应小于2M！');
					}else{
						this.fileFilter.push(file);
						}
				}else{
					alert('你选择的这个文件"'+file.name+'"不是Excel！');
					}
			}
		//this.fileFilter=this.fileFilter.concat(e.target.files);
		for(var i=0,file; file=this.fileFilter[i]; i++){
			f_h+='<span>'+file.name+'<a class="quxiao" href="javascript:void(0)">x</a></span><br>';
			}
		$("#info").html(f_h);
	},
	fileDel : function (){
		
		},
	init : function (){
		var t=this;
		$("#demoForm").submit(function(e) {
        	t.uploadAndSubmit();
			return false;
    	});
		$("#file").change(function(e) {
        	t.fileSelect(e);
			return false;
    	});
	}
};
SYW.init();
</script>
</body>
</html>