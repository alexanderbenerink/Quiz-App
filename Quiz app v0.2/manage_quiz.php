<!DOCTYPE html>
<head>
	<title>Manage quiz</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<?php
		include 'includes\header-inc.php';
	?>
</head>
<body>
	<div class="managequiz_container">
    	<h1 style="text-align: center;">Manage Quiz</h1>
    	<br>
    	<center><input type="text" name="searchQuiz" placeholder="&#xf002; Search"></center>
    	<br>
			<table class="signin-form" style="width:100%;">
  			<tr>
    			<td><button type="submit">Quiz 1</button></td>
    			<td><button type="submit">Quiz 4</button></td>
				<td><button type="submit">Quiz 7</button></td>
			</tr>
			<tr>
				<td><button type="submit">Quiz 2</button></td>
				<td><button type="submit">Quiz 5</button></td>
				<td><button type="submit">Quiz 8</button></td>
			</tr>
			<tr>
				<td><button type="submit">Quiz 3</button></td>
				<td><button type="submit">Quiz 6</button></td>
				<td><button type="submit">Quiz 9</button></td>
			</tr>
		</table>
	</div>
</body>
</html>