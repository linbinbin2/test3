<?php
	header("content-type:text/html;charset=utf-8");
	define('IN_PHP',44);
	include_once 'class/mysql.class.php';
	$sqlCon=new db_mysql('localhost','root','','new');
	
	//当前页数
	$pid=isset($_GET['pid'])?$_GET['pid']:"";
	//要删除的记录id
	$id=isset($_GET['id'])?$_GET['id']:"";
	$sql="delete from tb_type where id='{$id}'";
	$flag=$sqlCon->query($sql);
	if($flag)//成功
	{
		echo '<script>';
		echo "alert('删除成功');";
		echo "location.href='type_index.php?pno={$pid}';";
		echo '</script>';
	}
	else//失败
	{
		echo '<script>';
		echo "alert('删除失败');";
		echo "location.href='type_index.php?pno={$pid}';";
		echo '</script>';
	}
?>