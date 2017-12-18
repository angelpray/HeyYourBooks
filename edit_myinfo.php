<?php
header('Content-Type: text/html; charset=UTF-8', true);
//对表单提交进行处理
  //这里必须要有条件，否则会立即执行PHP代码
  include_once './lib/func.php';
  if(!$login=checkLogin()){
    msg(2,'请登录','login.php');
  }
  $user=$_SESSION['user'];
  $con=mysqlInit('localhost','root','','imooc_mall');
  $username=$user['username'];
  $contact=$user['contact'];
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>修改信息</title>
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
     <form class="" action="index.php" method="post">
     <div class="col-lg-6">
         <div class="input-group">
             <input type="text" class="form-control" placeholder="Search for..." name="searchKey">
             <span class="input-group-btn">
               <button class="btn btn-default" type="submit">Go!</button>
             </span>
         </div><!-- /input-group -->
       </div><!-- /.col-lg-6 -->
     </form>
     <div class="auth fr">
         <ul><?php if ($login): ?>
             <li><a href="userinfo.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>个人信息</button></a></li>
             <li><a href="publish.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>发布</button></a></li>
             <li><a href="category.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>分类</button></a></li>
             <li><a href="login_out.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>退出</button></a></li>
           <?php else: ?>
             <li><a href="login.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>登录</button></a></li>
           <?php endif; ?>
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
                         <p>修改信息</p>
                     </div>
                     <form class="login-table" name="register" id="register-form" action="do_register.php" method="post">
                         <div class="login-left">
                             <label class="username">用户名</label>
                             <input type="text" class="yhmiput" name="username" placeholder="Username" id="username" value="<?php echo $user['username'];?>">
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
                         <div class="login-right">
                             <label class="passwd">联系</label>
                             <input type="tel" class="yhmiput" name="contact" placeholder="例如： 手机：12345678912"
                                    id="repassword"  value="<?php echo $user['contact'];?>" >
                         </div>
                         <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                         <div class="login-btn">
                             <button type="submit">修改</button>
                         </div>
                     </form>

                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="footer">
     <p><span>HEY-YOU BOOk</span> ©2017 POWERED BY AngeLSmi1e</p>
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
