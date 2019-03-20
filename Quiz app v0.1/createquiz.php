<html>

  <head>
    <title>Create Quiz</title>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>
    <?php

    include 'includes\header-inc.php';
      if ( isset($_GET["numb_of_questions"]) ) {
        $numb_of_questions = $_GET["numb_of_questions"];
        $preferred_question_type = $_GET["preferred_question_type"];
        $preferred_question_points = $_GET["numb_of_points"];
        $preferred_question_time = $_GET["question_time"];
      } else {
        $numb_of_questions = 1;
        $preferred_question_points = 1;
        $preferred_question_time = 20;
      }
    ?>
    <h1 style="text-align: center;">Create Quiz</h1>
    <div class="questiontype">
    <form name="test" action="createquiz.php" method="_GET"> 
      <fieldset class="outside_fieldset">
        <legend>Total questions</legend>
        <input type="number" id="" min="1" name="numb_of_questions" value="<?php echo $numb_of_questions ?>">
        <br><br>
        <label for="">Preferred question type</label>
        <br>
        <select name="preferred_question_type">
          <option value="multiplechoice">Multiplechoice</option>
          <option value="true/false">True/ false</option>
          <option value="images">Images</option>
          <option value="connect">Connect</option>
        </select>
        <br><br>
        <label for="">Preferred question points (Range: 1-10)</label>
        <br>
        <input type="number" id="" min="1" max="10" name="numb_of_points" value="<?php echo $preferred_question_points ?>">
        <br><br>
        <label for="">Preferred question time (Range: 10-x in seconds)</label>
        <br>
        <input type="number" id="" min="10" name="question_time" value="<?php echo $preferred_question_time ?>">
        <br><br>
        <button type="submit" name="button">Create</button>
      </fieldset>
    </form>
  </div>

    <form>
      <?php
        echo "
          <fieldset>
            <legend>Questions:</legend>
        ";
        for ( $i = 0; $i < $numb_of_questions; $i++ ) {
         $question_number = $i + 1;
         $input_name = 'question' . $question_number;
          echo "
            <fieldset class='outside_fieldset'>
              <legend><strong>Question " . $question_number . "</strong></legend>
              <fieldset>
                <legend>Type</legend>
                <input type='radio' name='$input_name' checked></input>
                <label for=''>Multiplechoice</label>
                <br>
                <input type='radio' name='$input_name'></input>
                <label for=''>True/ false</label>
                <br>
                <input type='radio' name='$input_name'></input>
                <label for=''>Images</label>
                <br>
                <input type='radio' name='$input_name'></input>
                <label for=''>Connect</label>
              </fieldset>
              <fieldset>
                <legend>Answers</legend>
                <fieldset>
                  <legend>Correct</legend>
                  <input type='text'>
                </fieldset>
                <fieldset>
                  <legend>Incorrect</legend>
                  <input type='text'>
                  <input type='text'>
                  <input type='text'>
                </fieldset>
              </fieldset>
              <fieldset>
                <legend>Time</legend>
                <input type='number' min='10' value='$preferred_question_time'>
              </fieldset>
              <fieldset>
                <legend>Points</legend>
                <input type='number' min='1' max='10' value='$preferred_question_points'>
              </fieldset>
            </fieldset>
            <br>
            <hr>
            <br>
          ";
        }
        echo "</fieldset>";
      ?>
    </form>
  </body>

</html>