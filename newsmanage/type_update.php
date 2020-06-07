<?php
define('IN_PHP',1);
include_once 'class/mysql.class.php';
$sqlCon = new db_mysql('localhost','root','','new');

$page=isset($_GET['page'])?$_GET['page']:$_POST['pages'];

if(!empty($_POST)){
	$nid = isset($_POST['nid'])?$_POST['nid']:'';
	unset($_POST['nid']);
	unset($_POST['pages']);
	$flg = $sqlCon->update('tb_type',$_POST,"id='$nid'");
	if($flg){
		echo "<script>";
		echo "alert('修改成功');";
		echo "location.href='type_index.php?pno={$page}';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('修改失败');";
		echo "location.href='type_update.php?nid={$nid}&page={$page}';";
		echo "</script>";
	}
	exit();
}
$nid = isset($_GET['nid'])?$_GET['nid']:'';
$sql="select * from tb_type where id='{$nid}'";
$nArr = $sqlCon->getone($sql);
$sql="select * from tb_type";
$tArr = $sqlCon->getall($sql);
?>
<html>
	<head>
	<title>修改类型</title>
	<meta charset="utf-8">
	</head>
	<body>
	<form action="type_update.php" method="post">
		<input type='hidden' name='pages' value="<?php echo $page; ?>">
		<input type='hidden' name='nid' value="<?php echo $nArr['id'];?>">
		标题:<input value="<?php echo $nArr['tname'];?>" type="text" name="tname"><br>
		<input type="submit" value="修改">
		<input type="button" value="返回" onclick="location.href='type_index.php'">
	</form>
	</body>
</html>