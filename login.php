<html lang="en">
<head>
<link rel="stylesheet" href="hw5.css">
</head>
<?php
/*
	//enabling errors
	error_reporting(E_ALL);
	ini_set("display errors",1);
	include("file_w_errors.php");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//first check that captcha passes
		// LOAD CAPTCHA 
		require "hw5_captcha.php";
 
		// (B) Verify if its corrext or not
		if ($PHPCAP->verify($_POST["captcha"])) {
		  $result = "Congrats, CAPTCHA is correct.";
		  print_r($_POST);
		}
		else { echo "CAPTCHA does not match!"; }
		
		// then do other login stuff
		$user_username = $_POST["username"];
		$user_psswrd = $_POST["psswrd"];
		// hash password with md5
		$hash_password = md5($user_psswrd, false);
		// echo "$user_username $hash_password";

		//check that username and password are valid
		
		//log into DB
		
		
		$servername = "localhost";
		$username = "accessor";
		$password = "phpIsNoFun";
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
			echo " QUERY DID NOT FAIL SEE $test_result "; //it really doesn't like test result
			}
			else {
				echo " QUERY ISN'T WORKING CANNOT PRINT TEST RESULT ";
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
	
	
*/

session_start();

//starting connection
$servername = "localhost";
$username = "accessor";
$password = "phpIsNoFun";
$db_name = "SiteDatabase";
$conn = new mysqli($servername, $username, $password, $db_name);

//enabling errors
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//get form data
$username = $_POST['username'];
$hash_password = md5($_POST['psswrd']);
$query = "";
$result = "";


if(isset($_POST['username']))
{	//query database
    $query = "SELECT * FROM UserAccounts WHERE username=? AND password=?"; 
    $stmt = $conn->prepare($query);
	if(!$stmt)
	{
	echo " You entered an incorrect username/password ";
	echo "<button value='Retry' />";
	}
	else {
	$two_strings = "ss";
	$stmt->bind_param($two_strings, $username, $hash_password);
    var_dump($stmt);
    $stmt->execute();
    $result = $stmt->get_result();
	//fetching the associated account
    $account = $result->fetch_assoc();
	//getting the clearance
	$user_clearance = $account["clearance"];
	
	//now we display the images
	//create a list of them
	$images = array(imagecreatefrompng("..\photos\TopSecret.png"),
		imagecreatefrompng("..\photos\Secret.png"),
		imagecreatefrompng("..\photos\Confidential.png"),
		imagecreatefrompng("..\photos\Unclassified.png"));
		
		// run this function to see what displays
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
		
    

	}
}
?>

</html>