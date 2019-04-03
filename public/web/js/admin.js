$(document).ready(function(){
  $('#contentCreate').submit(function(){
    var title = $('#content_title').val();
    $('#content_slug').val(title);
  });
})
