<?php
include_once 'WaterMask.class.php';
$imgObj=new WaterMask("1.jpg");
//生成缩略图
$imgObj->thumbimg(621,1104,'2');
?>