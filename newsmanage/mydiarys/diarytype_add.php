<?php
	define('IN_PHP',44);
	include_once 'class/mysql.class.php';
	$dbObj=new db_mysql('localhost','root','','riji');
if(!empty($_POST))
{
	$_POST['tdate']=time();
	$rtn=$dbObj->insert('dy_type',$_POST);
	if($rtn)
	{
		echo "<script>";
		echo "alert('添加成功');";
		echo "location.href='diarytype_list.php'";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('添加失败');";
		echo "location.href='diarytype_add.php'";
		echo "</script>";
	}
	exit();
}
	$sql="select * from dy_type";
	$typeArr=$dbObj->getall($sql);
	//echo '<pre>';
	//print_r($typeArr);
	//echo '</pre>';
?>
<!DOCTYPE html>
<html>
<head>
    <title>添加日记类别</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="Css/style.css" />
    <script type="text/javascript" src="Js/jquery.js"></script>
    <script type="text/javascript" src="Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="Js/bootstrap.js"></script>
    <script type="text/javascript" src="Js/ckform.js"></script>
    <script type="text/javascript" src="Js/common.js"></script>
    <script type="text/javascript" src="js/showdate.js"></script>
    <style type="text/css">
        body {font-size: 20px;
             padding-bottom: 40px;
             background-color:#e9e7ef;
             font-size:17px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<form action="diarytype_add.php" method="post">
<table class="table table-bordered table-hover definewidth m10" style="margin-left:3%;margin-top:2%;">
    <tr>
        <td class="tableleft">日记类别</td>
        <td> <div style="margin:0 auto;">
		         <input type="text" name="tname">
             </div> 
        </td>
    </tr> 
	<tr>
        <td class="tableleft">是否删除</td>
        <td> <div style="margin:0 auto;">
		         <input type="radio" name="tflag" value="1" checked>是&nbsp;<input type="radio" name="tflag" value="0">否
             </div> 
        </td>
    </tr>  		
    <tr>
        <td class="tableleft"></td>
        <td>
            <button style="margin-left:180px;"type="submit" class="btn btn-primary" type="submit">保存</button>&nbsp;&nbsp;<a href="diarytype_list.html">返回列表</a>
        </td>
    </tr>
	 
</table>
</form>
</body>
</html>
<script>
function jump(){
 window.location.href="placardQuery.html";
}
</script>