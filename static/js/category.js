$(document).ready(function() {
  $('.choice').click(function() {

    var all = $(this).children('.all');
    all.slideToggle('normal');
  });

  $('#submit-book').click(function() {
    var submitUrl = 'result.php?' + 'school=' + $('#school').text() + '&grade=' + $('#grade').text() + '&subject=' + $('#subject').text();
    $(this).attr('href', submitUrl);
  });

  select('#select-school', '#school');
  select('#select-subject', '#subject');
  select('#select-grade', '#grade');
  // $('.all-school').children('li').hover(function(){
  //   $('#school').text($(this).text());
  // })
  // $('.all-school').children('li').hover(function(){
  //   $('#school').text($(this).text());
  // })
});

function select(selectId, selectThing) {
  $(selectId).children('li').hover(function() {
    $(selectThing).text($(this).text());
  })
}
