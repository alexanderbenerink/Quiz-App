<?php
  require_once "Classes/QuizCreator.php";
?>

<html>

  <head>
    <title> Quiz Creator Demo - v0.01 </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  </head>

  <?php
    $quizCreator = new QuizCreator();
  ?>

  <body>
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
              var numbOfQuestions = $numbOfQuestions;
            </script>
            <script src='js/radios.js'></script>
          ";
        }
      } 
    ?>
  </body>

</html>