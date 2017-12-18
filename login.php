<?php
//开启settion,保持登录
include_once './lib/func.php';
if(checkLogin()){
  msg(1,'你已经登录','index.html');
}
  if(!empty($_POST['username'])){

    $username=trim($_POST['username']);
    $password=trim($_POST['password']);
    //判断用户输入的数据，以便插入
    //判断用户名不能为空
    if(!$username){
      msg(2,'用户名不能为空');
    }
    if(!$password){
      msg(2,'密码不能为空');
    }
    //数据库操作
    $con =mysqlInit('localhost','root','','imooc_mall');
    if(!$con){
      echo mysql_error();exit;
    }

    //根据用户名查询用户；
    $sql="SELECT *FROM `im_user` WHERE `username`='{$username}' LIMIT 1";
    $obj=mysqli_query($con,$sql);
    //把运行SQL语句后得到的资源转为“关联数组”
    $result=mysqli_fetch_assoc($obj);

    if(is_array($result)&&!empty($result)){
      if(createPassword($password)===$result['password']){
        //登录的用户信息要写进sesstion中才可以，要进行会话处理
        //存储 Session 变量,这里就是一个用户
        $_SESSION['user']=$result;
        //登录成功后跳转到index.php
        header('location:index.html');
        exit;
      }
      else{
        msg(2,'密码错误,请重新输入','login.php');
      }
    }
    else{
      msg(2,'用户名不存在,请重新输入','login.php');
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|用户登录</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
    <link rel="stylesheet" type="text/css" href="./static/css/login.css">
    <link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
</head>
<body>
<div class="header">
    <div class="logo f1">
      <a href="index.html">
          <img src="./static/image/logo.png">
      </a>
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
            <div class="login-banner">
                <a href="#"><img src="./static/image/login_banner.png" alt=""></a>
            </div>
            <div class="user-login">
                <div class="user-box">
                    <div class="user-title">
                        <p>用户登录</p>
                    </div>
                    <form class="login-table" name="login" id="login-form" action="login.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input type="text" class="yhmiput" name="username" placeholder="Username" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input type="password" class="yhmiput" name="password" placeholder="Password" id="password">
                        </div>
                        <div class="login-btn">
                            <button type="submit">登录</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p><span>M-GALLARY</span> ©2017 POWERED BY IMOOC.INC</p>
</div>

</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script src="./static/js/layer/layer.js"></script>
<script>
    $(function () {
        $('#login-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val();
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


            return true;
        })

    })
</script>
</html>
