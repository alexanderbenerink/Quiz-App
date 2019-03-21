<?php

  class QuizCreator {

    private $numbOfQuestions;
    private $preferredQuestionType;
    private $preferredQuestionPoints;
    private $preferredQuestionTime;

    public function __construct() {
      // Number of questions
      $noq = isset($_POST["numb_of_questions"]) ? $_POST["numb_of_questions"] : 1;
      // Preferred question type
      $pqt = isset($_POST["preferred_question_type"]) ? $_POST["preferred_question_type"] : "multiple-choice";
      // Preferred questions points
      $pqp = isset($_POST["preferred_question_points"]) ? $_POST["preferred_question_points"] : 10;
      // Preferred questions time
      $pqti = isset($_POST["preferred_question_time"]) ? $_POST["preferred_question_time"] : 10;
      $this -> setNumbOfQuestions( $noq );
      $this -> setPreferredQuestionType( $pqt );
      $this -> setPreferredQuestionPoints( $pqp );
      $this -> setPreferredQuestionTime( $pqti );
    }

    public function collectResults() {
      $numbOfQuestions = $_POST["total_questions"];
      $results = array();
      for ( $i = 0; $i < $numbOfQuestions; $i++ ) {
        $number = $i + 1;
        $results[$i] = array( "id" => $number, "type" => $_POST["type-q$number"], "question" => "", "points" => $_POST["points-q$number"], "time" => $_POST["time-q$number"] );
        echo "
          <p>Question: " . $results[$i]['id'] . "<br> 
            Type: " . $results[$i]['type'] . " <br>
            Points: " . $results[$i]['points'] . " <br>
            Time: " . $results[$i]['time'] . " <br>
          </p> 
        ";
      }
    }

    // Geeft de HTML code terug voor het renderen van het controle paneel
    public function drawControlPanel() {
      $multipleChoice = $this -> checkPreferredQuestionType("multiple-choice", "selected");
      $trueFalse = $this -> checkPreferredQuestionType("true-false", "selected");
      $images = $this -> checkPreferredQuestionType("images", "selected");
      $connect = $this -> checkPreferredQuestionType("connect", "selected");
      return "
        <form action='' method='POST'>
          <fieldset>
            <legend>Control Panel</legend>
            <br>
            <label for='numb_of_questions'>Total questions:</label>
            <p>Min en max waardes moeten nog verzonnen worden.</p>
            <input type='number' min='1' max='100' id='numb_of_questions' name='numb_of_questions' value='$this->numbOfQuestions' required>
            <hr>
            <label for='preferred_question_type'>Preferred question type:</label>
            <br><br>
            <select id='preferred_question_type' name='preferred_question_type' required>
              <option value='multiple-choice' $multipleChoice>Multiple-choice</option>
              <option value='true-false' $trueFalse>True/ false</option>
              <option value='images' $images>Images</option>
              <option value='connect' $connect>Connect</option>
            </select>
            <hr>
            <label for='preferred_question_points'>Preferred question points: </label>
            <p>Min: 1 - Max: 10</p>
            <input type='number' min='1' max='10' id='preferred_question_points' name='preferred_question_points' value='$this->preferredQuestionPoints'>
            <hr>
            <label for='preferred_question_time'>Preferred question Time: </label>
            <p>Min: 10 - Max: 30</p>
            <input type='number' min='10' max='30' id='preferred_question_time' name='preferred_question_time' value='$this->preferredQuestionTime'>
            <hr>
            <input type='submit' value='Ok'>
          </fieldset>
        </form>
      ";
    }

    // Geeft de HTML code terug voor het renderen van het vragen paneel
    public function drawQuestionPanel() {
      $questionPanel = "
        <form action='' name='' method='POST'>
          <fieldset>
            <legend>Questions</legend>
      ";

      for ( $i = 0; $i < $this -> numbOfQuestions; $i++ ) {
        $questionNumber = $i + 1;
        $questionPanel .= "
          <fieldset style='border: 2px solid black'>
            <legend style='border: 2px solid blue'>Question " . $questionNumber . "</legend>
        ";

        $multipleChoice = $this -> checkPreferredQuestionType("multiple-choice", "checked");
        $trueFalse = $this -> checkPreferredQuestionType("true-false", "checked");
        $images = $this -> checkPreferredQuestionType("images", "checked");
        $connect = $this -> checkPreferredQuestionType("connect", "checked");

        $questionPanel .= $this -> drawQuestionType( $questionNumber, $multipleChoice, "$trueFalse", "$images", "$connect" );
        $questionPanel .= $this -> drawQuestionPoints( $this -> preferredQuestionPoints, $questionNumber );
        $questionPanel .= $this -> drawQuestionTime( $this -> preferredQuestionTime, $questionNumber );
        $questionPanel .= "</fieldset><br>";
      }
      
      $questionPanel .= "<input type='number' name='total_questions' value='$this->numbOfQuestions' hidden required>";
      $questionPanel .= "<input type='submit' name='create_quiz' value='Creëer quiz'></form>";
      return $questionPanel;
    }

    // Controleert of het type die binnenkomt gelijk staat aan de globale variabel preferredQuestionType
    // Return de string die binnenkomt wanneer true. Return een lege string wanneer false.
    public function checkPreferredQuestionType( $type, $returnValue ) {
      switch ( $type ) {
        case "multiple-choice":
        if ( $this -> preferredQuestionType == $type ) {
          return $returnValue;
        } else {
          return "";
        }
        break;
        case "true-false":
        if ( $this -> preferredQuestionType == $type ) {
          return $returnValue;
        } else {
          return "";
        }
        break;
        case "images":
        if ( $this -> preferredQuestionType == $type ) {
          return $returnValue;
        } else {
          return "";
        }
        break;
        case "connect":
        if ( $this -> preferredQuestionType == $type ) {
          return $returnValue;
        } else {
          return "";
        }
        break;
      }
    }

    // Geeft de HTML code terug voor het renderen van de input fields van het type vraag
    public function drawQuestionType( $questionNumber, $multipleChoice, $trueFalse, $images, $connect ) {
      return "
        <fieldset>
          <legend>Type</legend>
          <input type='radio' name='type-q$questionNumber' id='multiple-choice-q$questionNumber' value='multiple-choice' $multipleChoice required></input>
          <label for='multiple-choice-q$questionNumber'>Multiple-choice</label>
          <input type='radio' name='type-q$questionNumber' id='true-false-q$questionNumber' value='true/false' $trueFalse required></input>
          <label for='true-false-q$questionNumber'>True/ false</label>
          <input type='radio' name='type-q$questionNumber' id='images-q$questionNumber' value='images' $images required></input>
          <label for='images-q$questionNumber'>Images</label>
          <input type='radio' name='type-q$questionNumber' id='connect-q$questionNumber' value='connect' $connect required></input>
          <label for='connect-q$questionNumber'>Connect</label>
        </fieldset>
      ";
    }

    // Geeft de HTML code terug voor het renderen van het input field voor het aantal punten per vraag
    public function drawQuestionPoints( $questionPoints, $questionNumber ) {
      return "
        <fieldset>
          <legend>Points</legend>
          <input type='number' min='1' max='10' value='$questionPoints' name='points-q$questionNumber' required>
        </fieldset>
      ";
    }

    // Geeft de HTML code terug voor het renderen van het input field voor het aantal tijd per vraag
    public function drawQuestionTime( $questionTime, $questionNumber ) {
      return "
        <fieldset>
          <legend>Time</legend>
          <input type='number' min='10' max='30' value='$questionTime' name='time-q$questionNumber' required>
        </fieldset>
      ";
    }

    // Setter voor numbOfQuestions
    public function setNumbOfQuestions( $numb ) {
      $this -> numbOfQuestions = $numb;
    }

    // Setter voor preferredQuestionType
    public function setPreferredQuestionType( $type ) {
      $this -> preferredQuestionType = $type;
    }

    // Setter voor preferredQuestionPoints
    public function setPreferredQuestionPoints( $points ) {
      $this -> preferredQuestionPoints = $points;
    }

    // Setter voor preferredQuestionTime
    public function setPreferredQuestionTime( $time ) {
      $this -> preferredQuestionTime = $time;
    }

  }