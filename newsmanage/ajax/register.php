<?php
	$uname=isset($_GET['uname'])?$_GET['uname']:"";
	//$uname=isset($_POST['uname'])?$_POST['uname']:"";
	if($uname!="")//校验账号是否注册过
	{
		$conn=@mysql_connect('localhost','root','');
		mysql_select_db('new',$conn);
		mysql_query("set names utf8",$conn);
		$sql="select count(*) as n from tb_user where uname='{$uname}' ";
		$res=mysql_query($sql,$conn);
		$arr=mysql_fetch_assoc($res);
		if($arr['n']==1)
		{
			//存在
			echo "no";
		}
		else
		{
			//不存在
			echo "yes";
		}
		exit();
	}
?>
<html>
	<head>
		<title>注册用户</title>
		<meta charset='utf-8'>
		<style type='Text/CSS'>
		.blue
		{
			color:blue;
		}
		</style>
		<script src='../jquery-1.7.js'></script>
		<script>
		$(function()
		{
			//alert(111);
			//注意：$.load()如果把要发送的参数放在第二个位置，则以post方式发送
			//$("#content").load('reg.php',{'curp':22,'act':'load'},function(a)
			//{
				//alert(a);
			//})
			//注意：$.load()如果把要发送的参数直接放在文件名的后面，则以get方式发送
			$("#content").load('reg.php?curp=22&act=load');
		})
			//创建ajax对象 
			//注意：  不同的浏览器创建ajax对象的方式也不一样
			//IE浏览器：new ActiveObject();
			//非IE浏览器：new XMLHttpRequest();
			var httpRequest="";//ajax对象
			if(window.ActiveXObject)
			{//IE
				//1.创建ajax对象
				httpRequest=new ActiveXObject('Microsoft.XMLHTTP');
				//alert("IE");
			}
			else
			{//非IE
				//1.创建ajax对象
				httpRequest=new XMLHttpRequest();
				//alert("Not IE");
			}
			
			function checkuser()
			{
				var usrval=document.getElementById('usr').value;
				//alert(usrval);
				//alert(httpRequest);
				//2.创建http请求
				//httpRequest.open('请求发送的方式GET/POST','请求发送的地址','是否使用异步方式发送请求true/false');
				httpRequest.open('GET','register.php?uname='+usrval+'&'+Math.random(),true);
				//设置post方式的头信息
				//httpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				//httpRequest.open('POST','register.php',true);
				//4.注册回调方法
				httpRequest.onreadystatechange=abc;
				
				//3.发送请求
				httpRequest.send(null);
				//httpRequest.send("uname="+usrval+"&"+Math.random());
			}
			function abc()
			{
				//alert(123);
				//注意：readyState获取处理的状态
				//alert(httpRequest.readyState);
				//服务端处理完请求并返回结果给ajax对象
				if(httpRequest.readyState==4)
				{
					//5.ajax对象将返回结果填充到页面相关位置
					//获取返回的结果
					//alert(httpRequest.responseText);
					if(httpRequest.responseText=="yes")
					{
						//账号未注册
						document.getElementById('usrmsg').innerHTML='账号可用';
					}
					else
					{
						//账号已注册
						document.getElementById('usrmsg').innerHTML='账号已注册';
					}
				}
			}
			function checkuser2()
			{
				/*$.ajax({
								url:'register_act.php',
								type:'post',
								data:{'curusr':$("#usr").val(),'act':'check'},
								dataType:'json',
								success:function(d)
								{
									alert(d.n);
									if(d.n==1)
									{
										$("#usrmsg").html('账号已注册').css("color","red");
									}
									else
									{
										$("#usrmsg").html('账号未注册').css("color","blue");
									}
								}
							})*/
							$.post('register_act.php',{'curusr':$("#usr").val(),'act':'check'},function(d)
							{
								alert(d.n);
								if(d.n==1)
								{
									$("#usrmsg").html('账号已注册').css("color","red");
								}
								else
								{
									$("#usrmsg").html('账号未注册').css("color","blue");
								}
							},'json');
			}
		</script>
	</head>
	<body>
		<div id='content'></div><br>
		<!--账号：<input type='text' id='usr' name='usr' onblur="checkuser();"><span id='usrmsg' style="color:red;"></span><br>-->
		账号：<input type='text' id='usr' name='usr' onblur="checkuser2();"><span id='usrmsg' ></span><br>
		密码：<input type='password' id='pwd1' name='pwd1'><br>
		确认密码：<input type='password' id='pwd2' name='pwd2'><br>
	</body>
</html>