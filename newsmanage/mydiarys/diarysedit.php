<?php
define('IN_PHP',44);
include_once 'class/mysql.class.php';
include_once 'class/Upload.class.php';
$dbObj=new db_mysql('localhost','root','','riji');

if(!empty($_POST))//处理修改动作
{
	//echo '<pre>';
	//print_r($_POST);
	//echo '</pre>';
	//exit();
	//要修改的记录id
	$curid=isset($_POST['curid'])?$_POST['curid']:"";
	$curpage=isset($_POST['curpage'])?$_POST['curpage']:"";
	
	//处理文件上传
	if($_FILES['dpic']['name']!="")
	{
		$arrs=array(
									'filepath'=>date('Y-m'),
									'allowsize'=>1024*1024*2,
									'allowmime'=>array('image/gif','image/png','image/jpg','image/jpeg'),
									'israndname'=>1
								);
		$upObj=new fileup($arrs);
		$fileName=$upObj->up('dpic');
		if($fileName)
		{
			//上传成功
			$_POST['dpic']=date('Y-m').'/'.$fileName;
			$sql="select dpic from ty_diary where did='{$curid}'";
			$diaryArr=$dbObj->getone($sql);
			if($diaryArr['dpic']!="")
			{
				//删除原有图片
				unlink($diaryArr['dpic']);
			}
			
		}
		else
		{
			//上传失败
			echo $upObj->geterror();
			exit();
		}
	}
	
	//删除多余的键值对
	unset($_POST['curid']);
	unset($_POST['curpage']);
	$rtn=$dbObj->update("ty_diary",$_POST,"did='{$curid}'");
	if($rtn)
	{
		echo "<script>";
		echo "alert('修改成功');";
		echo "location.href='diaryslist.php';";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('修改成功');";
		echo "location.href='diarysedit.php';";
		echo "</script>";
	}
	exit();
}
else
{
	
}

//要修改的记录id
$did=isset($_GET['did'])?$_GET['did']:"";
//第几页
$page=isset($_GET['page'])?$_GET['page']:"";

//查询要修改记录的内容
$sql="select * from ty_diary where did='{$did}'";
$diaryArr=$dbObj->getone($sql);

//查询所有类型
$sql="select  * from dy_type where tflag=1";
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
<form enctype= "multipart/form-data" action="diarysedit.php" method="post">
<table class="table table-bordered table-hover definewidth m10" style="margin-left:3%;margin-top:2%;">
    <tr>
        <td class="tableleft">日记类别</td>
        <td> 
			<input type="hidden" name="curid" value="<?=$did?>">
			<input type="hidden" name="curpage" value="<?=$page?>">
		<div style="margin:0 auto;">
	             <select name="tid">
				     <option value="">-请选择-</option>
					<?php
					foreach($typeArr as $v)
					{
						if($v['tid']==$diaryArr['tid'])
						{
							echo "<option selected value='{$v['tid']}'>{$v['tname']}</option>";
						}
						else
						{
							echo "<option value='{$v['tid']}'>{$v['tname']}</option>";
						}
						
					}
					?>
				 </select>
             </div> 
        </td>
    </tr> 
    <tr>
        <td class="tableleft">日记标题</td>
        <td> <div style="margin:0 auto;">
		         <input type="text" name="dtitles" value="<?php echo $diaryArr['dtitles']?>">
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
	<textarea value="<?php echo $diaryArr['dcontent']?>" name="dcontent" id="content" style="width:99%;height:300px;display:none;"><?php echo $diaryArr['dcontent']?></textarea>
		<script>
			KindEditor.create('textarea[name="dcontent"]');
		</script>		         
             </div> 
        </td>
    </tr>  	
    <tr>
        <td class="tableleft">是否发布</td>
        <td> <div style="margin:0 auto;">
		         <input <?php if($diaryArr['drelease']==1){echo 'checked';}?> type="radio" name="drelease" value="1">是&nbsp;
				 <input <?php if($diaryArr['drelease']==0){echo 'checked';}?> type="radio" name="drelease" value="0">否
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