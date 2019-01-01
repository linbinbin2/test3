<meta charset='utf-8'>
<style type='Text/CSS'>
<!--
.main
{
	border:0px solid red;
	width:100%;
	height:100%;
}
.top
{
	border:0px solid red;
	width:100%;
	height:13%;
	background-color:#5ebcbb;
}
.log
{
	border:0px solid red;
	width:10%;
	height:70%;
	padding-top:1%;
	padding-left:5%;
	float:left;
}
.title
{
	border:0px solid red;
	width:70%;
	height:90%;
	float:left;
	margin-left:2.5%;
}
.who
{
	border:0px solid red;
	width:10%;
	height:36%;
	padding-top:4%;
	font-size:16px;
	font-weight:bolder;
	color:#fffef4;
	float:right;
	text-algin:right;
}
.down
{
	border:0px solid blue;
	width:100%;
	height:86%;
	margin-top:0%;
}
.left
{
	border:0px solid blue;
	width:15%;
	height:100%;
	float:left;
	background-color:#5ebcbb;
}
.shou
{
	border:0px solid blue;
	width:100%;
	height:6%;
	text-align:center;
	padding-top:5%;
	background-color:#f9b574;
}
.shou_1
{
	border:0px solid blue;
	width:10%;
	height:60%;
	float:left;
	margin-left:10%;
}
.shou_2
{
	border:0px solid blue;
	width:30%;
	height:60%;
	float:left;
	margin-left:10%;
	font-size:20px;
	color:#fffef4;
	font-weight:bolder;
}
.ding,.ying,.ji,.gong,.cai
{
	border:0px solid blue;
	width:100%;
	height:6%;
	text-align:center;
	padding-top:5%;
}
.ding_1,.ying_1,.ji_1,.gong_1,.cai_1
{
	border:0px solid blue;
	width:10%;
	height:60%;
	float:left;
	margin-left:10%;
}
.ding_2,.ying_2,.cai_2
{
	border:0px solid blue;
	width:50%;
	height:60%;
	float:left;
	margin-left:10%;
	font-size:20px;
	color:#fffef4;
	font-weight:bolder;
}
.ji_2,.gong_2
{
	border:0px solid blue;
	width:50%;
	height:90%;
	float:left;
	margin-left:10%;
	font-size:19px;
	color:#fffef4;
	font-weight:bolder;
}
.sy_insert,.sy_update,.sy_delete,.sy_select,.sy_selecta,.sy_selectb,.sy_selectc,.sy_selectd,.yh_insert,.yh_delete,.yh_update,.yh_select
{
	border:0px solid blue;
	width:100%;
	height:4%;
	padding-left:35%;
	font-size:17px;
	color:#fffef4;
	font-weight:bolder;
}
.right
{
	border:0px solid blue;
	width:85%;
	height:100%;
	float:right;
	background-color:#dfebeb;
}
-->
</style>
<script src='./js/jquery-1.12.4.js'></script>
<script>
<!--
$(function()
{
	//alert('aaaaa');
	var a=0;
	$(".ding").click(function()
	{
		a++;
		if(a%2==0)
		{
			$(".sy_insert,.sy_delete,.sy_update,.sy_select").show();
		}
		else
		{
			$(".sy_insert,.sy_delete,.sy_update,.sy_select").hide();
		}
	})
	var b=0;
	$(".ying").click(function()
	{
		b++;
		if(b%2==0)
		{
			$(".sy_selecta,.sy_selectb,.sy_selectc,.sy_selectd").show();
		}
		else
		{
			$(".sy_selecta,.sy_selectb,.sy_selectc,.sy_selectd").hide();
		}
	})
	var c=0;
	$(".ji").click(function()
	{
		c++;
		if(c%2==0)
		{
			$(".yh_insert,.yh_delete,.yh_update,.yh_select").show();
		}
		else
		{
			$(".yh_insert,.yh_delete,.yh_update,.yh_select").hide();
		}
	})
	$(".ding_2").mouseover(function()
	{
		$(".ding_2").css('color','#f9b574');
	})
	$(".ding_2").mouseout(function()
	{
		$(".ding_2").css('color','#fffef4');
	})
	$(".ying_2").mouseover(function()
	{
		$(".ying_2").css('color','#f9b574');
	})
	$(".ying_2").mouseout(function()
	{
		$(".ying_2").css('color','#fffef4');
	})
	$(".ji_2").mouseover(function()
	{
		$(".ji_2").css('color','#f9b574');
	})
	$(".ji_2").mouseout(function()
	{
		$(".ji_2").css('color','#fffef4');
	})
	$(".gong_2").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_ly_sel.php?gl_name='+gl_name;
	})
	$(".gong_2").mouseover(function()
	{
		$(".gong_2").css('color','#f9b574');
	})
	$(".gong_2").mouseout(function()
	{
		$(".gong_2").css('color','#fffef4');
	})
	$(".cai_2").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_sel.php?gl_name='+gl_name;
	})
	$(".cai_2").mouseover(function()
	{
		$(".cai_2").css('color','#f9b574');
	})
	$(".cai_2").mouseout(function()
	{
		$(".cai_2").css('color','#fffef4');
	})
	$(".sy_insert").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_insert.php?gl_name='+gl_name;
	})
	$(".sy_insert").mouseover(function()
	{
		$(".sy_insert").css('color','#f9b574');
	})
	$(".sy_insert").mouseout(function()
	{
		$(".sy_insert").css('color','#fffef4');
	})
	$(".sy_delete").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_delete.php?gl_name='+gl_name;
	})
	$(".sy_delete").mouseover(function()
	{
		$(".sy_delete").css('color','#f9b574');
	})
	$(".sy_delete").mouseout(function()
	{
		$(".sy_delete").css('color','#fffef4');
	})
	$(".sy_update").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_update.php?gl_name='+gl_name;
	})
	$(".sy_update").mouseover(function()
	{
		$(".sy_update").css('color','#f9b574');
	})
	$(".sy_update").mouseout(function()
	{
		$(".sy_update").css('color','#fffef4');
	})
	$(".sy_select").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_select.php?gl_name='+gl_name;
	})
	$(".sy_select").mouseover(function()
	{
		$(".sy_select").css('color','#f9b574');
	})
	$(".sy_select").mouseout(function()
	{
		$(".sy_select").css('color','#fffef4');
	})
	$(".sy_selecta").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_selecta.php?gl_name='+gl_name;
	})
	$(".sy_selecta").mouseover(function()
	{
		$(".sy_selecta").css('color','#f9b574');
	})
	$(".sy_selecta").mouseout(function()
	{
		$(".sy_selecta").css('color','#fffef4');
	})
	$(".sy_selectb").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_selectb.php?gl_name='+gl_name;
	})
	$(".sy_selectb").mouseover(function()
	{
		$(".sy_selectb").css('color','#f9b574');
	})
	$(".sy_selectb").mouseout(function()
	{
		$(".sy_selectb").css('color','#fffef4');
	})
	$(".sy_selectc").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_selectc.php?gl_name='+gl_name;
	})
	$(".sy_selectc").mouseover(function()
	{
		$(".sy_selectc").css('color','#f9b574');
	})
	$(".sy_selectc").mouseout(function()
	{
		$(".sy_selectc").css('color','#fffef4');
	})
	$(".sy_selectd").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='sy_selectd.php?gl_name='+gl_name;
	})
	$(".sy_selectd").mouseover(function()
	{
		$(".sy_selectd").css('color','#f9b574');
	})
	$(".sy_selectd").mouseout(function()
	{
		$(".sy_selectd").css('color','#fffef4');
	})
	$(".yh_insert").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='yh_zc.php?gl_name='+gl_name;
	})
	$(".yh_insert").mouseover(function()
	{
		$(".yh_insert").css('color','#f9b574');
	})
	$(".yh_insert").mouseout(function()
	{
		$(".yh_insert").css('color','#fffef4');
	})
	$(".yh_delete").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='yh_zx.php?gl_name='+gl_name;
	})
	$(".yh_delete").mouseover(function()
	{
		$(".yh_delete").css('color','#f9b574');
	})
	$(".yh_delete").mouseout(function()
	{
		$(".yh_delete").css('color','#fffef4');
	})
	$(".yh_update").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='yh_xg.php?gl_name='+gl_name;
	})
	$(".yh_update").mouseover(function()
	{
		$(".yh_update").css('color','#f9b574');
	})
	$(".yh_update").mouseout(function()
	{
		$(".yh_update").css('color','#fffef4');
	})
	$(".yh_select").click(function()
	{
		var gl_name=$("#gl_name").val();
		location.href='yh_cx.php?gl_name='+gl_name;
	})
	$(".yh_select").mouseover(function()
	{
		$(".yh_select").css('color','#f9b574');
	})
	$(".yh_select").mouseout(function()
	{
		$(".yh_select").css('color','#fffef4');
	})
})
-->
</script>
<body>
<div class='main'>
	<div class='top'>
		<div class='log'><image src='image/sy.jpg'></div>
		<div class='title'></div>
		<div class='who'>
			欢迎：<?php $gl_name=$_GET['gl_name'];echo $gl_name;?>&nbsp;&nbsp;
			<a href='sy_login.html'>退出</a>
		</div>
		<input type='hidden' name='gl_name' value="<?php $gl_name=$_GET['gl_name'];echo $gl_name;?>" id='gl_name'>
	</div>
	<div class='down'>
		<div class='left'>
			<div class='shou'>
				<div class='shou_1'><image src='image/sy_01.jpg'></div>
				<div class='shou_2'>首页</div>
			</div>
			<div class='ding'>
				<div class='ding_1'><image src='image/sy_02.jpg'></div>
				<div class='ding_2'>作品管理</div>
			</div>
			<div class='sy_insert'><span id='sy_insert'>上传作品</span></div>
			<div class='sy_delete'><span id='sy_delete'>删除作品</span></div>
			<div class='sy_update'><span id='sy_update'>修改作品</span></div>
			<div class='sy_select'><span id='sy_select'>查询作品</span></div>
			<div class='ying'>
				<div class='ying_1'><image src='image/sy_03.jpg'></div>
				<div class='ying_2'>作品分类</div>
			</div>
			<div class='sy_selecta'><span id='sy_selecta'>美食类作品</span></div>
			<div class='sy_selectb'><span id='sy_selectb'>风景类作品</span></div>
			<div class='sy_selectc'><span id='sy_selectc'>人物类作品</span></div>
			<div class='sy_selectd'><span id='sy_selectd'>建筑类作品</span></div>
			<div class='ji'>
				<div class='ji_1'><image src='image/sy_04.jpg'></div>
				<div class='ji_2'>管理用户</div>
			</div>
			<div class='yh_insert'><span id='yh_insert'>用户注册</span></div>
			<div class='yh_delete'><span id='yh_delete'>用户注销</span></div>
			<div class='yh_update'><span id='yh_update'>用户修改</span></div>
			<div class='yh_select'><span id='yh_select'>查询用户</span></div>
			<div class='gong'>
				<div class='gong_1'><image src='image/sy_05.jpg'></div>
				<div class='gong_2'>在线留言</div>
			</div>
			<div class='cai'>
				<div class='cai_1'><image src='image/sy_06.jpg'></div>
				<div class='cai_2'>摄影展示</div>
			</div>
		</div>
		<div class='right'>
		
