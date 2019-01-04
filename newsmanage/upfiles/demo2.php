<?php
	//处理文件上传
	include_once 'Upload.class.php';
	
	if(!empty($_FILES))
	{
		    header("content-type:text/html;charset=utf-8");
			$tArr=array(
										//上传成功后文件放置位置
										'filepath'=>date('Y-m'),
										//允许上传的文件大小
										'allowsize'=>1024*1024*2,
										//允许上传的文件类型
										'allowmime'=>array('image/gif','image/png','image/jpg','image/jpeg'),
										//上传成功后的文件名是否随机
										'israndname'=>'1'
										);
			$upObj=new fileup($tArr);
			$arr=$upObj->up('uping');
			echo '<pre>';
			print_r($arr);
			echo '</pre>';
	}
?>
<html>
	<head>
		<title>使用文件上传类</title>
		<meta charset='utf-8'>
	</head>
	<body>
		<form enctype= "multipart/form-data" action="demo2.php" method='post'>
		上传文件1：<input type='file' name='uping[]'><br>
		上传文件2：<input type='file' name='uping[]'><br>
		<input type='submit' value='提交'>
		</form>
	</body>
</html>