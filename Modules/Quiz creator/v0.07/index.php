<?php
  require_once "Classes/QuizCreator.php";
?>

<html>

  <head>
    <title> Quiz Creator Demo - v0.07 </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  </head>

  <?php
    $quizCreator = new QuizCreator();
  ?>

  <body>
    <main>
      <?php
        echo "<h1>Quiz Creator Demo - v0.07</h1>";
        if ( isset($_POST["create_quiz"]) ) {
          $quizCreator -> collectResults();
          echo $quizCreator -> displayResults();
          $quizCreator -> uploadQuiz();
        } else if ( !isset($_POST["create_quiz"]) ) {
          echo $quizCreator -> drawControlPanel();
          if (isset($_POST["numb_of_questions"]) ) {
            echo $quizCreator -> drawQuestionPanel();
            $numbOfQuestions = $quizCreator -> getNumbOfQuestions();
            echo "
              <script>
                var numbOfQuestions = $numbOfQuestions;
              </script>
              <script src='js/quiz_creator_radios.js'></script>
            ";
          }
        } 
      ?>
    </main>
  </body>

</html>