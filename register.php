<?php
header('Content-Type: text/html; charset=UTF-8', true);
//对表单提交进行处理
  //这里必须要有条件，否则会立即执行PHP代码
  date_default_timezone_set('PRC');
  if(!empty($_POST['username'])){
    include_once './lib/func.php';
    //不能对用户输入的任何数据信任
    //mysql_real_escape_string()进行过滤
    $username=trim($_POST['username']);
    $password=trim($_POST['password']);
    $repassword=trim($_POST['repassword']);
    $contact=trim($_POST['contact']);

    //判断用户输入的数据，以便插入
    //判断用户名不能为空
    if(!$username){
      msg(2,'用户名不能为空');
    }
    if(!$contact){
      msg(2,'联系方式不能为空');
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

    //判断用户是否在数据表中存在
    $sql="SELECT COUNT(`id`) as total
    FROM `im_user` WHERE `username`='{$username}'";
    $obj=mysqli_query($con,$sql);
    $result=mysqli_fetch_assoc($obj);

    //验证用户名是否存在
    if(isset($result['total'])&&$result['total']>0){
      msg(2,'用户已经存在，请重新输入');
    }

    //密码加密处理
    $password=createPassword($password);
    //释放掉以前的变量
    unset($obj,$result,$sql);
    //插入数据库
    //时间转换之后再作为SQL语句插入
    $time=date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);

    $sql="INSERT `im_user`(`username`,`password`,`create_time`,`contact`)
    VALUES('{$username}','{$password}','{$time}','{$contact}')";
    $obj=mysqli_query($con,$sql);
    if($obj){
      msg(1,"注册成功，你的用户名是:{$username}",'login_out.php');
    }
    else{
      echo mysqli_error($con);
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|用户注册</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
    <link rel="stylesheet" type="text/css" href="./static/css/login.css">
    <link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
</head>
<body>
<div class="header">
    <div class="logo f1">
          <a href="index.html"><img src="./static/image/logo.png"></a>
    </div>
    <div class="auth fr">
        <ul>
          <li><a href="login.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>登录</button></a></li>
          <li><a href="register.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>注册</button></a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="center">
        <div class="center-login">
            <!-- <div class="login-banner">
                <a href="#"><img src="./static/image/login_banner.png" alt=""></a>
            </div> -->
            <div class="user-login">
                <div class="user-box">
                    <div class="user-title">
                        <p>用户注册</p>
                    </div>
                    <form class="login-table" name="register" id="register-form" action="register.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input type="text" class="yhmiput" name="username" placeholder="Username" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input type="password" class="yhmiput" name="password" placeholder="Password" id="password">
                        </div>
                        <div class="login-right">
                            <label class="passwd">确认</label>
                            <input type="password" class="yhmiput" name="repassword" placeholder="Repassword"
                                   id="repassword">
                        </div>
                      <hr>
                        <div class="login-right" style="margin-top:10px;margin-bottom:10px;">
                            <label>联系</label>
                            <textarea name="contact" rows="8" cols="80" placeholder="例如： 手机：12345678912，微信：helloworld 等等联系方式"></textarea>
                        </div>
                        <input type="hidden" name="id">
                        <div class="login-btn">
                            <button type="submit">注册</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p><span>HEY-books</span> ©2017 POWERED BY Morningnight</p>
</div>

</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script src="./static/js/layer/layer.js"></script>
<script>
    $(function () {
        $('#register-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val(),
                repassword = $('#repassword').val();
            if (username == '' || username.length <= 0) {
                layer.tips('用户名不能为空', '#username', {time: 2000, tips: 2});
                $('#username').focus();
                return false;
            }

            if (password == '' || password.length <= 0) {
                layer.tips('密码不能为空', '#password', {time: 2000, tips: 2});
                $('#password').focus();
                return false;
            }

            if (repassword == '' || repassword.length <= 0 || (password != repassword)) {
                layer.tips('两次密码输入不一致', '#repassword', {time: 2000, tips: 2});
                $('#repassword').focus();
                return false;
            }
            return true;
        })

    })
</script>
</html>
