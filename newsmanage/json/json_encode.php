<?php
//json_encode()函数
//定义数组
//$starr=array('uname'=>'lisi','email'=>'ls@22','age'=>19);
$starr['name']='lisi';
$starr['email']='li@22';
$starr['age']='19';
$stjson=json_encode($starr);
echo $stjson;
$arr=json_decode($stjson);
echo '<pre>';
print_r($arr);
echo "</pre>";
echo $arr->age;//对象
$arr2=json_decode($stjson,true);
echo '<pre>';
print_r($arr2);
echo "</pre>";
echo $arr2['age'];//数组
?>