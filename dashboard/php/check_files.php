<?php

// AUTHOR: Zacharias Papadovasilakis
// EMAIL:  zpapadov@hotmail.com


// ********************* IMPORTANT **********************
// Lines marked with % CHECK % need evaluation if database's table and/or column names
// are correct.
//
// C_INFO = USER INFORMATION TABLE
// FILE = FILE INFORMATION TABLE
// 
// ******************************************************

session_start();
$userUID = $_SESSION["userID"]; // check if homepage uses a different session-variable name

// Modify accordingly
$dbConn = mysqli_connect("127.0.0.1", "root", "**password**", "**database**");

if ($dbConn->connect_errno)
{
	print("\n\tDatabase connection failed..\n");
	exit();
}

// % CHECK %
$query = mysqli_query($dbConn, "SELECT NAME,FID FROM FILE WHERE UID='$userUID'"); 
if (! mysqli_fetch_array($query, MYSQLI_ASSOC))
{
	echo "<tr>";
	echo "<td>No file has been uploaded</td>";
	echo "<tr>";
	exit();
}

// % CHECK %
$query = mysqli_query($dbConn, "SELECT NAME,FID FROM FILE WHERE UID='$userUID'");

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
{

	// % CHECK %
	$FID = $row['FID'];

	echo "<tr><td>
			<input name='analcheck' type='checkbox' class='filled-in' id='filled-in-box-file".$FID."' onchange='disableCheckBox()' value='".$FID."'/>
			<label for='filled-in-box-file".$FID."' style='color: black; font-weight: normal; font-size: 13px; width:100%;'>".$row['NAME']."</label>
		 </td></tr>";
}

mysqli_close($dbConn);
?>