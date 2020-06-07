<?php
/*echo '<pre>';
print_r($_GET);
echo '</pre>';

echo '<pre>';
print_r($_POST);
echo '</pre>';*/
$arr=array('name'=>'李四','age'=>'15','tel'=>'123456');
$str="";
foreach($arr as $v)
{
	$str.="<li>{$v}</li>";
}
echo "<ul>".$str."</ul>"
?>