<?php
	/*if(!file_exists(date('Y-m')))//当目录不存在时   判断文件夹是否存在
	{
		mkdir(date('Y-m'),777);//创建文件夹
	}
	exit();*/
	/*echo "<pre>";
	print_r($_GET);
	echo "</pre>";
	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	
	echo "<pre>";
	print_r($_FILES);
	echo "</pre>";*/
	
	//处理文件上传
	if(!empty($_FILES))
	{
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		exit();
		header("content-type:text/html;charset=utf-8");
		//先将二维数组转换成一维数组
		$fileArr=isset($_FILES['curfile'])?$_FILES['curfile']:"";
		//echo "<pre>";
		//print_r($fileArr);
		//echo "</pre>";
		//1、判断文件的上传状态
		if($fileArr['error']!=0)//上传失败
		{
			switch($fileArr['error'])
			{
				case 1:
					$msg="上传的文件超过了upload_max_filesize 选项限制的值，默认是 2M。";
					break;
				case 2:
					$msg="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";
					break;
				case 3:
					$msg="文件只有部分被上传";
					break;
				case 4:
					$msg="没有文件被上传。";
					break;
				case 6:
					$msg="找不到临时文件夹。";
					break;
				case 7:
					$msg="文件写入失败。";
					break;
			}
			echo $msg;
			exit();
		}
		//2、判断文件的类型
		//定义允许上传的图片类型
		$typeArr=array('image/gif','image/png','image/jpg','image/jpeg');
		if(!in_array($fileArr['type'],$typeArr))
		{
			echo '文件类型不正确（只允许上传gif、png、jpg或jpeg类型的图片）';
			exit();
		}
		//3、判断文件大小
		if($fileArr['size']>2*1024*1024)
		{
			echo '文件太大（只允许上传小于2M的图片）';
			exit ();
		}
		//4、判断文件（上传成功后生成的临时文件）是否通过正常http请求上传的
		//$fileArr['tmp_name']='xxx.tmp';
		if(!is_uploaded_file($fileArr['tmp_name']))
		{
			echo '非法上传';
			exit ();
		}
		//5、将上传成功后的临时文件移动到指定目录中并生成正式文件
		//随机生成唯一的文件名
		$strarr=array('A','B','C','D','E','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',);
		$fName=date('Ymd').time().mt_rand(1,10000).$strarr[mt_rand(0,count($strarr)-1)];
		//echo $fName;
		//文件的扩展名
		//$fileArr['name'];
		$extArr=explode('.',$fileArr['name']);
		//echo '<pre>';
		//print_r($extArr);
		//echo '</pre>';
		$extName=$extArr[count($extArr)-1];
		//echo $extName;
		//exit();
		//动态创建目录
		$dirName=date('Y-m');
		if(!file_exists($dirName))
		{
			mkdir($dirName,777);
		}
		
		
		//if(move_uploaded_file($fileArr['tmp_name'],'./yesok.jpg'))
		if(move_uploaded_file($fileArr['tmp_name'],'./'.$dirName.'/'.$fName.'.'.$extName))
		{
			echo '上传成功';
		}
		else
		{
			echo '上传失败';
		}
		exit();
	}
?>
<html>
	<head>
		<title>文件上传</title>
		<meta charset='utf-8'>
	</head>
	<body>
		<!--form默认编码 enctype="application/x- - www- - form- - urlencoded"这种默认表单编码格式会将表单中的内容设置成键值对格式-->
		<!--<form  enctype="application/x- - www- - form- - urlencoded" action="demo.php"method="post">-->
		<!--注意：当表单中含有文件上传时，要将表单的编码格式设置成流媒体格式，而不能用表单的默认编码格式-->
		<form enctype= "multipart/form-data" action="demo.php" method="post">
		姓名：<input type="text" name="usr"><br>
		请选择要上传的文件1：<input type="file" name="curfile[]"><br>
		请选择要上传的文件2：<input type="file" name="curfile[]"><br>
		<input type='submit' value='提交'>
		</form>
	</body>
</html>
