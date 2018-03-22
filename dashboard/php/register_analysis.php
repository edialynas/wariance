<?php
// Insert in mySQL the users Analysis query. 
// Talks with Zacks dashboard

// Editor: Kleio-Maria Verrou
// Last edit: 22/03/2018

session_start();
$userUID = $_SESSION["userID"]; // check if homepage uses a different session-variable name
// Modify accordingly

// Get the 3 wanted values
$analysisFID1 = $_GET["analysisFID1"]
$analysisFID2 = $_GET["analysisFID2"]
$analysisType = $_GET["analysisType"]

// Connect to the database
$dbConn = mysqli_connect("127.0.0.1", "root", "**password**", "**database**");
if ($dbConn->connect_errno)
{
    print("\n\tDatabase connection failed..\n");
    exit();
}

// Query on mySQL
$query = mysqli_query($dbConn, "INSERT INTO ANALYSES (user_id, file_id_1, file_id_2, analysis_type) VALUES ($userUID, $analysisFID1, $analysisFID2, $analysisType ) ");
mysqli_close($dbConn);

?>

