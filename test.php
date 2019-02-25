<?php
$con=mysqli_connect("localhost","root_","zxc123","test");
if (mysqli_connect_errno())
	  {
		    echo "Failed to connect to MySQL: " . mysqli_connect_error();
		      }
if (!mysqli_query($con,"INSERT INTO Persons (FirstName) VALUES ('Glenn')"))
	  {
		    echo("Error description: " . mysqli_error($con));
		      }

mysqli_close($con);
?>
