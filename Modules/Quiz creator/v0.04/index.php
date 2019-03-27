<?php
  require_once "Classes/QuizCreator.php";
?>

<html>

  <head>
    <title> Quiz Creator Demo - v0.01 </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <?php
    $quizCreator = new QuizCreator();
  ?>

  <html>
    <?php
      if ( isset($_POST["create_quiz"]) ) {
        echo "<h1>Quiz successfully created</h1>";
        $quizCreator -> collectResults();
      } else if ( !isset($_POST["create_quiz"]) ) {
        echo "<h1>Quiz Creator Demo - v0.03</h1>";
        echo $quizCreator -> drawControlPanel();
         if (isset($_POST["numb_of_questions"]) ) {
          echo $quizCreator -> drawQuestionPanel();
          $numbOfQuestions = $quizCreator -> getNumbOfQuestions();
          echo "
            <script>
              for ( var i = 0; i < $numbOfQuestions ; i++ ) {
                var number = i + 1;
                var type = 'type-q' + number;
                var radios = document.forms['questions'].elements[type];
                for ( var n = 0, max = radios.length; n < max; n++ ) {
                  radios[n].onclick = function() {
                    var name = this.name;
                    var number = name.replace( /^\D+/g, '' );
                    var wrapper = document.getElementById( 'fieldset-wrapper-q' + number );
                    alert( wrapper.id + ', ' + number ); 
                  }
                }
              }
            </script>
          ";
        }
      } 
    ?>
  </html>

</html>