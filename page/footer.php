        </div>
    </div>
  <div id="right" class="right"><div id="right_fixed">
    	<div id="logo"><img class="logo_img2" src="../img/aigo.png"><div class="cls"></div></div>
    <div id="bar"><div class="div_position">
		<div class="bar_list list1 <?php echo $bar_list_bg=='s'?'list_bg"><a href="#">':'"><a href="sel.php">';?>产品查询</a></div>
		<?php
			if($_SESSION['gl']){
				$list_h='';
				$list_n1='list4';
				$list_n2='list5';
			}else{
				$list_h='list_hide';
				$list_n1='list2';
				$list_n2='list3';
			}
		?>
		<div class="<?php echo $list_h;?> bar_list list2 <?php echo $bar_list_bg=='c'?'list_bg"><a href="#">':'"><a href="upfile.php">';?>数据上传</a></div>
		<div class="<?php echo $list_h;?> bar_list list3 <?php echo $bar_list_bg=='i'?'list_bg"><a href="#">':'"><a href="inuser.php">';?>用户管理</a></div>
        <div class="bar_list <?php echo $list_n1;?> <?php echo $bar_list_bg=='p'?'list_bg"><a href="#">':'"><a href="cpw.php">';?>密码修改</a></div>
        <div class="bar_list <?php echo $list_n2;?> <?php echo $bar_list_bg=='t'?'list_bg':'';?>"><a href="javascript:tuichu()">退出系统</a></div>
        </div></div>
    </div></div>
    <div class="cls"></div>
</div>
</body>
</html>