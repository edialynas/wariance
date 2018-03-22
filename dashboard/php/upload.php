<?php

// Editor: Kleio-Maria Verrou
// Last editor: 22/03/2018
// Remember : create a directory at the step of Signing up!! 
// CREATE THE DATABASE TABLE OF FILE

// Remember: In order to enable the uploading => permissions!!
//https://stackoverflow.com/questions/15708329/enable-permissions-on-a-folder-to-allow-file-upload => need to apply this!

// Note: Works with hmtl but has troubles with Ajax :/ Need to discuss with mr. Dialynas


session_start();
$userUID = $_SESSION["userID"]; // check if homepage uses a different session-variable name
// Modify accordingly

$target_dir = "uploads/".$userUID; // "Set" as directory the uniq directory of each user

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // target file with users directory.
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
	echo "Sorry, file already exists.\n ";
	$uploadOk = 0;
}

// Shouldnt we have a limitation for the size?!?
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file. \n";
    }
}

// Connect to mySQL in order to write in FILE table the file info.
$dbConn = mysqli_connect("127.0.0.1", "root", "**password**", "**database**");
if ($dbConn->connect_errno)
{
    print("\n\tDatabase connection failed..\n");
    exit();
}

// The query fields have to change a bit, because we worked as Zack and not as Akis.
$query = mysqli_query($dbConn, "INSERT INTO FILE (UID, NAME, PATH) VALUES ($userUID, name, $target_dir) ");

mysqli_close($dbConn);
?> 