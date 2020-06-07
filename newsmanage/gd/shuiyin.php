<?php
include_once 'WaterMask.class.php';
//生成图片水印
$img='26.jpg';
$imgObj=new WaterMask($img);
$imgObj->waterType=1;
$imgObj->waterImg='lf.gif';//水印图片[要打上去的小图片]
$imgObj->pos=7;                   //水印图片位置
$imgObj->transparent=30;//水印 透明度
$imgObj->output();

/*
//文字水印
$img='26.jpg';
$imgObj=new WaterMask($img);
$imgObj->pos=5;//水印位置（中中）
$imgObj->waterType=0;//文字水印
$imgObj->waterStr="Love Y";//文字水印内容
$imgObj->transparent=50;//水印透明度
$imgObj->fontSize = 50;						//文字字体大小
$imgObj->fontColor = array(255,0,255);			//水印文字颜色（RGB）
$imgObj->fontFile  = 'simhei.ttf';			//字体文件
$imgObj->output();		
*/
exit();
//打水印[图片水印或文字水印]
//1、获取图片信息
$img="1.jpg";
$imgArr=getimagesize($img);
//echo '<pre>';
//print_r($imgArr);
//echo '</pre>';
//2、根据不同图片类型将图片处理成php能识别的代码
switch($imgArr[2])
{
	case 1:
		$imgobj=imagecreatefromgif($img);
		break;
	case 2:
		$imgobj=imagecreatefromjpeg($img);
		break;
	case 3:
		$imgobj=imagecreatefrompng($img);
		break;
}
//var_dump($imgobj);
//创建颜色
$color=imagecolorallocate($imgobj,255,0,0);
//3、打文字水印
imagettftext($imgobj,30,45,ceil($imgArr[0]/2),ceil($imgArr[1]/2),$color,'simhei.ttf','@千玺');
//4、保存图片
switch($imgArr[2])
{
	case 1:
		header("Content-Type:image/gif");
		imagegif($imgobj);
		break;
	case 2:
		header("Content-Type:image/jpeg");
		imagejpeg($imgobj);
		break;
	case 3:
		header("Content-Type:image/png");
		imagepng($imgobj);
		break;
}
?>