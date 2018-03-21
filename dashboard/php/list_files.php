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


	echo "<tr>";

	// % CHECK %
	echo "<td>" . $row['NAME'] . "</td>";

	echo "<td>
		<button type='button' class='btn btn-default btn-xs' onclick='deleteFile(".$FID.")'  style='font-size:15px;float:right;margin-left: 2px;padding-left: 20px;padding-right: 20px;background:#FD3A0F;' data-toggle='tooltip' title='Delete' id='deleteFileBtn'>
        <span class='glyphicon glyphicon-trash'></span>
        </button>&nbsp;
        <button type='button' class='btn btn-default btn-xs' onclick='previewFile(".$FID.");reshowFile()' style='font-size:15px;float:right;margin-right: 2px;padding-left: 20px;padding-right: 20px;' data-toggle='tooltip' title='Preview'>
        <span class='glyphicon glyphicon-search'></span>
        </button>
        </td>";

	echo "</tr>";
}

mysqli_close($dbConn);
?>