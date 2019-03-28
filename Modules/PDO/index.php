<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php

			require_once 'config.php';

		 ?>
	</head>
	<body>

		<?php 
		/*
			$DB = new db();
			
			$question_string1 = "default question1";
			$quiz_id1 = 2;
			$answer_string1 = "default answer1";
			$question_type1 = 1;

			$question_string2 = "default question2";
			$quiz_id2 = 2;
			$answer_string2 = "default answer2";
			$question_type2 = 1;
			$questionWrongAnswer21 = "default wrong answer1";
			$questionWrongAnswer22 = "default wrong answer2";
			$questionWrongAnswer23 = "default wrong answer3";

			$questionArray1 = array($question_string1, $quiz_id1, $answer_string1, $question_type1);

			$questionArray2 = array($question_string2, $quiz_id2, $answer_string2, $questionWrongAnswer21, $questionWrongAnswer22, $questionWrongAnswer23, $question_type2);

			$questionsArray = array($questionArray1,$questionArray2);

			$question1 = new question();

			$question1->createQuestion($questionsArray);
			
			$userArray = array("Name" => "default", "Email" => "default@default.nl", "Password" => "default");

			$user1 = new user();

			$user1->createUser($userArray);
			*/

			$Quiz = new quiz();

			//$quizArray = Array("Name","123456789000","Desciption",2);

			//$Quiz->createQuiz($quizArray);

			//$Quiz->getQuizByNameAndUser(1 ,2);\

			$Quiz->getAllQuiz();

		?>

	</body>
</html>