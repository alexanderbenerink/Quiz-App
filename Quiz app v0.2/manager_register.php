<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<body>
	<!--Title -->
	<center>
		<p style="font-family: segoe ui; margin-top: 15%; font-size: 72px;">Register</p>
	</center>


	<!--Form -->
	<form class="signin-form" action="" method="post" style="text-align: center;">
		<input type="text" name="mail" placeholder="E-mail" required>
			<br>
		<input type="text" name="uid" placeholder="Username" required>
			<br>
		<input type="password" name="pwd" placeholder="Password" required>
			<br>
		<input type="password" name="" placeholder="Confirm password" required>
			<br>
		<p style="font-family: segoe ui; color: blue; font-size: 11px;"><a href="manager_login.php">Already have an account? Log in.</a></p>
		<button type="submit" name="submit">Register</button>
	</form>
</body>
</html>