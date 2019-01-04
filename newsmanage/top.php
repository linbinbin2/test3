<?php
	//开启session
	session_start();
	//获取已登录成功的用户
	$usr=isset($_SESSION['USR'])?$_SESSION['USR']:"";
?>
<html>
	<head>
		<meta charset='utf-8'>
	</head>
	<body>
		欢迎<?php echo $usr; ?>回来，<a href="index.php?action='logout'" target='_parent'>退出</a>系统
	</body>
</html>