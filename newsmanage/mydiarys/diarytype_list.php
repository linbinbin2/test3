<?php
define('IN_PHP',44);
include_once 'class/mysql.class.php';
include_once 'class/Page.class.php';

//第几页
$pno=isset($_GET['pno'])?$_GET['pno']:1;

$dbObj=new db_mysql('localhost','root','','riji');

$sql="select count(*) as n from dy_type";
$totalArr=$dbObj->getone($sql);
$pageObj=new Page($totalArr['n'],10);

$sql="select * from dy_type  limit ".$pageObj->limit();
$typeArr=$dbObj->getall($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>日记类别列表</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="Css/style.css" />
    <script type="text/javascript" src="Js/jquery2.js"></script>
    <script type="text/javascript" src="Js/jquery2.sorted.js"></script>
    <script type="text/javascript" src="Js/bootstrap.js"></script>
    <script type="text/javascript" src="Js/ckform.js"></script>
    <script type="text/javascript" src="Js/common.js"></script>

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


    </style>
</head>
<body >
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
	    <th>ID<input type="checkbox"></th>
        <th>日记类别</th>
        <th>添加日期</th>
		<th>动作</th>
    </tr>
    </thead>
		<?php
			foreach($typeArr as $v)
			{
		?>
		
			
		
        <tr>
                <td><?php echo $v['tid']?><input type="checkbox" class="tids"></td>
                <td><?php echo $v['tname']?></td>
				<td><?php echo date('Y-m H:i:s',$v['tdate']) ?></td>
                <td> <a href="diarytype_sedit.php?tid=<?=$v['tid'] ?>&page=<?=$pno ?>&tname=<?=$v['tname']?>">修改</a> &nbsp;<a href="#">删除</a></td>
               
        </tr>
		<?php
			}
		?>
		<tr>
		        <td colspan="8" ><a href="#">全删</a>
				&nbsp;&nbsp;<?php echo $pageObj->pageBar(5) ?>
				</td>
		</tr>
           
       
       </table>

</body>
</html>
