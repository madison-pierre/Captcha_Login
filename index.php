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
	<!--Captcha section -->
	<label>Please do the captcha to prove you're not a bot:</label>
	<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
	<input type="text" name="captcha_code" size="10" maxlength="6" />
	<a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + 
	Math.random(); return false">[ Different Image ]</a>
	<?php
		//setting up errors
		ini_set("display_errors", "1");
		ini_set("display_startup_errors", "1");
		error_reporting(E_ALL);
	  ?> 
	<input type="submit" value="Sign In" />
	
	</form>
	</body>
</html>