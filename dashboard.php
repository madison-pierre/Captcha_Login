<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="hw5.css">
</head>

	<body>
	<div>
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//first check that captcha passes
		// LOAD CAPTCHA 
		require "hw5_captcha.php";
 
		/* // (B) Verify if its corrext or not
		if ($PHPCAP->verify($_POST["captcha"])) {
		  $result = "Congrats, CAPTCHA is correct.";
		  print_r($_POST);
		}
		else { echo "CAPTCHA does not match!"; }
		*/
		// then do other login stuff
		$user_username = $_POST["username"];
		$user_psswrd = $_POST["psswrd"];
		// hash password with md5
		$hash_password = md5($psswrd, false);
		
		//check that username and password are valid
		
		//log into DB
		$servername = "localhost";
		$username = "root";
		$password = "COSC4343";
		//make connection
		$conn = new mysqli($servername, $username, $password, 'SiteDatabase');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			echo "BAD CONNECTION";
		else {
			echo "Connected successfully";
		}
		
		
		//see if the entered username and password match an entry in the DB
		$query = "SELECT username,password FROM UserAccounts 
					WHERE username=$user_username AND 
					password=$hash_password";
		$result = $conn->query($query);
		
		//if they are found, display the images on new html file, if not, display error
		if ($result->num_rows > 0)
		{ //successful log in
	
			//get the user's clearance
			$clearance_q = "SELECT clearance FROM UserAccounts WHERE username=$user_username";
			$user_clearance = $conn->query($clearance_q);
			$images = array(imagecreatefrompng("photos\TopSecret.png"),
		imagecreatefrompng("photos\Secret.png"),
		imagecreatefrompng("photos\Confidential.png"),
		imagecreatefrompng("photos\Unclassified.png"));
		
		// we need the clearance from the user that logged in
		function displayImages($clearance) {
			
			if ($clearance == "T") {
				$clearance_index = 3;
			}
			elseif ($clearance == "S") {
				$clearance_index = 2;
			}
			elseif ($clearance == "C") {
				$clearance_index = 1;
			}
			else {
				$clearance_index = 0;
			}
			// this loop should display all the images the user is allowed to see
			for($x=0; $x<$clearance_index; $x++)
			{
				echo "<img src=$images[$x]>";
			}
		}
		displayImages($user_clearance);
		echo "<br><button onclick='index.php'>Log Out</button>";
			
		}
		else {
			//this is the wrong username/password combo
			echo "<p>**You've entered the wrong username/password. Please try again**</p>";
			echo "<button onclick="window.location.href='index.php'" > RETRY </button>";
			}
		$conn->close();
		}
	
	}
	else {
		echo "<p>Something went wrong, no POST detected</p>";
	}
		
	
	?>
		</div>
		

	</body>

</html>