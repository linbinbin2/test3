<?php
session_start();
header("content-type:text/html;charset=utf-8");
define('IN_PHP','ok');
//require_once('yanz.html');
include_once './class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','root','sheying');
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
//echo "<hr>";

if(!empty($_GET))
{
	$gl_name =isset($_GET['gl_name'])?$_GET['gl_name']:'';
	$gl_pass =isset($_GET['gl_pass'])?$_GET['gl_pass']:'';
	$auths=isset($_GET['auths'])?$_GET['auths']:'';
	//echo $gl_name."<br>";
	//echo $gl_pass."<br>";
	//echo $auths."<br>";
	$codeArr=explode('|',$_SESSION['code']);
	//echo "<pre>";
	//print_r($codeArr);
	//echo "</pre>";
	//exit();
	if($gl_name=="" || $gl_pass=="")
	{
		echo "<script>";
		echo "alert('账号,密码不得为空');";
		echo "location.href='sy_login.html';";
		echo "</script>";
	}
	if(strtoupper($auths) != strtoupper($codeArr[0]))
	{
		echo "<script>";
		echo "alert('验证码不正确');";
		echo "location.href='sy_login.html';";
		echo "</script>";
	}
	$sql="select * from gl where name = '".$gl_name."' and pass = '".$gl_pass."'";
	//echo $sql."<br>";
	$unameArr=$dbObj->getone($sql);
	if(!$unameArr)//账号不存在
	{
		echo "<script>";
		echo "alert('账号不存在');";
		echo "location.href='sy_login.html';";
		echo "</script>";
		exit();		
	}
	else//账号存在
	{
		//echo "帐号存在<br>";
		if($gl_pass != $unameArr['pass'])
		{
			echo "<script>";
			echo "alert('密码错误');";
			echo "location.href='sy_login.html';";
			echo "</script>";
			exit();
		 }
		 else
		 {
			//echo "登录成功<br>";
			$_SESSION['gl_name']=$gl_name;
			echo "<script>";
			echo "alert('登录成功！！');";
			echo "location.href='sy.php?gl_name=".$gl_name."';";
			echo "</script>";
		 }
	}
}
?>
