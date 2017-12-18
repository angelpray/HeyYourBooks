<?php
include_once './lib/func.php';
if($login=checkLogin())
{
  $user=$_SESSION['user'];
}
//查询商品
//检查page参数
$page=isset($_GET['page'])?intval($_GET['page']):1;
//把page与1对比，取中间最大值
$page=max($page,1);
$school=$_GET['school'];
$grade=$_GET['grade'];
$subject=$_GET['subject'];
//每页显示条数
$pageSize=10;

//page 1 limit 0,2;
//page 2 limit 2,2;

$offset=($page-1)*$pageSize;

$con=mysqlInit('localhost','root','','imooc_mall');

$sql="SELECT COUNT(`id`) as total FROM `im_goods` WHERE `status`=1 AND `grade`='$grade' AND `school`='$school' AND `subject`='$subject'";
$obj=mysqli_query($con,$sql);
$result=mysqli_fetch_assoc($obj);
//赋值total，以便后面的函数使用
$total=isset($result['total'])?$result['total']:0;
//判断用户从URL中直接写入URL得到的页数是否正确
if($page>ceil($total/$pageSize))
{
  msg('2','没有相关书籍请重新选择');
}
//释放
unset($sql,$result);

//限制一页只显示2个
$sql="SELECT `id`,`name`,`pic`,`des` FROM `im_goods` WHERE `status`=1 AND `grade`='$grade' AND `school`='$school' AND `subject`='$subject' ORDER BY `id`asc,`view` desc LIMIT {$offset},{$pageSize} ";
$obj=mysqli_query($con,$sql);
$goods=Array();
while($result=mysqli_fetch_assoc($obj)){
  $goods[]=$result;//array_push();
}
pageUrl($page);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/index.css" />
    <link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
</head>
<body>
  <div class="header">
      <div class="logo f1">
          <a href="index.html"><img src="./static/image/logo.png"></a>
      </div>
      <div class="col-lg-6">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Go!</button>
            </span>
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
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

        <div class="img-content">
          <h1>搜索结果</h1>
            <ul>
              <?php foreach($goods as $v): ?>
                <li>
                  <a href=<?php echo "detail.php?id="."{$v['id']}";?>>
                    <img class="img-li-fix" src="<?php echo  $v['pic'];?>" alt="<?php echo $v['name'];?>"  style="width:116px;height:145px;">
                  </a>
                    <div class="info">
                        <a href=<?php echo "detail.php?id="."{$v['id']}";?>> <h3 class="img_title"><?php echo $v['name']; ?></h3></a>
                        <p>
                            <!-- <?php echo $v['des']?> -->
                        </p>
                        <!-- <div class="btn">
                            <a href="edit.php?id=<?php echo $v['id']; ?>"class="edit">编辑</a>
                            <a href="delete.php?id=<?php echo $v['id']; ?>" class="del">删除</a>
                        </div> -->
                    </div>
                </li>
              <?php endforeach; ?>
            </ul>
        </div>
        <?php echo pages($total,$page,$pageSize,4); ?>
        <!-- <div class="page-nav">
            <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">上一页</a></li>
                <li><span class="first-page">1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>...</li>
                <li><a href="#">98</a></li>
                <li><a href="#">99</a></li>
                <li><a href="#">下一页</a></li>
                <li><a href="#">尾页</a></li>
            </ul>
        </div> -->
    </div>

    <div class="footer">
        <p><span>HEY-YOU BOOk</span>©2017 POWERED BY AngeLSmi1e</p>
    </div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<!-- <script type="text/javascript">
  $(function(){
    $('.del').on('click',function(){
      if(confirm('确认删除该画品吗？'))
      {
        window.location=$(this).attr('href');
      }
      return false;
    })
  })
</script> -->
<!-- <script src="./static/js/layer/layer.js"></script> -->
</html>
