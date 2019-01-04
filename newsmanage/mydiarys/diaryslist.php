<?php
define('IN_PHP',44);
include_once 'class/mysql.class.php';
include_once 'class/Page.class.php';
//查询条件[日记标题]
$gtitle=isset($_GET['gnames'])?$_GET['gnames']:"";
//查询条件[日记类型]
$gtype=isset($_GET['gtype'])?$_GET['gtype']:"";
$wheres="";
if($gtitle!="")
{
	$wheres="and dtitles like '%{$gtitle}%' ";
}
if($gtype!="")
{
	$wheres=$wheres." and d.tid=' {$gtype}' ";
}
//echo $wheres;
//第几页
$pno=isset($_GET['pno'])?$_GET['pno']:1;

$dbObj=new db_mysql('localhost','root','','riji');

$sql="select count(*) as n from ty_diary  as d where flag=0 ".$wheres;
$totalArr=$dbObj->getone($sql);
$pageObj=new Page($totalArr['n'],10);

$sql="select d.*,t.tname from ty_diary as d 
	        left join dy_type as t on d.tid=t.tid 
	        where  d.flag=0 {$wheres} limit ".$pageObj->limit();
$diaryArr=$dbObj->getall($sql);
//查询所有未删除的日志类型
$sql="select * from dy_type where tflag=1 ";
$typeArr=$dbObj->getall($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>我的日记</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="Css/style.css" />
    <script type="text/javascript" src="Js/jquery2.js"></script>
    <script type="text/javascript" src="Js/jquery2.sorted.js"></script>
    <script type="text/javascript" src="Js/bootstrap.js"></script>
    <script type="text/javascript" src="Js/ckform.js"></script>
    <script type="text/javascript" src="Js/common.js"></script>

	<script>
	//单删
	function delone(curid,pages)
	{
		if(confirm("确定要删除吗？"))
		{
				$.post("diarysdel.php",{'ids':curid},function(d)
				{
					if(d.flg)
					{
						alert("删除成功");
						location.href="diaryslist.php?pno="+pages;
					}
					else
					{
						alert("删除失败");
					}
				},'json')
		}
	
	}
	//全选/全不选
	function selall(obj)
	{
		$(".curid").each(function(i,o)
		{
			o.checked=obj.checked;
		})
	}
	//多删
	function delall(pages)
	{
		var chkstr="";
		$(".curid").each(function(i,o)
		{
			if(o.checked)
			{
				//alert(o.value);
				chkstr=chkstr+o.value+',';
			}
		})
		if(chkstr=="")
		{
			alert("请选择要删除的记录");
			return;
		}
		if(confirm("确定要删除吗？"))
		{
			$.post("diarysdel.php",{"ids":chkstr,"act":"delall"},function(d)
			{
				if(d.flg)
				{
					alert("删除成功");
					location.href="diaryslist.php?pno="+pages;
				}
				else
				{
					alert("删除失败");
				}
			},'json')
		}
	}
	</script>
    <style type="text/css">
        body {font-size: 20px;
		font-size: 20px;
            padding-bottom: 40px;
            background-color:#e9e7ef;
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
		img
		{
			width:100px;
			height:100px;
		}

    </style>
</head>
<body >
<form class="form-inline definewidth m20" action="diaryslist.php" method="get">
    <font color="#777777"><strong>日记标题：</strong></font>
    <input type="text" name="gnames" id="gnames"class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
	日记类别：
	<select name="gtype" id="gtype">
	<option value=''>-请选择-</option>
	<?php 
		foreach($typeArr as $v)
		{
				echo "<option value='{$v['tid']}'>{$v['tname']}</option>";
		}
	?>
	</select>&nbsp;&nbsp;
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
</form>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
	    <th>ID<input type="checkbox" onclick="selall(this)"></th>
		<th>日记类别</th>
        <th>日记标题</th>
		<th>心情指数</th>
        <th>是否发布</th>
        <th>发布日期</th>
		<th>动作</th>
    </tr>
    </thead>
		<?php
			foreach($diaryArr as $v)
			{
		?>
        <tr>
                <td><?=$v['did']?><input type="checkbox" class="curid" value="<?=$v['did']?>"></td>
                <td><?=$v['tname']?></td>
                <td><?=$v['dtitles']?></td>
                <td><img src="<?=$v['dpic']?>"></td>
				<td>
					<?php
						if($v['drelease']==1)
						{
							echo '是';
						}
						else
						{
							echo '否';
						}
					?>
				</td>
				<td><?=date('Y-m H:i:s',$v['timeline']) ?></td>
                <td>
				<a href="diarysedit.php?did=<?=$v['did'] ?>&page=<?=$pno ?>">修改</a> &nbsp;
				<a href="javascript:;" onclick="delone('<?=$v['did']?>','<?=$pno?>');">删除</a>
				</td>
               
        </tr>
		<?php
			}
		?>
		<tr>
		        <td colspan="8" ><a href="javascript:;" onclick="delall('<?=$pno?>');">全删</a>
				&nbsp;&nbsp;<?php echo $pageObj->pageBar(5) ?>
				</td>
		</tr>
           
       
       </table>

</body>
</html>
