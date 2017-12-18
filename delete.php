<?php
include_once('./lib/func.php');

//检验登录状态
if(!checkLogin())
{
  msg(2,'请登录','index.php');
}

//检验商品的ID合法
$goodsId=isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):"";
if(!$goodsId){
  msg(2,'参数非法','index.php');
}

//检验商品ID是否存在数据库中，不存在直接返回首页
$con=mysqlInit('localhost','root','','imooc_mall');
$sql="SELECT * FROM `im_goods` WHERE `id`={$goodsId}";
$obj=mysqli_query($con,$sql);
if(!$result=mysqli_fetch_assoc($obj)){
  msg(2,'商品不存在','index.php');
}

//更新操作
unset($sql,$obj,$result);
$sql="UPDATE `im_goods` SET `status`=-1 WHERE `id`={$goodsId}";
if($obj=mysqli_query($con,$sql)){
  msg(1,'删除成功');
}

//若出错，则输出错误信息
echo mysqli_error($con);
//注意：
//1.项目开发中不会真正删除数据，而是通过“状态码”来确认是否已经删除，但数据还是存在数据库中
 ?>
