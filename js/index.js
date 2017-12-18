function showpage(url){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4){
            document.getElementById('row').innerHTML = xhr.responseText;
        }
    }
    xhr.open('get',url);
    xhr.send(null);
}

function showUser(url){
  var xhr =new XMLHttpRequest();
  xhr.onreadystatechange=function(){
    if(xhr.readyState==4){
      if(xhr.responseText=="false"){
        layui.use('layer', function(){
          layer.msg('同学请登录', {
            icon: 2,
            time: 2500 //2秒关闭（如果不配置，默认是3秒）
          }, function(){
            location='login.php';
          })
      });
      }
      else if(url){
        location.href=url;
      }
      else{
        location.href='userinfo.php';
      }
    }
  }
  xhr.open('get','detail.php');
  xhr.send(null);
}

window.onload = function(){

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if(xhr.readyState==4){
        if(xhr.responseText=='false'){
          $('#login_out').css('display','none')
        }
        else{
          $('#login').css('display','none')
        }
      }
    }
    xhr.open('get','detail.php');
    xhr.send(null);

    document.getElementById('login_out').onclick=function(event){
      event.preventDefault();
      layui.use('layer', function(){
        layer.msg('登出成功', {
          icon: 1,
          time: 500 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
          location.href='login_out.php'
        })
      });

    }


    showpage('./index.php');
    document.getElementById("userInfo").onclick=function(){
      showUser();
    }

    $('.autocomplete-button').bind('click',function(){
      var submitUrl = 'search.php?' + 'searchKey=' + $('.autocomplete-input').val();
      location.href=submitUrl;
    })

    document.getElementById('category').addEventListener('click',function(event){
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function(){
        if(xhr.readyState==4){
          if(xhr.responseText=='false'){
            layui.use('layer', function(){
              layer.msg('请先登录', {
                icon: 2,
                time: 2500 //2秒关闭（如果不配置，默认是3秒）
              }, function(){
                location.href='login.php'
              })
            });
          }
          else{
            location.href='category.php'
          }
        }
      }
      xhr.open('get','detail.php');
      xhr.send(null);
    })
}
