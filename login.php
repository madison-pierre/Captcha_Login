
	<?php

	session_start();

	// CHECK CAPTCHA BEFORE ANYTHING ELSE
	include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
	$securimage = new Securimage(); //create new secure image
	if ($securimage->check($_POST['captcha_code']) == false) {
	echo "The security code entered was incorrect.<br /><br />";
	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	exit;
	}
	
	//starting connection
	$servername = "localhost";
	$username = "accessor";
	$password = "phpIsNoFun";
	$db_name = "SiteDatabase";
	$conn = new mysqli($servername, $username, $password, $db_name);

	//enabling errors
	// ini_set("display_errors", "1");
	// ini_set("display_startup_errors", "1");
	// error_reporting(E_ALL);
	//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
		//echo "<button value='Retry' action=""/>";
		}
		else {
		$two_strings = "ss";
		$stmt->bind_param($two_strings, $username, $hash_password);
		//var_dump($stmt);
		$stmt->execute();
		$result = $stmt->get_result();
		//if bad login
		if ($result->num_rows == 0)
		{
			echo " You entered an incorrect username/password ";
			echo "<button action='redirect'>RETRY </button>";
		}
		else {
		//fetching the associated account
		$account = $result->fetch_assoc();
		//getting the clearance
		$user_clearance = $account["clearance"];
		//echo "GOT THE CLEARANCE";
		
		
		//now we display the images
		//create a list of them
		$images = array("photos/Unclassified.png","photos/Confidential.png","photos/Secret.png","photos/TopSecret.png");
			
			
			// run this function to see what displays
			function displayImages($clearance, $images) {
				
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
					$pic = $images[$x];
					printf("<img src='$pic' alt='$clearance_index' width='500' height='500'/>");
				}
			}
		
			displayImages($user_clearance, $images);
			$conn->close();
			printf("<button onclick='index.php'>Log Out</button>");
		}

	}
}
?>