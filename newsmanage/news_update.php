<?php
define('IN_PHP',1);
include_once 'class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','','new');

//当前页数
$page=isset($_GET['page'])?$_GET['page']:$_POST['pages'];
//echo $page;

if(!empty($_POST))
{
	$nid=isset($_POST['nid'])?$_POST['nid']:"";
	unset($_POST['nid']);
	unset($_POST['pages']);
	$flag=$dbObj->update('tb_news',$_POST,"id='$nid'");
	if($flag)
	{
		echo "<script>";
		echo "alert('修改成功');";
		echo "location.href='news_index.php?pno={$page}';";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('修改失败');";
		echo "location.href='news_update.php?nid={$nid}&page={$page}';";
		echo "</script>";
	}
	exit();
}

$nid=isset($_GET['nid'])?$_GET['nid']:"";
$sql="select * from tb_news where id='{$nid}' ";
$newsArr=$dbObj->getone($sql);
//echo '<pre>';
//print_r($newsArr);
//echo '</pre>';
//查询所有新闻类型
$sql="select * from tb_type";
$typeArr=$dbObj->getall($sql);
?>
<html>
	<head>
		<title>修改新闻</title>
		<meta charset='utf-8'>
	</head>
	<body>
	<form action="news_update.php"  method="post">
	<input type='hidden' name='pages' value="<?php echo $page; ?>">
	<input type='hidden' name='nid' value='<?php echo $newsArr['id'] ?>'>
		标题：<input value="<?php echo $newsArr['title']?>" type='text' name='title'><br>
		内容：<textarea   name='content'><?php echo $newsArr['content']?></textarea><br>
		类型：<select name='tid'>
							<option value=''>-请选择-</option>
							<?php
								foreach($typeArr as $v)
								{
							?>
							<option <?php if($newsArr['tid']==$v['id']){echo 'selected';}?> value="<?php echo $v['id']?>">
								<?php echo $v['tname']?>
							</option>
							<?php
								}
							?>
					  </select><br>
		<input type='submit' value='修改'>
		<input type='button' value='返回'  onclick="location.href='news_index.php'">
	</body>
</html>