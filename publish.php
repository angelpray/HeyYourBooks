<?php
include_once('./lib/func.php');
//为了保持用户的登录状态需要检测是否已经登录！登录后直接跳转到主页
  if (!checkLogin()) {
      msg(2, '请登录', 'login.php');
  }
  //为了让页面显示管理员的名字，必须要把session放在判断外面
  $user=$_SESSION['user'];
  //进行表单处理
  if (!empty($_POST['name'])) {
      $con=mysqlInit('localhost', 'root', '', 'imooc_mall');

      //$name=mysqli_real_escape_string($con,trim($_POST['name']))
      $name=$_POST['name'];
      $price =intval($_POST['price']);
      $school=$_POST['school'];
      $grade=$_POST['grade'];
      $subject=$_POST['subject'];
      $des=mysqli_real_escape_string($con, $_POST['des']);
      $content=mysqli_real_escape_string($con, $_POST['content']);
      $nameLength=mb_strlen($name, 'utf-8');
      // var_dump($name);
      if ($nameLength<=0||$nameLength>30) {
          msg(2, '30字之内');
      }

      $desLength=mb_strlen($des, 'utf-8');
      if ($desLength<=0||$desLength>100) {
          msg(2, '100字之内');
      }

      if (empty($school)) {
          msg(2, '学校不能为空');
      }
      if (empty($grade)) {
          msg(2, '年级不能为空');
      }
      if (empty($subject)) {
          msg(2, '专业不能为空');
      }
      if (empty($content)) {
          msg(2, '详情不能为空');
      }

      $userId=$user['id'];
      $now=$_SERVER['REQUEST_TIME'];

      $pic=imgUpload($_FILES['file']);
      //验证商品的唯一性
      $sql="SELECT COUNT(`id`) as `total` FROM `im_goods` WHERE `name`='{$name}' AND `user_id`={$userId} AND `status`=1";
      $obj=mysqli_query($con, $sql);
      $result=mysqli_fetch_assoc($obj);
      if (isset($result['total'])&&$result['total']>0) {
          msg(2, '商品已存在');
      }
      //插入数据库
      $sql="INSERT `im_goods`(`name`,`price`,`pic`,`des`,`content`,`user_id`,`create_time`,`update_time`,`view`,`status`,`subject`,`grade`,`school`)
    VALUES('{$name}','{$price}','{$pic}','{$des}','{$content}','{$userId}','{$now}','{$now}',0,1,'{$subject}','{$grade}','{$school}')";
      if (mysqli_query($con, $sql)) {
          msg(1, '操作成功', 'index.html');
      } else {
          echo mysqli_error($con);
          exit;
      }
  }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|发布画品</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
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
            <li><a href="userinfo.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>个人信息</button></a></li>
            <li><a href="login_out.php"><button class="btn btn-primary"><i class="icon-circle-arrow-right"></i>退出</button></a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="addwrap">
        <div class="addl fl">
            <header>发布画品</header>
            <form name="publish-form" id="publish-form" action="publish.php" method="post"
                  enctype="multipart/form-data">
                <div class="additem">
                    <label id="for-name">教材名称</label><input type="text" name="name" id="name" placeholder="请输入教材名称">
                </div>
                <div class="additem">
                  <label id="for-school">学校</label>
                  <select class="data-book" name="school">
                    <option value="" selected>选择该书籍适用的学校</option>
                    <option value="中山大学新华学院">中山大学新华学院</option>
                    <option value="哈佛大学">哈佛大学</option>
                    <option value="东京大学">东京大学</option>
                    <option value="耶鲁大学">耶鲁大学</option>
                  </select>
                </div>
                <div class="additem">
                    <label id="for-grade">适用年级</label>
                    <select class="data-book" name="grade">
                      <option value="" selected>选择该书籍适用的年级</option>
                      <option value="大一">大一</option>
                      <option value="大二">大二</option>
                      <option value="大三">大三</option>
                      <option value="大四">大四</option>
                    </select>
                </div>
                <div class="additem">
                    <label id="for-subject">适用专业</label>
                    <select class="data-book" name="subject">
                      <option value="" >选择该书籍适用的专业</option>
                      <option value="软件工程">软件工程</option>
                      <option value="计算机科学">计算机科学</option>
                      <option value="会计学">会计学</option>
                      <option value="经济学">经济学</option>
                    </select>
                </div>
                <div class="additem">
                    <label id="for-price">价值</label><input type="text" name="price" id="price" placeholder="请输入教材价值">
                </div>
                <div class="additem">
                    <!-- 使用accept html5属性 声明仅接受png gif jpeg格式的文件                -->
                    <label id="for-file">教材图片</label><input type="file" accept="image/png,image/gif,image/jpeg" id="file"
                                                          name="file" style="display:inline;">
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-des">教材简介</label><textarea id="des" name="des"
                                                                           placeholder="请输入画品简介"></textarea>
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-content">教材详情</label>
                    <div style="margin-left: 120px" id="container">
                        <textarea id="content" name="content"></textarea>
                    </div>

                </div>
                <div style="margin-top: 20px">
                    <button type="submit">发布</button>
                </div>
            </form>
        </div>
        <div class="addr fr">
            <img src="./static/image/index_banner.png">
        </div>
    </div>

</div>
<div class="footer">
    <p><span>HEY-YOU BOOk</span>©2017 POWERED BY AngeLSmi1e</p>
</div>
</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script src="./static/js/layer/layer.js"></script>
<script src="./static/js/kindeditor/kindeditor-all-min.js"></script>
<script src="./static/js/kindeditor/lang/zh_CN.js"></script>
<script>
    var K = KindEditor;
    K.create('#content', {
        width      : '475px',
        height     : '400px',
        minWidth   : '30px',
        minHeight  : '50px',
        items      : [
            'undo', 'redo', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'clearhtml',
            'fontsize', 'forecolor', 'bold',
            'italic', 'underline', 'link', 'unlink', '|'
            , 'fullscreen'
        ],
        afterCreate: function () {
            this.sync();
        },
        afterChange: function () {
            //编辑器失去焦点时直接同步，可以取到值
            this.sync();
        }
    });
</script>

<script>
    $(function () {
        $('#publish-form').submit(function () {
            var name = $('#name').val(),
                price = $('#price').val(),
                file = $('#file').val(),
                des = $('#des').val(),
                content = $('#content').val();
            if (name.length <= 0 || name.length > 30) {
                layer.tips('教材名应在1-30字符之内', '#name', {time: 2000, tips: 2});
                $('#name').focus();
                return false;
            }
            //验证为正整数
            if (!/^[1-9]\d{0,8}$/.test(price)) {
                layer.tips('请输入最多9位正整数', '#price', {time: 2000, tips: 2});
                $('#price').focus();
                return false;
            }

            if (file == '' || file.length <= 0) {
                layer.tips('请选择图片', '#file', {time: 2000, tips: 2});
                $('#file').focus();
                return false;

            }

            if (des.length <= 0 || des.length >= 100) {
                layer.tips('教材简介应在1-100字符之内', '#content', {time: 2000, tips: 2});
                $('#des').focus();
                return false;
            }

            if (content.length <= 0) {
                layer.tips('请输入教材详情信息', '#container', {time: 2000, tips: 3});
                $('#content').focus();
                return false;
            }
            return true;

        })
    })
</script>
</html>
