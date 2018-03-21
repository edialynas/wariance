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
$command = "UPDATE C_INFO SET NAME='anonymous',
							  LAST='anonymeson',
							  EMAIL='noone@nowhere.com',
							  PASSWORD = 'nope',
							  INSTITUTE='UON',
							  COUNTRY='nomansland',
							  ACTIVE='no',
							  ACTIVATION_KEY='' WHERE UID='$userUID'";

// echo $command;
$query = mysqli_query($dbConn, $command);

mysqli_close($dbConn);
?>