<?php
//链接数据库
function mysqlInit($host,$username,$password,$dbName){
      //判断数据之后，如果能执行到这里，证明数据是正确的，连接数据库
      $con=mysqli_connect($host,$username,$password,$dbName);
      if(!$con){
        return false;
      }
      //设置字符集
      mysqli_set_charset($con,'utf-8');
      return $con;
}

//创建密码
function createPassword($password){
  if(!$password){
    return false;
  }
  return md5(md5($password.'HELLO'));
}

//消息提示
function msg($type,$msg=null,$url=null){
  $toUrl="location:msg.php?type={$type}";
  $toUrl.=$msg?"&msg={$msg}":'';
  $toUrl.=$url?"&url={$url}":'';
  header($toUrl);
  exit;
}

//上传文件
function imgUpload($file){
  //图像类型验证
  $type=$file['type'];
  if(!in_array($type,array('image/jpeg','image/png','image/gif'))){
    msg(2,'请上传符合格式的格式:jpg,gif,png');
  }
  //检查上传文件是否合法
  if(!is_uploaded_file($file['tmp_name'])){
    msg(2,'请上传符合规范的图像');
  }
  //上传处理
  //上传目录访问url
  $uploadPath='./static/file/';
  $uploadUrl='/static/file/';
  //上传文件夹
  $fileDir=date('Y/md/',$_SERVER['REQUEST_TIME']);
  if(!is_dir($uploadPath.$fileDir)){
    mkdir($uploadPath.$fileDir,0755,true);
  }
  $ext=pathinfo($file['name'],PATHINFO_EXTENSION);
  $img=uniqid().mt_rand(1000,9999).'.'.$ext;
  $imgPath=$uploadPath . $fileDir .$img;//物理地址
  $imgUrl='http://localhost/mall'.$uploadUrl.$fileDir.$img;//url地址

  //复制文件
  if(!move_uploaded_file($file['tmp_name'],$imgPath)){
    msg(2,'服务器繁忙,请稍后再试');
  }
  return $imgUrl;
}
//检查用户登录状态
function checkLogin(){
  session_start();
  //为了保持用户的登录状态需要检测是否已经登录！登录后直接跳转到主页
    if(!isset($_SESSION['user'])&&empty($_SESSION['user'])){
      return false;
    }
    return true;
}


function pages($total,$currentPage,$pageSize,$show=6){
  $pageStr='';
  //仅当综述大于每页条数才进行分页处理
  if($total>$pageSize)
  {
    //需要向上取整
    $totalPage=ceil($total/$pageSize);
    //对当前页进行容错处理
    $currentPage=$currentPage>$totalPage?$totalPage:$currentPage;

    //分页起始页，处理最小值为1，当currentPage小于show/2(show/2，用当前页-总条目的一半=左边的,剩下的就是右边的)
    $from=max(1,($currentPage-intval($show/2)));

    //分页结束页,长度问题：需要-1;
    $to =$from+$show-1;

    //当结束页大于总页,长度问题：需要+1
    if($to>$totalPage){
       $to=$totalPage;
       //最小值处理，当show大于total值
       $from=max(1,$to-$show+1);
    }


    // $pageStr .='<div class="page-nav">';
    // $pageStr .= '<ul>';

    //仅当当前页大于1，存在首页和上一页
    if($currentPage>1){
      $pageStr.="<a id='prev' href='javascript:showpage(\"".pageUrl($currentPage-1)."\")'><span class='icon fa fa-arrow-circle-left'></a>";
    }
    // if($from>1){
    //   $pageStr.='<li>...</li>';
    // }
    //
    // for($i=$from;$i<=$to;$i++)
    // {
    //   if($i!=$currentPage){
    //     $pageStr.="<li><a href='javascript:showpage(\"".pageUrl($i)."\")'>{$i}</a></li>";
    //   }
    //   else{
    //     $pageStr .="<li><span class='curr-page'>{$i}</span></li>";
    //   }
    // }
    //
    // if($to<$totalPage){
    //   $pageStr.='<li>...</li>';
    // }
    if($currentPage<$totalPage){
      $pageStr.="<a id='next' href='javascript:showpage(\"".pageUrl($currentPage+1)."\")'><span class='icon fa fa-arrow-circle-right'></a>";
    }

    // $pageStr .='</div>';
    // $pageStr .= '</ul>';
  }
  return $pageStr;
}

//获取当前的URL
function getUrl()
{
  $url='';
  //https端口为443，http端口为80
  // $url.=$_SERVER['SERVER_PORT']==443?'https://':'http://';
  // //获取域名
  // $url.=$_SERVER['HTTP_HOST'];
  //获取query_string,也就是？后面的内容
  $url.=$_SERVER['REQUEST_URI'];
  return $url;
}

//点击按钮后的URL
function pageUrl($page,$url='')
{
  $url=empty($url)?getUrl():$url;
  //查询？的位置
  $pos=strpos($url,'?');
  if($pos===false){
    $url.='?page='.$page;
  }
  else
  {
    $querystring=substr($url,$pos+1);
    //解析querystring为数组
    parse_str($querystring,$queryArr);
    if(isset($queryArr['page']))
    {
      unset($queryArr['page']);
    }
    $queryArr['page']=$page;
    //将queryArr重新拼接成queryString
    $queryString=http_build_query($queryArr);
    $url=substr($url,0,$pos+1).$queryString;
  }
  return $url;
}

?>
