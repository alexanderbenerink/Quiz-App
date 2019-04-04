$( document ).ready(function() {
  for ( var i = 0; i < numbOfQuestions ; i++ ) {
    var number = i + 1;
    var type = 'type-q' + number;
    var radios = document.forms['questions'].elements[type];
    for ( var n = 0, max = radios.length; n < max; n++ ) {
      radios[n].onclick = function() {
        var name = this.name;
        var number = name.replace( /^\D+/g, '' );
        var wrapper = document.getElementById( 'fieldset-wrapper-q' + number );
        $.get( "lib/quiz_creator_api.php", { questionType: this.value, questionNumber : number }, function( data ) {
          $( wrapper ).html( data );
        }); 
      }
    }
  }
});
