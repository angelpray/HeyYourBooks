<?php
include_once './lib/func.php';
if(!checkLogin()){
  msg(2,'请登录','login.php');
}
$user=$_SESSION['user'];
$con=mysqlInit('localhost','root','','imooc_mall');
$username=$user['username'];
$user_id=$user['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>CSS网页布局</title>
	<link rel="stylesheet" href="static/css/userinfo.css">
	<link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
</head>
<body>
<!-- 头部 -->
	<div class="header">
		<h1 style="float:left; margin-left:100px;">welcome,<?php echo $username ?></h1>
		<div class="menu">
			<ul>
        <li><a class="btn btn-large btn-primary" href="index.html"><i class="icon-comment"></i>首页</a></li>
        <li><a class="btn btn-large btn-danger" href="mybooks.php?user_id=<?php echo $user_id?>">我的书籍</a></li>
        <li><a class="btn btn-large btn-danger" href="publish.php">发布书籍</a></li>
			</ul>
		</div>
	</div>
	<!-- 主体 -->
	<div class="main">
		<!-- 大图 -->
		<div class="pic">
			<img src="static/image/1.jpeg">
		</div>
		<!-- 遮罩层 -->
		<div class="topLayer">

		</div>
		<!-- 最上层的内容 -->

		<div class="mybtn">
				<div class="myinfo">
					<p>账号：<span><?php echo $username ?></span></p>
					<p>联系方式：<span><?php echo $user['contact'] ?></span></p>
				</div>
				<a href="edit_myinfo.php"><button>修改 &nbsp;&nbsp;&gt;</button></a>
		</div>
		<!-- 内容展示区 -->
		<div class="content">
			<!-- 上部分 -->
			<div class="top">
				<div>
					<div class="icon phone">
						<img src="static/image/phone.png" alt="">
						<div class="des">TELEPHONE</div>
					</div>
					<div class="icon weixin">
						<img src="static/image/weixin.png" alt="">
						<div class="des">WECHAT</div>
					</div>
					<div class="icon qq">
						<img src="static/image/qq.png" alt="">
						<div class="des">QQ</div>
					</div>
				</div>
			</div>
			<div style="clear:both;"></div><!-- 不加这句话的话，下面的背景会上移 -->
			<!-- 下部分 -->
		</div>
	</div>
	<!-- 底部 -->
	<div class="footer">
		© 2017 heyyoubook.com  京ICP备13046642号
	</div>
</body>
</html>
