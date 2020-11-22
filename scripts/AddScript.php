<?php
require '../userHeader.php';

function Redirect(){
	header("Location:http://127.0.0.1/projects/FlexiFlash/Events.php");
	}

if($permission != "Admin"){
$_SESSION["UserMessage"] = "You can not log in as you are not an Admin";
Redirect();
}
else
{
echo "Welcome";
}
$con=mysqli_connect("localhost","root","","flexiflash");

	// Check Connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else {
		echo "Connected to database!<br>";
	}
	$Band = $_POST["BandName"];
	
	$Date = $_POST["Date"];
		
	$Start = $_POST["EventStart"];
		
	$End = $_POST["EventEnd"];
		
	$Venue = $_POST["EventVenue"];
	
	$Cost = $_POST["EventCost"];
	
	
	echo "<br>" . $Band . " " . $Date . " " . $Start . " " . $End . " " . $Venue . " " . $Cost;
	
	$sql="INSERT INTO events(`band_name`,`play_date`, `play_time`, `end_time`, `event_venue`, `cost`) VALUES ('$Band','$Date', '$Start', '$End', '$Venue', '$Cost')";

		echo "enter thing";
		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error($con));
		}

	
Redirect();
		
	
mysqli_close($con)



?>