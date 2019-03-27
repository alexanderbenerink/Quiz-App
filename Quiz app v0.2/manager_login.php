<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<body>
	<center>
		<p style="font-family: segoe ui; margin-top: 15%; font-size: 72px;">Log in</p>
	</center>

	<form class="signin-form" action="" method="post" style="text-align: center;">
		<input type="text" name="uid" placeholder="Username" required>
			<br>
		<input type="text" name="pwd" placeholder="Password" required>
		<p style="font-family: segoe ui; color: blue; font-size: 11px;"><a href="manager_register.php">Don't have an account? Sign up.</a></p>
			<br>
		<button type="submit" name="submit">Log in</button>
	</form>
</body>
</html>