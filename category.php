<?php
include_once('./lib/func.php');
//为了保持用户的登录状态需要检测是否已经登录！登录后直接跳转到主页
  if (!checkLogin()) {
      msg(2, '请登录', 'login.php');
  }
  $user=$_SESSION['user'];
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>专注大学线下教材交易</title>
    <script src="static/js/jquery.js" charset="utf-8"></script>
    <script src="static/js/category.js" charset="utf-8"></script>
    <link rel="stylesheet" href="static/css/category.css">
    <link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
  </head>
  <body>
    <div class="layer">

    </div>

    <div class="mycontainer">
      <div class="header">
        <h1>专注大学教材线下交易</h1>
        here you book.
      </div>
      <div class="content">
        <div class="select">
          <div class="choice">
            <span id="school">请选择你的学校</span><img src="static/image/arrow_down.ico" class="icon" alt="ico">
            <div class="all-school all">
              <ul id="select-school">
                <li >中山大学新华学院</li>
                <li >广州大学</li>
                <li >华南理工大学</li>
              </ul>
            </div>
          </div>
      </div>
      <div class="select">
        <div class="choice">
          <span id="grade">请选择书籍的年级</span><img src="static/image/arrow_down.ico" class="icon"alt="ico">
          <div class="all-grade all">
            <ul id="select-grade">
              <li>大一</li>
              <li>大二</li>
              <li>大三</li>
              <li>大四</li>
            </ul>
          </div>
        </div>
    </div>
    <div class="select">
      <div class="choice">
        <span id="subject">请选择书籍的专业</span><img src="static/image/arrow_down.ico" class="icon"alt="ico">
          <div class="all-subject all">
          <ul id="select-subject">
            <li>软件工程</li>
            <li>计算机科学</li>
            <li>经济学</li>
          </ul>
          </div>
        </div>
      </div>
  </div>
  <a href="" id="submit-book">
    <button type="submit" class="btn btn-danger"><i class="icon-circle-arrow-right"></i>确认</button>
  </a>
  <div class="myfooter">
    <p><span class="callMe">Contact me&nbsp;</span>|&nbsp; <span class="net"><a href="index.html">返回首页</a></span></p>
  </div>
    </div>
  </body>
</html>
