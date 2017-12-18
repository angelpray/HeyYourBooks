<?php
include_once './lib/func.php';
if(!checkLogin()){
  // msg(2,'请登录','login.php');
  echo "false";
  return false;
}
$user=$_SESSION['user'];
$goodsId=isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):'';
if(!$goodsId){
  msg(2,'参数非法','index.php');
}
$con=mysqlInit('localhost','root','','imooc_mall');
$sql="SELECT * FROM `im_goods` WHERE `id`={$goodsId} LIMIT 1";
$obj=mysqli_query($con,$sql);
//挡根据ID找到的信息不存在时，跳转商品列表
if(!$goods=mysqli_fetch_assoc($obj)){
  msg(2,'画品不存在','index.php');
}
//更新发布人

unset($sql,$obj);
$sql="SELECT `username`,`contact` FROM `im_user` WHERE `id`={$goods['user_id']}";
$obj=mysqli_query($con,$sql);
$publisher=mysqli_fetch_assoc($obj);

//更新view
unset($sql,$obj);
$sql="UPDATE `im_goods` SET `view`=`view`+1 WHERE `id`={$goods['id']}";
$obj=mysqli_query($con,$sql);
?>

<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $goods['name'] ?></title>
    <script src="./static/js/jquery-1.10.2.min.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/detail.css" />
    <link rel="stylesheet" href="static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/Font-Awesome/css/font-awesome.min.css">
<!-- <link rel="stylesheet" type="text/css" href="style/reset.css" />
    <link rel="stylesheet" type="text/css" href="style/style.css" /> -->
</head>
<body class="bgf8">
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
          <ul>
              <li><a href="userinfo.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>个人信息</button></a></li>
              <li><a href="publish.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>发布</button></a></li>
              <li><a href="login_out.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>退出</button></a></li>
          </ul>
      </div>
  </div>
    <div class="mycontent">
        <div class="mysection" style="margin-top:20px;">
            <div class="width1200">
                <div class="fl"><img src="<?php echo $goods['pic'] ?>" width='720px' height='520px'/></div>
                <div class="fl sec_intru_bg">
                    <dl>
                        <dt><?php echo $goods['name'] ?></dt>
                        <dd>
                            <p>发布人：<span><?php echo $publisher['username'] ?></span></p>

                            <p>发布时间：<span><?php  echo date('Y-m-d',$goods['create_time']) ?></span></p>
                            <p>学校：<span><?php echo $goods['school'] ?> </span></p>
                            <p>适用专业：<span><?php echo $goods['subject'] ?> </span></p>
                            <p>适用年级：<span><?php echo $goods['grade'] ?> </span></p>
                            <p>浏览次数：<span><?php echo $goods['view'] ?></span></p>
                        </dd>
                    </dl>
                    <ul>
                        <li>售价：<br/><span class="price"><?php echo $goods['price'] ?></span>元</li>
                        <li class="mybtn"><a href="javascript:;" class="mybtn mybtn-bg-red" style="margin-left:38px;" id="buy">立即购买</a></li>
                        <!-- <li class="mybtn"><a href="javascript:;" class="mybtn mybtn-sm-white" style="margin-left:8px;">收藏</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="secion_words">
            <div class="width1200">
                <div class="secion_wordsCon">
                    <?php echo $goods['content']; ?>
                </div>
            </div>
          </div>
            </div>
            <div class="footer">
                <p><span>HEY-YOU BOOk</span>©2017 POWERED BY AngeLSmi1e</p>
            </div>
        </div>
    </body>
    <script src="js/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#buy').click(function(){
          // alert($('#contact').text());
          var contact='请与卖家联系,'+'<?php echo $publisher['contact']; ?>';
          layui.use('layer', function(){
            var layer = layui.layer;
            layer.tips(contact, '#buy', {
              tips: [1, '#3595CC'],
              time: 4000
            });
          });
        })
      })
    </script>
    </html>
