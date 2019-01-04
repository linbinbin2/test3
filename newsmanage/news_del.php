<?php
	header("content-type:text/html;charset=utf-8");
	define('IN_PHP',44);
	include_once 'class/mysql.class.php';
	$dbObj=new db_mysql('localhost','root','','new');

	//动作标识
	$act=isset($_GET['act'])?$_GET['act']:"";
	
	//当前页数
	$pid=isset($_GET['pid'])?$_GET['pid']:"";
	//要删除的记录id
	$id=isset($_GET['id'])?$_GET['id']:"";
	if($act=='delall')
	{//多删
		$id=substr($id,0,strlen($id)-1);
		$sql="delete from tb_news where id in ({$id})";
	}
	else
	{//单删
		$sql="delete from tb_news where id='{$id}'";
	}
	//echo $sql;
	//exit();
	$flag=$dbObj->query($sql);
	if($flag)//成功
	{
		echo '<script>';
		echo "alert('删除成功');";
		echo "location.href='news_index.php?pno={$pid}';";
		echo '</script>';
	}
	else//失败
	{
		echo '<script>';
		echo "alert('删除失败');";
		echo "location.href='news_index.php?pno={$pid}';";
		echo '</script>';
	}
?>