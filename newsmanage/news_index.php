<?php
header("content-type:text/html;charset=utf-8");
//echo md5('有你真好');

//exit();
//删除常量
/*$xz=32;
//echo $xz.'<br>';
unset($xz);
//echo $xz.'<br>';
//自定义常量
//注意： 1）自定义的常量使用范围为全局的
//				2）常量在运行使用期间常量不能删除、修改
//define('常量名','值');
define('PI',3.1415);
//unset('PI');//不能删除
//define('PI',60);//不能被修改
echo PI.'<br>';

//判断某个常量是否定义过
if (defined('PI'))
{
		echo 'yes<br>';
}
else
{
		echo 'no<br>';
}
exit ();
$xy=21;
function demos(){
		global $xy;//声明成全局变量
		echo $xy.'<br>';
		echo PI.'<br>';
}
demos();
exit();*/
//include_once 'class/mysql.class.php';//相对路径
//绝对路径
// \转义符;当\后为n或t时 n--转为换行符  t--转为制表符 与单双引号有关
//include_once "D:\wamp\www\\newsmanage\class\mysql.class.php";
//include_once 'D:\wamp\www\newsmanage\class\mysql.class.php';
//php预定义常量
//echo __FILE__.'<br>';
//echo dirname(__FILE__).'<br>';
//echo dirname(dirname(__FILE__)).'<br>';
//echo str_replace('\\','/',dirname(dirname(__FILE__))).'<br>';

//当前页数
$curp=isset($_GET['pno'])?$_GET['pno']:"1";
//echo $curp;

//查询条件
$ntitle=isset($_GET['ntitle'])?$_GET['ntitle']:"";
$ntype=isset($_GET['ntype'])?$_GET['ntype']:"";
$wheres="";
if($ntitle!="")
{
	$wheres=" where title like '%{$ntitle}%' ";
}
if($ntype!="")
{
	if($wheres!="")
	{
		$wheres.=" and tid='{$ntype}' ";
	}
	else
	{
		$wheres=" where tid='{$ntype}' ";
	}
}

define('IN_PHP',34);

$paths=str_replace('\\','/',dirname(dirname(__FILE__)));
define('PATHS',$paths);
//echo '$paths='.$paths.'<br>';
//include_once "D:/wamp/www/newsmanage/class/mysql.class.php";
//include_once $paths.'/newsmanage/class/mysql.class.php';
include_once PATHS.'/newsmanage/class/mysql.class.php';
include_once PATHS.'/newsmanage/class/Page.class.php';
$dbObj=new db_mysql('localhost','root','','new');

//查询总的记录数
$sql="select  count(*) as n from tb_news {$wheres}";
$totalArr=$dbObj->getone($sql);

//new Page('总记录个数','每页显示的条数');
$pageObj=new Page($totalArr['n'],'15');

$sql="select n.id,title,tname from tb_news as n 
	  left join tb_type as t on tid=t.id 
	  {$wheres} order by n.id desc limit ".$pageObj->limit();
	  
$nArr=$dbObj->getall($sql);
echo '<pre>';
echo print_r($nArr);
echo '</pre>';
$sql="select * from tb_type";
$typeArr=$dbObj->getall($sql);
echo '<pre>';
echo print_r($typeArr);
echo '</pre>';
?>
<html>
	<head>
		<meta charset='utf-8'>
		<title>新闻列表</title>
		<script src='jquery-1.12.4.js'></script>
		<script>
			//全删
			function delall2()
			{
				var selstr="";
				$(".sels").each(function(x,y)
				{
					if(y.checked)
					{
						//alert(y.value);
						selstr+=$(y).val()+',';
					}
				})
				if(selstr==" ")
				{
					alert("请选择要删除的记录");
					return;
				}
				if(confirm("确定要全部删除吗？"))
				{
					$.get("news_del2.php",{"curid":selstr,'act':'delall'},function(a)
					{
						if(a.flg)
						{
							alert("删除成功");
							location.href="news_index.php";
						}
						else
						{
							alert("删除失败");
						}
					},'json')
				}
			}
			//单删
			function delone2(ids,page)
			{
				if(confirm("确定要删除吗？"))
				{
					//alert(22);
					$.get("news_del2.php",{'curid':ids},function(a)
					{
						alert(a);
						if(a.flg)
						{
							alert('删除成功');
							location.href="news_index.php?pno="+page;
						}
						else
						{
							alert('删除失败');
						}
						
					},'json');
				}
			}
			function selall(obj)
			{
				//alert(typeof(obj));
				//alert(obj.checked);
				/*var cheks=document.getElementsByName('selid');
				for(var a=0;a<cheks.length;a++)
				{
					cheks[a].checked=obj.checked;
				}*/
				$(".sels").each(function(i,o)
				{
						alert(i+'==='+o);
						//$(o).attr('checked',obj.checked);
						o.checked=obj.checked;
				})
			}
			function delall(curp)
			{
				var curselid="";
				$(".sels").each(function(x,y)
				{
					if(y.checked)
					{
						//alert(y.value);
						curselid=curselid+y.value+',';
					}
				})
				location.href="news_del.php?act=delall&id="+curselid+"&pid="+curp;
			}
			/*function mytst()
			{
				//alert('ok');
				if(confirm("确定要删除吗?"))
				{
					alert('YES');
				}
				else
				{
					alert('NO');
				}
			}*/
			function delone(ids,page)
			{
				if(confirm("确定要删除吗？"))
				{
					location.href="news_del.php?id="+ids+"&pid="+page;
				}
			}
		</script>
	</head>
	<body>
	<form action='news_index.php' method='get'>
		新闻标题：<input type='text' name='ntitle' value="<?php echo $ntitle; ?>">
		新闻类型：<select name='ntype'>
									<option value="">--请选择--</option>
									<?php
										foreach($typeArr as $v)
										{
											if($ntype==$v['id'])
											{
												echo "<option selected value='{$v['id']}'>{$v['tname']}</option>";
											}
											else
											{
												echo "<option value='{$v['id']}'>{$v['tname']}</option>";
											}
										}
									?>
								</select>
								<input type='submit' value='查询'>
	</form>
	<!--	<a href="javascript:;" onclick="mytst();">测试</a>-->
		<table>
			<tr>
				<td>序号<input  type='checkbox' onclick="selall(this);"></td>
				<td>新闻标题</td>
				<td>新闻类型</td>
				<td><a href="news_add.php">添加</a></td>
			</tr>
			<?php
				for($i=0;$i<count($nArr);$i++)
				{
				?>	
				<tr>
					<td><?php echo $nArr[$i]['id']; ?>
						<input type='checkbox' name='selid' class='sels' value='<?php echo $nArr[$i]['id']; ?>'>
					</td>
					<td><?php echo $nArr[$i]['title']; ?></td>
					<td><?php echo $nArr[$i]['tname']; ?></td>
					<td>
					<a href="news_update.php?nid=<?php echo $nArr[$i]['id']; ?>&page=<?php echo $curp; ?>">修改</a>
					<a href='javascript:;' onclick="delone2('<?php echo $nArr[$i]['id']?>','<?php echo $curp; ?>');">删除</a>
					<!--<a href="javascript:;" onclick="delone('<?php echo $nArr[$i]['id']?>','<?php echo $curp; ?>');">	删除</a>-->
					<!--<a href="news_del.php?id=<?php echo $nArr[$i]['id']; ?>&pid=<?php echo $curp; ?>">删除</a>-->
					</td>
				</tr>
			<?php
				}
			?>
			<tr>
				<td colspan="4">
				<?php
					echo $pageObj->pageBar(5); 
				?>
				&nbsp;<a href='javascript:;' onclick="delall2();">全删</a>
				<!--
				&nbsp;<a href='javascript:;' onclick="delall('<?php echo $curp;  ?>');">全删</a>
				-->
				</td>
			</tr>
		</table>
	</body>
</html>