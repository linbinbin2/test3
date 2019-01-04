<html>
	<head>
		<title>使用验证码</title>
		<meta charset='utf-8'>
	</head>
	<script src='jquery-1.12.4.js'></script>
	<script>
	function change()
	{
			var img=document.getElementById("yzm");
			img.src=img.src+"?";
		
	}
	</script>
	<body>
		账号：<input type='text' ><br>
		密码：<input type='password'><br>
		验证码：<input type='text'>
		<img width='200' height='200' src="gdtest.php" id='yzm'>
		<a  href="javascript:;" onclick="change();"">看不清楚，换一张</a>

		<input type='submit' value='登录'><br>
	</body>
</html>