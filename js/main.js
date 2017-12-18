
$(document).ready(function(){
  $('.navbar [href^=#]').click(function (e) {
    e.preventDefault();
    var div = $(this).attr('href');
    $("html, body").animate({
    scrollTop: $(div).position().top}, "slow");
  });
  $(function() {
      $('select').comboSelect();
  });
  var proposals = ['javaScript权威指南', '你不知道的JavaScript', '计算机编程艺术', '网络工程师指南', 'tCP/IP全解', 'github入门实践', 'node.js实战','算法的乐趣','java牛逼','c++牛逼','linux牛逼','javaScript王者归来','javaScriptDom编程艺术','c++程序设计'];
  $('#search-form').autocomplete({
    hints: proposals,
    width: 300,
    height: 30,
    // onSubmit: function(text){
      // $('#message').html('Selected: <b>' + text + '</b>');
    // }
  });
});
