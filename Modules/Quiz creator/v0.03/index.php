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
        }
      } 
    ?>
  </html>

</html>