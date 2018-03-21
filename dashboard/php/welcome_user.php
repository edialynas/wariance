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
$query = mysqli_query($dbConn, "SELECT NAME FROM C_INFO WHERE UID='$userUID'");

$res = mysqli_fetch_array($query, MYSQLI_ASSOC);

// % CHECK %
$username = $res['NAME'];

print($username);

mysqli_close($dbConn);
?>


