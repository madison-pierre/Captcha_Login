<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
		$conn = new mysqli($servername, $username, $password);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		echo "Connected successfully";
		
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
			$clearance = $conn->query($clearance_q);
			header("Location:dashboard.html");
		}
		else {
			//this is the wrong username/password combo
			echo "<p>**You've entered the wrong username/password. Please try again**</p>";
			
		}
		$conn->close();
	}
	
	
	
	
?>