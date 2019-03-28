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

    // Geeft de HTML code terug voor het renderen van het controle paneel
    public function drawControlPanel() {
      $multipleChoice = $this -> assignSelected("multiple-choice", "selected");
      $trueFalse = $this -> assignSelected("true-false", "selected");
      $images = $this -> assignSelected("images", "selected");
      $connect = $this -> assignSelected("connect", "selected");
      return "
        <form action='' method='POST'>
          <fieldset style='border: 2px solid green'>
            <legend>Control Panel</legend>
            <br> 
            <label for='numb_of_questions'>Total questions:</label>
            <p>Min en max waardes moeten nog verzonnen worden.<br> Min: 1 - Max: 100</p>
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
      <form name='questions' action='' method='POST'>
        <fieldset style='border: 2px solid green'>
          <legend>Quiz</legend>
          <fieldset style='border: 2px solid black'>
            <legend style='border: 2px solid blue'>Name</legend>
            <input type='text' name='quiz_name' required>
          </fieldset>
          <br>
          <fieldset style='border: 2px solid black'>
            <legend style='border: 2px solid blue'>Description</legend>
            <input type='text' name='quiz_description' required>
          </fieldset>
          <br>
      ";

      for ( $i = 0; $i < $this -> numbOfQuestions; $i++ ) {
        $questionNumber = $i + 1;
        $questionPanel .= "
          <fieldset style='border: 2px solid black'>
            <legend style='border: 2px solid blue'>Question " . $questionNumber . "</legend>
        ";
        $questionPanel .= $this -> drawQuestionType( $questionNumber );
        $questionPanel .= "<div id='fieldset-wrapper-q$questionNumber'>";
        switch ( $this -> preferredQuestionType ) {
          case "multiple-choice";
            $questionPanel .= $this -> drawMultipleChoiceFieldset( $questionNumber );
             break;
          case "true-false";
            $questionPanel .= $this -> drawTrueFalseFieldset( $questionNumber );
            break;
          case "images";
            $questionPanel .= $this -> drawImagesFieldset( $questionNumber );
            break;
          case "connect";
            $questionPanel .= $this -> drawConnectFieldset( $questionNumber );
            break;
        }
        $questionPanel .= "</div>";
        $questionPanel .= $this -> drawQuestionPoints( $this -> preferredQuestionPoints, $questionNumber );
        $questionPanel .= $this -> drawQuestionTime( $this -> preferredQuestionTime, $questionNumber );
        $questionPanel .= "</fieldset><br>";
      }

      $questionPanel .= "<input type='number' name='total_questions' value='$this->numbOfQuestions' hidden required>";
      $questionPanel .= "<input type='submit' name='create_quiz' value='Creëer quiz'></form>";
      return $questionPanel;
    }

    // Geeft de HTML code terug voor het renderen van de input fields van het type vraag
    public function drawQuestionType( $questionNumber ) {
      $multipleChoice = $this -> assignSelected("multiple-choice", "checked");
      $trueFalse = $this -> assignSelected("true-false", "checked");
      $images = $this -> assignSelected("images", "checked");
      $connect = $this -> assignSelected("connect", "checked");
      return "
        <fieldset>
          <legend>Type</legend>
          <input type='radio' name='type-q$questionNumber' id='multiple-choice-radio-$questionNumber' value='multiple-choice' $multipleChoice required></input>
          <label for='multiple-choice-q$questionNumber'>Multiple-choice</label>
          <input type='radio' name='type-q$questionNumber' id='true-false-radio-$questionNumber' value='true/false' $trueFalse required></input>
          <label for='true-false-q$questionNumber'>True/ false</label>
          <input type='radio' name='type-q$questionNumber' id='images-radio-$questionNumber' value='images' $images required></input>
          <label for='images-q$questionNumber'>Images</label>
          <input type='radio' name='type-q$questionNumber' id='connect-radio-$questionNumber' value='connect' $connect required></input>
          <label for='connect-q$questionNumber'>Connect</label>
        </fieldset>
      ";
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de multiple-choice vragen 
    public function drawMultipleChoiceFieldset( $questionNumber ) {
      return "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='multiple-choice_q-$questionNumber' required>
          <fieldset>
            <legend>Answers</legend>
            <fieldset>
              <legend>Correct</legend>
              <input type='text' name='multiple-choice_correct-$questionNumber' required>
            </fieldset>
            <fieldset>
              <legend>Incorrect</legend>
              <input type='text' name='multiple-choice_incorrect-$questionNumber-1' required>
              <input type='text' name='multiple-choice_incorrect-$questionNumber-2' required>
              <input type='text' name='multiple-choice_incorrect-$questionNumber-3' required>
            </fieldset>
          </fieldset>
        </fieldset>
      ";
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de true-false vragen
    public function drawTrueFalseFieldset( $questionNumber ) {
      return "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='true-false_q-$questionNumber' required>
          <fieldset>
            <legend>Answers</legend>
            <select name='true-false_select-$questionNumber'>
              <option value='true'>True</option>
              <option value='false'>False</option>
            </select>
          </fieldset>
        </fieldset>
      ";
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de images vragen
    public function drawImagesFieldset( $questionNumber ) {
      return "
        <fieldset>
          <legend>Images</legend>
        </fieldset>
      ";
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de connect vragen
    public function drawConnectFieldset( $questionNumber ) {
      return "
        <fieldset>
          <legend>Connect</legend>
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

    // Controleert of het type die binnen komt gelijk staat aan die van preferredQuestionType.
    // True: return de value die binnen is gekomen. False: return
    public function assignSelected( $type, $returnValue ) {
      if ( $this -> preferredQuestionType == $type ) {
        return $returnValue;
      }
      return;
    }

    // Verzamelt resultaten van het quiz formulier
    public function collectResults() {
      $numbOfQuestions = $_POST["total_questions"];
      $results = $this -> getQuizAttributes( $numbOfQuestions );
      for ( $i = 0; $i < $numbOfQuestions; $i++ ) {
        $number = $i + 1;
        switch ( $_POST["type-q$number"] ) {
          case "multiple-choice";
            $question = $_POST["multiple-choice_q-$number"];
            $questions[$i] = $this -> getQuestionAttributes( $number, $question );
            $answers[$i] = $this -> getMultipleChoiceAnswers( $number );
            break;
          case "true/false";
            $question = $_POST["true-false_q-$number"];
            $questions[$i] = $this -> getQuestionAttributes( $number, $question );
            $answers[$i] = $this -> getTrueFalseAnswer( $number );
            break;
          case "images";
            $question = "";
            $questions[$i] = $this -> getQuestionAttributes( $number, $question );
            break;
          case "connect";
            $question = "";
            $questions[$i] = $this -> getQuestionAttributes( $number,  $question );
            break;
        }
      };
    }
    
    // Geeft een array terug met de attributen van de Quiz
    public function getQuizAttributes( $numbOfQuestions ) {
      return array( "name" => $_POST["quiz_name"], "description" => $_POST["quiz_description"], "question_count" => $numbOfQuestions );
    }

    // Geeft een array terug met de attributen van de vragen van de quiz
    public function getQuestionAttributes( $number, $question ) {
      return array( "number" => $number, "type" => $_POST["type-q$number"], "question" => $question, "points" => $_POST["points-q$number"], "time" => $_POST["time-q$number"]  );
    }

    // Geeft een array terug met de attributen van een multiple-choice vraag
    public function getMultipleChoiceAnswers( $number ) {
      return array( "correct" => $_POST["multiple-choice_correct-$number"], "incorrect-1" => $_POST["multiple-choice_incorrect-$number-1"], 
        "incorrect-2" => $_POST["multiple-choice_incorrect-$number-2"], "incorrect-3" => $_POST["multiple-choice_incorrect-$number-3"] );
    }

    // Geeft een array terug met de attributen van een true of false vraag
    public function getTrueFalseAnswer( $number ) {
      return array( "answer" => $_POST["true-false_select-$number"] );
    }

    // Setter voor quizName;
    public function setQuizName( $name ) {
      $this -> quizName = $name;
    }

    // Setter voor numbOfQuestions
    public function setNumbOfQuestions( $numb ) {
      $this -> numbOfQuestions = $numb;
    }

    // Getter voor numbOfQuestions
    public function getNumbOfQuestions() {
      return $this -> numbOfQuestions;
    }

    // Setter voor preferredQuestionType
    public function setPreferredQuestionType( $type ) {
      $this -> preferredQuestionType = $type;
    }

    // Getter voor preferredQuestionType
    public function getPreferredQuestionType() {
      return $this -> preferredQuestionType;
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