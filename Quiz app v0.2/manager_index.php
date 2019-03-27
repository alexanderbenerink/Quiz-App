<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<?php
include 'includes\header-inc.php';
?>
</head>
<body>
	<form class="signin-form" action="" method="post" style="text-align: center; margin-top: 15%">
		<button formaction="manager_create_quiz.php" type="submit" name="createQuiz">Create quiz</button>
			<br>
		<button formaction="manage_quiz.php" type="submit" name="manageQuiz">Manage quiz</button>
	</form>

</body>
</html>