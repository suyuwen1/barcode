<?php
$title='数据上传';
$bar_list_bg='c';
include_once("head.php");
?>
<div id="upfile">
<div><!--<form name="file_form" id="file_form" method="post" enctype="multipart/form-data"
 action="">-->
 <p><input type="file" name="file[]" id="file_upload" multiple></p>
 <p><input id="up_button" type="submit" value="上传"><span class="error_log"><a target="_blank" href="../files/error_log.text">上传日志</a></span></p>
<!-- </form>--></div>
<div id="file_con"></div>
<div id="zj" style="padding-top:40px;font-size:24px">
	<div>最近上传</div>
	<div id="zj_c" style="padding-top:20px"><script type="text/javascript"> zjd(); </script></div>
</div>
</div>
<script type="text/javascript">
var SYW = {
	fileFilter:[],
	onProgress: function(file_id, loaded, total) {
		var percent = (loaded / total * 100).toFixed(2) + '%';
		$(".d"+file_id+" .gtiao").css({"width":percent});
	},
	onSuccess: function(file_id) {
		this.fileDel(file_id);
	},
	onFailure: function(file_id) {
		$(".d"+file_id+" .gtiao").css({"width":"100%","background-color":"#F60"});
	},
	onComplete: function() {
		this.fileFilter=[];
	},
	uploadAndSubmit : function (i) {//提交文件
		var self=this;
		/*if(i<this.fileFilter.length){
			var self=this;
			file = this.fileFilter[i];
			$.ajax({
			type:"POST",
			url:"upfile_p.php?n="+file.name,
			dataType:"json",
			data:file,
			contentType:"multipart/form-data",
			processData:false,
			success:function(d){
				$(".d"+i+" .gtiao").css({"width":"100%","background-color":"#060"});
				self.uploadAndSubmit(++i);
				},
			error:self.onFailure(i)
			});
			}*/
		
		
		for(var i = 0,file; file = this.fileFilter[i]; i++){
			if(file.name != 'del'){
				var dd=new Date();
				$.ajax({
				type:"POST",
				async:false,
				global:false,
				url:"upfile_p.php?n="+file.name+"&tm="+dd.getTime(),
				dataType:"json",
				data:file,
				contentType:"multipart/form-data",
				processData:false,
				beforeSend:function(){
				$(".d"+i+" .gtiao").css({"width":"50%","background-color":"#060"});
				$(".d"+i+" a").html("<img src='../img/loading.gif'>");
				},
				success:function(d){
					if(d.s){
						$(".d"+i+" .gtiao").css({"width":"100%","background-color":"#060"});
						}else{
							self.onFailure(i);
							}
					$(".error_log a").attr("href",d.url);
					$(".d"+i+" a").html("");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					$(".d"+i+" .gtiao").css({"width":"100%","background-color":"#F60"});
					$(".d"+i+" a").html("");
					}
				});
				}
			if(i==(this.fileFilter.length-1)){
				this.onComplete();
				//setTimeout(function(){$("#file_con").html('')},2000);
				$(".error_log").show();//显示上传日志
				return false;
				}
			} 
	},
	fileSelect : function(e){//选择文件将文件加入数组
		if(!this.fileFilter.length){
			$("#file_con").html('');//清空上传文件显示区
			$(".error_log").hide();//隐藏上传日志
		}
		var f_h='';
		e = e || window.event;
		for(var i=0,file; file=e.target.files[i]; i++){
			if(this.fileCheck(file.name,this.fileFilter)){
				alert('你已选择"'+file.name+'"文件！');
				}else{
			if(file.type.indexOf("application/vnd.ms-excel")==0||file.type.indexOf("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")==0){
				if(file.size>=5242880){
					alert('你的这个文件"'+file.name+'"过大，应小于5M！');
					}else{
						this.fileFilter.push(file);
						}
				}else{
					alert('你选择的这个文件"'+file.name+'"不是Excel！');
					}
			}}
		//this.fileFilter=this.fileFilter.concat(e.target.files);
		for(var i=0,file; file=this.fileFilter[i]; i++){
			if(file.name != 'del'){
			f_h+='<span class="file_name d'+i+'"><span class="nfone">'+file.name+'</span><a class="quxiao" href="javascript:SYW.fileDel('+i+')">x</a><span class="gtiao"></span></span>';
			}}
		$("#file_con").html(f_h);
	},
	fileDel : function (i){//删除文件
		//var File={name:"del"};
		this.fileFilter.splice(i,1,{name:"del"});
		$(".d"+i).remove();
		},
	fileCheck : function(str,arr){//检查文件是否在数组已存在
		var i=arr.length;
		while(i--){
			if(str===arr[i].name){
				return true;
				}
			}
		return false;
		},
	init : function (){//初始化SYW对象
		var th=this;
		$("#up_button").click(function(e) {
			if(th.fileFilter.length){
				th.uploadAndSubmit(0);
				}else{
					alert('请选择要上传的文件！');
					}
			return false;
    	});
		$("#file_upload").change(function(e) {
        	th.fileSelect(e);
			return false;
    	});
	}
};
SYW.init();
</script>
<?php
include_once("footer.php");
?>