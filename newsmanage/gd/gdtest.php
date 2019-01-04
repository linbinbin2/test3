<?php
//开启session
session_start();
//imagesetpixel  点
//1创建画布
$img=imagecreatetruecolor(300,400);
//var_dump($img);
//创建画布颜色
$bgcolor=imagecolorallocate($img,200,100,100);
imagefill($img,299,399,$bgcolor);
for($s=0;$s<=200;$s++)
{
	//创建颜色
	$linecolor=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
	//画线段
	imageline($img,mt_rand(0,299),mt_rand(0,399),mt_rand(0,299),mt_rand(0,399),$linecolor);
}
//随机生成字符串
$str='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
$textstr="";
for($i=1;$i<5;$i++)
{
	$num=mt_rand(0,strlen($str)-1);
	$textstr.=$str[$num];
}
//将随机生成的字符串写入session
$_SESSION['YZM']=$textstr;
//创建文本颜色
$textcolor=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//将字符串输出到画布上
imagettftext($img,30,mt_rand(0,360),150,200,$textcolor,"simhei.ttf",$textstr);
//告诉浏览器：输出一张图片
header("content-type:image/png");
//输出png格式的图片
imagepng($img);
//将png格式的图片输出到文件
//imagepng($img,'./xy.png');
?>