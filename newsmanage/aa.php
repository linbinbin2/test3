<?php
$act=isset($_POST['act'])?$_POST['act']:"";
if($act=='check')
{
	$usr=isset($_POST['str'])?$_POST['str']:"";
	$conn=@mysql_connect('localhost','root','');
	mysql_select_db('new',$conn);
	mysql_query("set names utf8");
	$sql="select count(*) as n from tb_user where uname='{$usr}'";
	$res=mysql_query($sql);
	$arr=mysql_fetch_assoc($res);
	echo json_encode($arr);
	exit();
}
?>