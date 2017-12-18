<?php
include_once './lib/func.php';
if ($login=checkLogin()) {
    $user=$_SESSION['user'];
}
//查询商品
//检查page参数
$page=isset($_GET['page'])?intval($_GET['page']):1;
//把page与1对比，取中间最大值
$page=max($page, 1);

//检查搜索关键词
$searchKey=isset($_GET['searchKey'])?$_GET['searchKey']:'';
//每页显示条数
$pageSize=6;
//page 1 limit 0,2;
//page 2 limit 2,2;

$offset=($page-1)*$pageSize;
$sql="SELECT COUNT(`id`) as total FROM `im_goods` WHERE `status`=1";
$con=mysqlInit('localhost', 'root', '', 'imooc_mall');
if($searchKey!=''){
  $sql="SELECT COUNT(`id`) as total FROM `im_goods` WHERE `status`=1 AND `name` regexp '$searchKey'" ;
}


$obj=mysqli_query($con, $sql);
$result=mysqli_fetch_assoc($obj);
//赋值total，以便后面的函数使用
$total=isset($result['total'])?$result['total']:0;
//判断用户从URL中直接写入URL得到的页数是否正确
if ($page>ceil($total/$pageSize)&&$total!=0) {
    msg('2', '只有4页');
}
//释放
unset($sql,$result);

//限制一页只显示2个
$sql="SELECT `id`,`name`,`pic`,`des` FROM `im_goods` WHERE `status`=1 ORDER BY `id`asc,`view` desc LIMIT {$offset},{$pageSize} ";
if($searchKey!=''){
  $sql="SELECT `id`,`name`,`pic`,`des` FROM `im_goods` WHERE `status`=1 AND `name` regexp '$searchKey' ORDER BY `id`asc,`view` desc LIMIT {$offset},{$pageSize}" ;
}
$obj=mysqli_query($con, $sql);
$goods=array();
while ($result=mysqli_fetch_assoc($obj)) {
    $goods[]=$result;//array_push();
}
pageUrl($page);
foreach ($goods as $v):
echo"    <div class='features-item col-md-4 col-sm-6'>";
echo"    <a href='javascript:showUser(\"detail.php?id={$v['id']}\")' id='book'>" . "<img src=\"{$v['pic']}\">";
echo"                 <h2> {$v['name']} </h2></a>";
echo"                <p>{$v['des']}</p></div>";


endforeach;
echo pages($total, $page, $pageSize, 4);
