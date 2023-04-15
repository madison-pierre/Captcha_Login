<html lang="en">
<head>
<link rel="stylesheet" href="hw5.css">
</head>

	<body>
	<div>
		<?php
		
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
			
		
		
	
		
	
	?>
		</div>
		

	</body>

</html>