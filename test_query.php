<?php
	//enabling errors
	error_reporting(E_ALL);
	ini_set("display errors",1);
	include("file_w_errors.php");
	
	$servername = "localhost";
		$username = "root";
		$password = "COSC4343";
		$db_name = "SiteDatabase";
		
	$conn = new mysqli($servername, $username, $password, $db_name);
		//echo $conn;
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			echo "BAD CONNECTION";
		}
		else {
			echo " Connected successfully ";
		}
		$test_q ="SELECT * FROM UserAccounts";
		$test_result = $conn->query($test_q);
		if (!$test_result) {
			echo " QUERY DID NOT FAIL SEE $test_result "; //it really doesn't like test result
		}
		else {
				echo " QUERY ISN'T WORKING CANNOT PRINT TEST RESULT ";
		}
?>