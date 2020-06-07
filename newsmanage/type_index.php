<?php
$curp=isset($_GET['pno'])?$_GET['pno']:"1";
define('IN_PHP',12);
$files = str_replace('\\','/',dirname(dirname(__FILE__)));
define('FILES',$files);
include_once FILES.'/newsmanage/class/mysql.class.php';
include_once FILES.'/newsmanage/class/Page.class.php';
$sqlCon = new db_mysql('localhost','root','','new');


$sql="select count(*) as n from tb_type";
$tArr = $sqlCon->getone($sql);
$page = new Page($tArr['n']);
$sql="select * from tb_type order by id desc limit ".$page->limit();
$nArr = $sqlCon->getall($sql);
?>
<html>
	<head>
		<title>类型列表</title>
		<script>
		function delone(ids,page)
		{
			if(confirm("确定要删除吗?"))
			{
				location.href="type_del.php?id="+ids+"&pid="+page;
			}
		}
		</script>
	</head>
	<body>
		<table>
			<tr width='100%'>
				<td width='40%'>序号</td>
				<td width='40%'>类型标题</td>
				<td width='20%'><a href='type_add.php'>添加</a></td>
			</tr>
			<tr>
			<?php
			for($n=0;$n<count($nArr);$n++){
			?>
			</tr>
			<tr>
			<td><?php echo $nArr[$n]['id']?></td>
			<td><?php echo $nArr[$n]['tname']?></td>
			<td>
			<a href="type_update.php?nid=<?php echo $nArr[$n]['id'];?>&page=<?php echo $curp; ?>">修改</a> 
			<a href="javascript:;" onclick="delone('<?php echo $nArr[$n]['id']?>','<?php echo $curp?>')">删除</a>
			</td>
			</tr>
			<tr>	
			<?php
			}
			?>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan='4' align='center'>
				<?php
					echo $page->pageBar(1);
				?>
				</td>
			</tr>
		</table>
	</body>
</html>