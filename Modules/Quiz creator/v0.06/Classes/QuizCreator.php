<?php

  class QuizCreator {
    
    private $numbOfQuestions;
    private $preferredQuestionType;
    private $preferredQuestionPoints;
    private $preferredQuestionTime;
    private $imageAmount;
    private $connectAmount;
    private $quiz;
    private $questions;
    private $answers;

    public function __construct() {
      $this -> numbOfQuestions = isset($_POST["numb_of_questions"]) ? $_POST["numb_of_questions"] : 1;
      $this -> preferredQuestionType = isset($_POST["preferred_question_type"]) ? $_POST["preferred_question_type"] : "multiple-choice";
      $this -> preferredQuestionPoints = isset($_POST["preferred_question_points"]) ? $_POST["preferred_question_points"] : 10;
      $this -> preferredQuestionTime = isset($_POST["preferred_question_time"]) ? $_POST["preferred_question_time"] : 10;
      $this -> imageAmount = 3;
      $this -> connectAmount = 3;
    }

    // Geeft de HTML code terug voor het renderen van het controle paneel
    public function drawControlPanel() {
      $multipleChoice = $this -> assignSelected("multiple-choice", "selected");
      $trueFalse = $this -> assignSelected("true-false", "selected");
      $images = $this -> assignSelected("images", "selected");
      $connect = $this -> assignSelected("connect", "selected");
      return "
        <section>
          <h2>Control Panel</h2>
          <form method='POST'>
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
        </section>
      ";
    }

    // Geeft de HTML code terug voor het renderen van het vragen paneel
    public function drawQuestionPanel() {
      $questionPanel = "
      <section>
        <h2>Quiz</h2>
        <form name='questions' method='POST'>
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
            $questionPanel .= $this -> drawImagesFieldset( $questionNumber, $this -> imageAmount );
            break;
          case "connect";
            $questionPanel .= $this -> drawConnectFieldset( $questionNumber, $this -> connectAmount );
            break;
        }
        $questionPanel .= "</div>";
        $questionPanel .= $this -> drawQuestionPoints( $this -> preferredQuestionPoints, $questionNumber );
        $questionPanel .= $this -> drawQuestionTime( $this -> preferredQuestionTime, $questionNumber );
        $questionPanel .= "</fieldset><br>";
      }

      $questionPanel .= "<input type='number' name='total_questions' value='$this->numbOfQuestions' hidden required>";
      $questionPanel .= "<input type='submit' name='create_quiz' value='Creëer quiz'></form></section>";
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
      $fieldset = "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='question-$questionNumber' required>
          <fieldset>
            <legend>Answers</legend>
            <fieldset>
              <legend>Correct</legend>
              <input type='text' name='multiple-choice_correct-$questionNumber' required>
            </fieldset>
            <fieldset>
              <legend>Incorrect</legend>
      ";
      for ( $i = 0; $i < 3; $i++ ) {
        $number = $i + 1;
        $fieldset .= "
          <input type='text' name='multiple-choice_incorrect-$questionNumber-$number' required>
        ";
      }
      $fieldset .= "
            </fieldset>
          </fieldset>
        </fieldset>
      ";
      return $fieldset;
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de true-false vragen
    public function drawTrueFalseFieldset( $questionNumber ) {
      return "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='question-$questionNumber' required>
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
    public function drawImagesFieldset( $questionNumber, $inputAmount ) {
      $fieldset = "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='question-$questionNumber' required>
          <fieldset>
            <legend>Sets</legend>
      ";
      for ( $i = 0; $i < $inputAmount; $i++ ) {
        $number = $i + 1;
        $fieldset .= "
          <fieldset>
            <legend>Set $number</legend>
            <input type='file' name='image-$questionNumber-$number'>
            <input type='text' name='image-ans-$questionNumber-$number' required>
          </fieldset>
        ";	
      }
      $fieldset .= "
          </fieldset>
        </fieldset>
      ";
      return $fieldset;
    }

    // Geeft de HTML terug voor het renderen van de fieldset voor de connect vragen
    public function drawConnectFieldset( $questionNumber, $inputAmount ) {
      $fieldset = "
        <fieldset>
          <legend>Question</legend>
          <input type='text' name='question-$questionNumber' required>
          <fieldset>
            <legend>Sets</legend>
      ";
      for ( $i = 0; $i < $inputAmount; $i++ ) {
        $number = $i + 1;
        $fieldset .= "
          <fieldset>
            <legend>Set $number</legend>
            <input type='text' name='connect_set-$questionNumber-$number-1' required>
            <input type='text' name='connect_set-$questionNumber-$number-2' required>
          </fieldset>
        ";
      }
      $fieldset .= "
          </fieldset>
        </fieldset>
      ";
      return $fieldset;
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
      $this -> quiz = $this -> getQuizAttributes( $numbOfQuestions );
      for ( $i = 0; $i < $numbOfQuestions; $i++ ) {
        $number = $i + 1;
        $this -> questions[$i] = $this -> getQuestionAttributes( $number );
        switch ( $_POST["type-q$number"] ) {
          case "multiple-choice";
            $this -> answers[$i] = $this -> getMultipleChoiceAnswers( $number );
            break;
          case "true/false";
            $this -> answers[$i] = $this -> getTrueFalseAnswer( $number );
            break;
          case "images";
            break;
          case "connect";
            break;
        }
      }
      /* Vanaf hier zijn alle resultaten verzameld
        $quiz is een associative array met betrekking tot de quiz en bevat de volgende waardes:
          * Naam
          * Descriptie
          * Aantal vragen

         $questions is een associative array met betrekking tot de quiz vragen en bevat de volgende waardes:
          * Quiz vraag nummer
          * Vraag type
          * Vraag punten
          * Vraag tijd
        
        $answers is een associative array met betrekking tot de quiz vraag antwoorden en bevat de volgende waardes:
          * Antwoorden van multiple-choice vragen
            - correct, incorrect-1, incorrect-2, incorrect-3
          * Antwoorden van true/ false vragen
            - True of False
      */
    }

    // Geeft de HTML code terug voor het renderen van de resultaten van de aangemaakte quiz
    public function displayResults() {
      $name = $this -> quiz['name'];
      $description = $this -> quiz['description'];
      $questionCount = $this -> quiz['question_count'];
      $results = "
        <div>
          <h2>Quiz summary</h2>
          <p>
            Name: $name <br>
            Description: $description <br>
            Question Count: $questionCount <br>
          </p>
      ";

      for ( $i = 0; $i < count($this -> questions); $i++ ) {
        $number = $i + 1;
        $question = $this -> questions[$i]["question"];
        $type = $this -> questions[$i]["type"];
        $points = $this -> questions[$i]["points"];
        $time = $this -> questions[$i]["time"];
        $results .= "
          <p>
            Question $number: $question<br>
            Type: $type <br>
        ";
        switch ( $type ) {
          case "multiple-choice";
          $correct = $this -> answers[$i]["correct"];
          break;
          case "true/false";
          $correct = $this -> answers[$i]["answer"];
          break;
        }
        $results .= "
            Correct answer: $correct <br>
            Points: $points <br>
            Time: $time <br>
          </p>
        ";
      }

      $results .= "
        </div>
      ";
      return ($results);
    }
    
    // Geeft een array terug met de attributen van de Quiz
    public function getQuizAttributes( $numbOfQuestions ) {
      return array( "name" => $_POST["quiz_name"], "description" => $_POST["quiz_description"], "question_count" => $numbOfQuestions );
    }

    // Geeft een array terug met de attributen van de vragen van de quiz
    public function getQuestionAttributes( $number ) {
      return array( "number" => $number, "type" => $_POST["type-q$number"], "question" => $_POST["question-$number"], "points" => $_POST["points-q$number"], "time" => $_POST["time-q$number"]  );
    }

    // Geeft een array terug met de antwoorden van een multiple-choice vraag
    public function getMultipleChoiceAnswers( $number ) {
      return array( "correct" => $_POST["multiple-choice_correct-$number"], "incorrect-1" => $_POST["multiple-choice_incorrect-$number-1"], 
        "incorrect-2" => $_POST["multiple-choice_incorrect-$number-2"], "incorrect-3" => $_POST["multiple-choice_incorrect-$number-3"] );
    }

    // Geeft een array terug met de antwoorden van een true of false vraag
    public function getTrueFalseAnswer( $number ) {
      return array( "answer" => $_POST["true-false_select-$number"] );
    }

    // Geeft een array terug met de antwoorden van een connect vraag
    public function getConnectAnswers( $number ) {
      return array(  );
    }

    // Getter voor numbOfQuestions
    public function getNumbOfQuestions() {
      return $this -> numbOfQuestions;
    }

    // Getter voor preferredQuestionType
    public function getPreferredQuestionType() {
      return $this -> preferredQuestionType;
    }

    // Getter voor imageAmount;
    public function getImagesAmount() {
      return $this -> imageAmount;
    }

    // Getter voor connectAmount;
    public function getConnectAmount() {
      return $this -> connectAmount;
    }

  }