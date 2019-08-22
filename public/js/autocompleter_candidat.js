// ATTENTION ! A completer! 
// https://funweb.fr/article/creation-d-une-barre-de-recherche-autocomplete-en-symfony-3/1
$(document).ready(function () {
  'use strict';
  $('#form_candidat').autocompleter({
    url_list: '/search-message',
    url_get: '/?term='
  });


  $("#ui-id-1").click(function(){
    var id = $("#form_candidat").val();

    if(id.toString().length > 0){
      $(location).attr('href', '/message/'+id.toString());
    }
  })

}); 