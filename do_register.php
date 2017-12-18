<?php
header('Content-Type: text/html; charset=UTF-8', true);
//对表单提交进行处理
  //这里必须要有条件，否则会立即执行PHP代码
    //判断用户输入的数据，以便插入
    //判断用户名不能为空
    if(!empty($_POST['username'])){
      include_once './lib/func.php';
      //不能对用户输入的任何数据信任
      //mysql_real_escape_string()进行过滤
      $username=trim($_POST['username']);
      $password=trim($_POST['password']);
      $repassword=trim($_POST['repassword']);
      $contact=trim($_POST['contact']);
      $userId=trim($_POST['id']);
      //判断用户输入的数据，以便插入
      //判断用户名不能为空
      if(!$username){
        msg(2,'用户名不能为空');
      }
      if(!$contact){
        msg(2,'用户名不能为空');
      }
      if(!$password){
        msg(2,'密码不能为空');
      }
      if(!$repassword){
        msg(2,'确认密码不能为空');
      }
      if($password!==$repassword){
        msg(2,'两次输入的密码不一致');
      }
      //数据库操作
      $con =mysqlInit('localhost','root','','imooc_mall');
      if(!$con){
        echo mysql_error();exit;
      }

      //因为是修改信息，所以不用判断用户是否存在
      //判断用户是否在数据表中存在
      // $sql="SELECT COUNT(`id`) as total
      // FROM `im_user` WHERE `username`='{$username}'";
      // $obj=mysqli_query($con,$sql);
      // $result=mysqli_fetch_assoc($obj);
      //
      // //验证用户名是否存在
      // if(isset($result['total'])&&$result['total']>0){
      //   msg(2,'用户已经存在，请重新输入');
      // }

      //密码加密处理
      $password=createPassword($password);
      //释放掉以前的变量
      unset($obj,$result,$sql);
      //插入数据库
      // $sql="UPDATE `im_goods`SET {$updateSql} WHERE `id`={$goodsId}";
      $sql="UPDATE `im_user` SET `username`='{$username}',`password`='{$password}',`contact`='{$contact}' WHERE `id`={$userId}";
      $result=mysqli_query($con,$sql);
      if($result){
        msg(1,"修改成功，你的用户名是:{$username}",'login_out.php');
      }
      else{
        echo mysqli_error($con);
      }
    }
 ?>
