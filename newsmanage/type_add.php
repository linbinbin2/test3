<?php
define('IN_PHP','ok');
include_once 'class/mysql.class.php';
$sqlCon = new db_mysql('localhost','root','','new');
$acts = isset($_POST['acts'])?$_POST['acts']:'';
if($acts=='add'){
	unset($_POST['acts']);
	$rtn = $sqlCon->insert('tb_type',$_POST);
	if($rtn){
		echo "<script>";
		echo "alert('添加成功');";
		echo "location.href='type_index.php';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('添加失败');";
		echo "location.href='type_add.php';";
		echo "</script>";
	}
	exit();
}
$sql ="select * from tb_type";
$tArr = $sqlCon->getall($sql);
?>
<html>
	<head>
	<title>添加类型</title>
	<meta charset="utf-8">
	</head>
	<body>
	<form action="type_add.php" method="post">
		<input type='hidden' name='acts' value='add'>
		标题:<input type="text" name="tname"><br>
		<input type="submit" value="添加">
		<input type="button" value="返回" onclick="location.href='type_index.php'">
	</form>
	</body>
</html>