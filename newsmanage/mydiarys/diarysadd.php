<?php
define('IN_PHP',44);
include_once 'class/mysql.class.php';
include_once 'class/Upload.class.php';
$dbObj=new db_mysql('localhost','root','','riji');

echo '<pre>';
print_r($_POST);
echo '</pre>';
echo '<pre>';
print_r($_FILES);
echo '</pre>';
if(!empty($_POST))
{
	//处理文件上传
	if($_FILES['dpic']['name']!="")
	{
		//文件上传
		$tArr=array(
										'filepath'=>date('Y-m'),
										'allowsize'=>1024*1024*2,
										'allowmime'=>array('image/gif','image/png','image/jpg','image/jpeg'),
										'israndname'=>1
									);
	$upObj=new fileup($tArr);
	$files=$upObj->up('dpic');
	if($files)
	{
		//上传成功
		$_POST['dpic']=date('Y-m').'/'.$files;
	}
	else
	{
		//上传失败
		//echo $upObj->geterror();
		//exit();
		die($upObj->geterror());
	}
	}
	$_POST['timeline']=time();
	$rtn=$dbObj->insert('ty_diary',$_POST);
	if($rtn)
	{
		echo "<script>";
		echo "alert('添加成功');";
		echo "location.href='diaryslist.php';";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('添加失败');";
		echo "location.href='diarysadd.php';";
		echo "</script>";
	}
	exit();
}
//读取所有未删除的日记类型
$sql="select * from dy_type where tflag=1";
$typeArr=$dbObj->getall($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>添加日记</title>
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
	<script charset="utf-8" src="js/kindeditor-min.js"></script>
	<script charset="utf-8" src="js/lang/zh_CN.js"></script>
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
<form enctype= "multipart/form-data" action="diarysadd.php" method="post">
<table class="table table-bordered table-hover definewidth m10" style="margin-left:3%;margin-top:2%;">
    <tr>
        <td class="tableleft">日记类别</td>
        <td> <div style="margin:0 auto;">
	             <select name="tid">
				     <option value="">-请选择-</option>
					 <?php
						foreach($typeArr as $v)
						{
							echo "<option value='{$v['tid']}'>{$v['tname']}</option>";
						}
					 ?>
				 </select>
             </div> 
        </td>
    </tr> 
    <tr>
        <td class="tableleft">日记标题</td>
        <td> <div style="margin:0 auto;">
		         <input type="text" name="dtitles">
             </div> 
        </td>
    </tr>  
    <tr>
        <td class="tableleft">心情指数</td>
        <td> <div style="margin:0 auto;">
		         <input type="file" name="dpic">
             </div> 
        </td>
    </tr>  	
    <tr>
        <td class="tableleft">日记内容</td>
        <td> <div style="margin:0 auto;">
	<textarea name="dcontent" id="content" style="width:99%;height:300px;display:none;"></textarea>
		<script>
			KindEditor.create('textarea[name="dcontent"]');
		</script>		         
             </div> 
        </td>
    </tr>  	
    <tr>
        <td class="tableleft">是否发布</td>
        <td> <div style="margin:0 auto;">
		         <input type="radio" name="drelease" value="1" checked>是&nbsp;<input type="radio" name="drelease" value="0">否
             </div> 
        </td>
    </tr>  		
    <tr>
        <td class="tableleft"></td>
        <td>
            <button style="margin-left:180px;"type="submit" class="btn btn-primary" type="submit">保存</button>&nbsp;&nbsp;<a href="goodslist.html">返回列表</a
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