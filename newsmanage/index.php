<?php
//echo md5("123456");
//exit();
//开启session
session_start();
header("content-type:text/html;charset=utf-8");
error_reporting(0);

define("IN_PHP",34);
include_once 'class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','','new');
$actions=isset($_GET['action'])?$_GET['action']:$_POST['act'];
if($actions=='logout')
{
	//删除session
	unset($_SESSION['USR']);
}
elseif($actions=='checkuser')//验证账号是否正确
{
	$uname=isset($_POST['uname'])?$_POST['uname']:"";
	$sql=" select count(*) as n from tb_user where uname='{$uname}' ";
	$uArr=$dbObj->getone($sql);
	//echo '<pre>';
	//print_r($uArr);
	//echo '</pre>';
	if($uArr['n']==1)//输入的账号正确
	{
		$msgArr=array('msg'=>'账号正确');
	}
	else//输入的账号错误
	{
		$msgArr=array('msg'=>'账号错误');
	}
	echo json_encode($msgArr);
	exit();
}
elseif($actions=='checkcode')//判断验证码是否正确
{
	$codes=isset($_POST['codes'])?$_POST['codes']:"";
	$codeArr=explode('|',$_SESSION['code']);
	if(strtoupper($codes)==strtoupper($codeArr[0]))
	{
		echo "验证码正确";
	}
	else
	{
		echo "验证码错误";
	}
	exit();
}

	if(!empty($_POST))
	{
		$usr=isset($_POST['usr'])?$_POST['usr']:"";
		$pwds=isset($_POST['pwds'])?$_POST['pwds']:"";
		$code=isset($_POST['authcode'])?$_POST['authcode']:"";
		$reg=isset($_POST['reg'])?$_POST['reg']:"";
		if($usr==""||$pwds==""||$code=="")
		{
			echo "<script>";
			echo "alert('账号，密码及验证码不能为空');";
			echo "location.href='index.php';";
			echo "</script>";
		}
		//获取生成的验证码
		$codeArr=explode('|',$_SESSION['code']);
		//判断验证码是否超时
		if((time()-$codeArr[1])>30)
		{
			echo "<script>";
			echo "alert('验证码超时');";
			echo "location.href='index.php';";
			echo "</script>";
			exit();
		}
		//echo '<pre>';
		//print_r($codeArr);
		//echo '</pre>';
		//判断验证码
		if(strtoupper($code)!=strtoupper($codeArr[0]))
		{
			echo "<script>";
			echo "alert('验证码不正确');";
			echo "location.href='index.php';";
			echo "</script>";
		}
		//判断账号
		$sql="select * from tb_user where uname='{$usr}'";
		$uarr=$dbObj->getone($sql);
		if(empty($uarr))
		{
			//账号不正确
			echo "<script>";
			echo "alert('账号不正确');";
			echo "location.href='index.php';";
			echo "</script>";
		}
		else
		{
			//账号正确，判断密码
			if(md5($pwds)==$uarr['pwd'])
			{
				if($reg==1)//处理记住账号
				{
					setcookie('REGUSR',$usr,time()+60*60*24*7,'/');
				}
				//将已登录成功的用户写入session
				$_SESSION['USR']=$usr;
				echo "<script>";
				echo "alert('登录成功');";
				echo "location.href='main.php';";
				echo "</script>";
			}
			else
			{
				echo "<script>";
				echo "alert('密码错误！');";
				echo "location.href='index.php';";
				echo "</script>";
			}
		}
		//echo '<pre>';
		//print_r($uarr);
		//echo '</pre>';
		exit();
	}
	//获取记住账号的值
	$regusr=isset($_COOKIE['REGUSR'])?$_COOKIE['REGUSR']:"";
	
?>
<html>
	<head>
		<title>用户登录</title>
		<meta charset='utf-8'>
	</head>
	<script src='jquery-1.7.js'></script>
	<script>
	//function change()
	//{
			//var img=document.getElementById("yzm");
			//img.src="code.php?"+Math.random();
	//}
	$(function()
	{
		$("#usr").blur(function()
		{
			$.post("index.php",{'uname':$("#usr").val(),'act':'checkuser'},function(a)
			{
				//alert(a.msg);
				$("#hg").html(a.msg);
				if(a.msg=='账号正确')
				{
					$("#hg").css('color','green');
				}
				else
				{
					$("#hg").css('color','red');
				}
			},'json');
		});
		$("#yz").keyup(function()
		{
			//alert(11);
			$.post("index.php",{'codes':$("#yz").val(),'act':'checkcode'},function(a)
			{
				alert(a);
			})
		})
	})
	function change()
	{
		$("#yzm").attr("src","code.php?"+Math.random());
	}
	/*function check()
	{
		$.ajax({
						url:'aa.php',
						type:'post',
						data:{'str':$("#usr").val(),'act':'check'},
						dataType:'json',
						success:function(d)
						{
							//alert(d.n);
							if(d.n==1)
							{
								$("#hg").html('注册过了');
							}
							else
							{
								$("#hg").html('没有注册过');
							}
						}
			
					})
	}*/
	</script>
	<body>
		<form action='index.php' method='post'>
		账号：<input type='text' id='usr' name='usr' value='<?=$regusr ?>' onblur='check();'><div id='hg'></div><br>
		密码：<input type='password' name='pwds'><br>
		验证码：<input type='text' name='authcode' id='yz'>
		<img src='code.php' width='100' height='30' id='yzm'><br>
		&nbsp;&nbsp;<a href='javascript:;' onclick='change();'>换一张</a><br>
		<input type='checkbox' name='reg' value='1'>记住账号<br>
		<input type="submit" value="登录"><br>
		</form>
	</body>
</html>