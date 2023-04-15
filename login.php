<html lang="en">
<head>
<link rel="stylesheet" href="hw5.css">
</head>
<?php

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
	echo "<button value='Retry' action=""/>";
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
	echo $user_clearance;
/*	
	//now we display the images
	//create a list of them
	$images = array($img1=imagecreatefrompng("photos/TopSecret.png"),
		$img2=imagecreatefrompng("photos/Secret.png"),
		$img3=imagecreatefrompng("photos/Confidential.png"),
		$img4=imagecreatefrompng("photos/Unclassified.png"));
		
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
		
    */

	}
}
?>

</html>