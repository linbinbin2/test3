<?php
define('IN_PHP','11');
include_once 'class/mysql.class.php';
$dbObj=new db_mysql('localhost','root','','new');
//动作标识
$act=isset($_GET['act'])?$_GET['act']:"";
//要删除的新闻id
$curid=isset($_GET['curid'])?$_GET['curid']:"";
if($act=='delall')
{
	$curid=substr($curid,0,strlen($curid)-1);
	//多删
	$sql="delete from tb_news where id in({$curid}) ";
}
else
{
	//删除新闻单删
	$sql="delete from tb_news where id='{$curid}' ";
}

$rtn=$dbObj->query($sql);
$arr['flg']=$rtn;
echo json_encode($arr);
?>