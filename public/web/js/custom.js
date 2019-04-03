$(document).ready(function(){

  //Gestion des QCMs
  $('#validation').click(function(){
    var countGoodAnswers = 0;

    $('.questionQcm').each(function(index){
      var i = index+1;

      //On compte le nombre de réponses valides dans la question
      var numberOfValid = $(this).find('.valid').length;

      //On initialise le nombre de bonnes réponses
      var number = 0;

      //Loop sur les réponses valides
      $(this).find('input').each(function(){
        //Si la réponse est checkée et valide, on incrémente le nombre de bonnes réponses
        if($(this).is(':checked') && $(this).hasClass('valid')){
          number = number + 1;
        } else if($(this).is(':checked') && $(this).hasClass('no-valid')){
          number = number - 1;
        }
      });


      //On compare le nombre de bonnes réponses aux nombres de réponses valides dans la question
      if (numberOfValid == number){
        $('.result-'+(i)).html('<p class="text-success">Bonne réponse.</p>');
        countGoodAnswers = countGoodAnswers + 1;
      } else {
        $('.result-'+(i)).html('<p class="text-danger">Mauvaise réponse.</p>');
      }

    });

    var numberQuestions = $('.questionQcm').length;
    if (numberQuestions == countGoodAnswers)
    {
      $('#next').toggle();
      $('#qcm').slideToggle();
      var contentid = $('.contentid').val();
      var userid = $('.userid').val();
      var route = "http://symfony/index.php/content/"+contentid+"/"+userid ;
      console.log(route);
      $.ajax({
        url: route,
        type: 'POST',
        success: function(response){

        },
        error : function (response){

        }
      });
    }
  });
});
