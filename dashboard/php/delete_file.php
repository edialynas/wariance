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

$FID = $_GET[ 'fileID' ];

// Modify accordingly
$dbConn = mysqli_connect("127.0.0.1", "root", "**password**", "**database**");


if ($dbConn->connect_errno)
{
	print("\n\tDatabase connection failed..\n");
	exit();
}

// % CHECK %
$query = mysqli_query($dbConn, "SELECT PATH FROM FILE WHERE FID='$FID'");

$res = mysqli_fetch_array($query, MYSQLI_ASSOC);

// % CHECK %
$path = $res['PATH'];

// % CHECK %
$query = mysqli_query($dbConn, "DELETE FROM FILE WHERE FID='$FID'");

mysqli_close($dbConn);
?>