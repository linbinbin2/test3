<?php
define('IN_PHP','ok');
include_once "class/mysql.class.php";
$dbObj=new db_mysql('localhost','root','','new');
$acts=isset($_POST['acts'])?$_POST['acts']:"";
if($acts=='add')//处理添加新闻
{
	unset($_POST['acts']);//删除多余的键值对
	$rtn=$dbObj->insert('tb_news',$_POST);
	if($rtn)
	{
		echo "<script>";
		echo "alert('添加成功');";
		echo "location.href='news_index.php';";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('添加失败');";
		echo "location.href='news_index.php';";
		echo "</script>";
	}
	exit();
}
$sql="select * from tb_type";
$typeArr=$dbObj->getall($sql);

?>
<html>
	<head>
		<title>添加新闻</title>
		<meta charset='utf-8'>
	</head>
	<body>
	<form action="news_add.php"  method="post">
	<input type='hidden' name='acts' value='add'>
		标题：<input type='text' name='title'><br>
		内容：<textarea  name='content'></textarea><br>
		类型：<select name='tid'>
							<option value=''>-请选择-</option>
							<?php
								foreach($typeArr as $v)
								{
							?>
								<option value="<?php echo $v['id']; ?>">
									<?php echo $v['tname']; ?>
								</option>
							<?php
								}
							?>
					  </select><br>
		<input type='submit' value='添加'>
		<input type='button' value='返回'  onclick="location.href='news_index.php'">
	</body>
</html>