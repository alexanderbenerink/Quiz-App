<?php
  require_once "../Classes//QuizCreator.php";

  $object = new QuizCreator();
  switch ( $_REQUEST["questionType"] ) {
    case "multiple-choice";
      echo $object -> drawMultipleChoiceFieldset( $_REQUEST["questionNumber"] );
      break;

    case "true/false";
      echo $object -> drawTrueFalseFieldset( $_REQUEST["questionNumber"] );
      break;

    case "images";
      echo $object -> drawImagesFieldset( $_REQUEST["questionNumber"], $object -> getImagesAmount() );
      break;

    case "connect";
      echo $object -> drawConnectFieldset( $_REQUEST["questionNumber"], $object -> getConnectAmount() );
      break;
  }
  