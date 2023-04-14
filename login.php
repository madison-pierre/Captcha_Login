<?php
	//enabling errors
	error_reporting(E_ALL);
	ini_set("display errors",1);
	include("file_w_errors.php");
	
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
		$hash_password = md5($user_psswrd, false);
		// echo "$user_username $hash_password";

		//check that username and password are valid
		
		//log into DB
		
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$servername = "localhost";
		$username = "root";
		$password = "COSC4343";
		$db_name = "SiteDatabase";
		//make connection
		$conn = new mysqli($servername, $username, $password, $db_name);
		//echo $conn;
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			echo "BAD CONNECTION";
		}
		else {
			echo " Connected successfully ";
			mysqli_connect_error($conn);
			//see if the entered username and password match an entry in the DB
			//test query
			$test_q ="SELECT * FROM UserAccounts";
			$test_result = $conn->query($test_q);
			if (!$test_result) {
			echo " QUERY DID NOT FAIL SEE $test_result"; //it really doesn't like test result
			}
			else {
				echo "QUERY ISN'T WORKING $test_result";
			}
		}
		

		
		$result = "";
		$query = $conn->prepare("SELECT clearance FROM UserAccounts WHERE password=? AND username=?");
		$query->bind_param('ss',$hash_password,$user_username);
		$query->execute();
		$query->bind_result($result);
		// echo $query; We get to this statement then stop		
		echo " $result "; //result does not echo, is it because nothing is there?
		
		//if they are found, display the images on new html file, if not, display error
		if ($result->num_rows > 0) { //successful log in
			//get the user's clearance
			$clearance = $result;
			echo("<p>Redirecting...<p>");
			$conn->close();	
			header("Location:dashboard.php");	
		} 
		else {
			//this is the wrong username/password combo
			echo "<p>**You've entered the wrong username/password. Please try again**</p>";
			echo "<button action='index.php'> RETRY </button>";
			}
	  }
	else {
		echo "<p>Something went wrong, no POST detected</p>";
	}
	
	
	
	
?>