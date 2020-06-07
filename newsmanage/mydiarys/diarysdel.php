<?php
	define('IN_PHP',44);
	include_once 'class/mysql.class.php';
	$dbObj=new db_mysql('localhost','root','','riji');
	//要删除的记录id
	$ids=isset($_POST['ids'])?$_POST['ids']:"";
	//动作标识（区分单删/多删）
	$act=isset($_POST['act'])?$_POST['act']:"";
	//$sql="update ty_diary set flag=1 where did='{$ids }'";
	$arr['flag']=1;
	if($act=='delall')
	{
		$ids=substr($ids,0,strlen($ids)-1);
		//rtrim()
		$rtn=$dbObj->update("ty_diary",$arr,"did in({$ids})");
	}
	else
	{
		$rtn=$dbObj->update("ty_diary",$arr,"did='{$ids}'");
	}

	if($rtn)
	{
		//修改成功
		$rtnArr['flg']=true;
	}
	else
	{
		//修改失败
		$rtnArr['flg']=false;
	}
	echo json_encode($rtnArr);
?>