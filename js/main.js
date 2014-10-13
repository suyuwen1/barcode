// JavaScript Document
$(function(){
	input_text_change();
	if(t=='s'){
		bar_list_a_css();
		sel_button_click();
		$("#sel_text").focus();
		}
	if(t=='l'){
		login_button_click();
		}
	if(t=='i'){
		sel_button_click();
		$("#sel_text").focus();
		}
	if(t=='p'){
		sel_button_click();
		}
	input_enter();
	})
var b_ajax;
function i_ajax(t,u,dt,d,bf,su){
	if(b_ajax){
		b_ajax.abort();
		}
	b_ajax=$.ajax({
		type:t,
		url:u,
		dataType:dt,
		data:d,
		beforeSend:bf,
		success:su
		});
	}
function email_check(m){
	var search_str = /^[\w\-\.]+@[\w]+(\.\w+)+$/;
	if(search_str.test(m)){
		m=true;
		}else{
			m=false;
			}
	return m;
	}
function input_text_change(){
	$(".input_self").keyup(function(e) {
		var n=$(this).attr("n");
        if($.trim($(this).val())==''){
			$("."+n).show();
			}else{
				$("."+n).hide();
				}
    });
	$(".input_self").keydown(function(e) {
        var n=$(this).attr("n");
		//alert($(this).val());
        if($.trim($(this).val())==''){
			$("."+n).show();
			}else{
				$("."+n).hide();
				}
    });
	}
function bar_list_a_css(){
	$(".bar_list a").click(function(e) {
		$(".bar_list").removeClass("list_bg");
        $(this).parent("div").addClass("list_bg");
    });
	}
function sel_button_click(){
	$("#sel_button").click(function(e) {
        var text=$.trim($("#sel_text").val());
		if(text!=''){
			if(t=='i'){
				if(email_check(text)){
					i_ajax('post','main.php','json',{"name":"i","user":text},up_sel,con_data);
					return false;
					}else{
						alert('请输入Email');
						}
				}
			if(t=="s"){
				i_ajax('post','main.php','json',{"name":"s","dt":text},up_sel,con_data);
				return false;
				}
			if(t=="p"){
				i_ajax('post','main.php','json',{"name":"p","dt":text},up_sel,con_data);
				return false;
			}
			}
		return false;
    });
	}
function up_sel(){
	$("#con").show().html('数据加载中...');
	$("#sel").animate({"margin-top":"10px"},"fast");
	}
function down_sel(){
	$("#sel").animate({"margin-top":"230px"},"fast",function(){
		$("#con").hide();
		});
	}
function con_data(da){
	if(da.t){
		$("#con").html(da.d);
		}else{
			$("#con").html(da.n);
			}
	}
function input_enter(){
	$(".input_self").keydown(function(e) {
        var ent=e?e:window.event;
		if(ent.keyCode==13){
			if(t=='l'){
				$("#login_button").trigger("click");
			}else{
				$("#sel_button").trigger("click");
			}
			}
    });
	}
function login_button_click(){
	$("#login_button").click(function(e) {
        var e=$.trim($("input[n='e']").val());
		var p=$.trim($("input[n='p']").val());
		if(e==''){
			$(".error_info").html('<span style="color:#F60">用户名不能为空！</span>');
			return false;
			}
		if(!email_check(e)){
			$(".error_info").html('<span style="color:#F60">用户名必需为Email ！</span>');
			return false;
			}
		if(p==''){
			$(".error_info").html('<span style="color:#F60">密码不能为空！</span>');
			return false;
			}
		i_ajax('post','page/main.php','json',{"name":t,"e":e,"p":p},'',login_su);
    });
	}
function login_su(data){
	if(data.t){
		window.location="index.php";
		}else{
			$(".error_info").html(data.n);
			}
	}
function user_gl(a,b){
	i_ajax('post','minset.php','json',{"name":a,"id":b},'',user_gl_change);
	}
function user_gl_change(data){
	if(data.t){
		if(data.bfd.name=='del'){
			$("#con").html('已删除！');
			setTimeout("down_sel()",300);
			}else{
				$(".con_gl").replaceWith(data.d1);
				$(".con_gl2").replaceWith(data.d2);
				}
		}else{
			alert(data.n);
			}
	}
function tuichu(){
	i_ajax('post','minset.php','json',{"name":"tuichu"},'',su_t);
}
function su_t(data){
	if(data.t){
		window.location="../index.php";
		}
}