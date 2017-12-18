<?php
include_once './lib/func.php';

if(!checkLogin()){

  msg(2,'请登录','login.php');

}
if(!empty($_POST['name']))
{
  $con=mysqlInit('localhost','root','','imooc_mall');

  if(!$goodsId=intval($_POST['id']))
  {
    msg(2,'参数非法','index.php');
  }

  //根据商品ID校验商品信息
  $sql="SELECT * FROM `im_goods` WHERE `id`={$goodsId} LIMIT 1";
  $obj=mysqli_query($con,$sql);
  //挡根据ID找到的信息不存在时，跳转商品列表
  if(!$goods=mysqli_fetch_assoc($obj)){
    msg(2,'画品不存在','index.php');
  }

  $user=$_SESSION['user'];
  $name=mysqli_real_escape_string($con,trim($_POST['name']));
  $price =intval($_POST['price']);
  $school=$_POST['school'];
  $grade=$_POST['grade'];
  $subject=$_POST['subject'];
  $des=mysqli_real_escape_string($con,$_POST['des']);

  $content=mysqli_real_escape_string($con,$_POST['content']);
  $nameLength=mb_strlen($name,'utf-8');
  if($nameLength<=0||$nameLength>30){
    msg(2,'30字之内');
  }

  $desLength=mb_strlen($des,'utf-8');
  if($desLength<=0||$desLength>100){
    msg(2,'100字之内');
  }
  if(empty($school)){
    msg(2,'学校不能为空');
  }
  if(empty($grade)){
    msg(2,'年级不能为空');
  }
  if(empty($subject)){
    msg(2,'专业不能为空');
  }
  if(empty($content)){
    msg(2,'详情不能为空');
  }

  $update=array(
    'name'=>$name,
    'price'=>$price,
    'des'=>$des,
    'content'=>$content,
    'grade'=>$grade,
    'school'=>$school,
    'subject'=>$subject
  );
  //仅当用户上传了图片才进行图片上传处理
  if($_FILES['file']['size']>0)
  {
    $pic=imgUpload($_FILES['file']);
    $update['pic']=$pic;
  }

  //对比两个数组 对比数据库中用户表单数据
  foreach ($update as $key => $value) {
    if($goods[$key]==$value){
      unset($update[$key]);
    }
  }
  if(empty($update)){
    msg(2,'成功','detail.php?id=' . $goodsId);
  }

  //如果有修改，则数组加上一个修改时间
  $update['update_time']=$_SERVER['REQUEST_TIME'];

  //更新sql处理
  $updateSql='';
  foreach($update as $k=>$v){
    $updateSql .="`{$k}`='{$v}',";
  }
  //去除多余的,
  $updateSql=rtrim($updateSql,',');
  //这里可以优化，把where条件转化成字符串。
  unset($sql,$obj,$result);
  $sql="UPDATE `im_goods`SET {$updateSql} WHERE `id`={$goodsId}";
  //当更新成功
  if($result=mysqli_query($con,$sql))
  {
    // echo mysqli_affected_rows($con);exit;//影响行数
    msg(1,'操作成功','detail.php?id=' . $goodsId);
  }
  else
  {
    msg(2,'操作成功','detail.php?id=' . $goodsid);
  }
}
else{
  msg(2,'路由非法','index.php');
}
//更新：1.加入了修改时间：
//如果没有数据修改，则修改时间不变，否则在update数组中添加一个元素“update_time”
 ?>
