<html lang="en">
<head>
<link rel="stylesheet" href="hw5.css">
</head>


	<body>
	<form action="login.php" method="post">
	<label for="username" > Username :</label>
	<input type="text" name="username" required />
	<br>
	<label for="psswrd">Password :</label>
	<input type="password" name="psswrd" required />
	<!-- <label>Please do the captcha to prove you're not a bot:</label>
	<?php
	session_start();
	/*
	  require "hw5_captcha.php";
	  $PHPCAP->prime();
	  $PHPCAP->draw(); */
	  ?> 
  <input name="captcha" type="text" required /> !-->
	<input type="submit" value="Sign In" />
	
	</form>
	</body>
</html>