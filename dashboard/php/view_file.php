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

mysqli_close($dbConn);

// The following bash commands require a specific vcf format in order to view the file
$fileContents = shell_exec("cat '$path' | grep -v '^##' | grep -v '^ '" );

// Table header
$head = shell_exec("echo '$fileContents' | grep '^#'");
$headArr = explode("\t", $head);
$nCols = count($headArr);

// Table contents
$data = shell_exec("echo '$fileContents' | grep '^chr'");
$dataArr = explode("\n", $data);
$nRows = count($dataArr);

// // First 5 and last 5 rows of file for preview
// $previewData = shell_exec("echo '$data' | (head -n5; tail -n5)");
// $lines = shell_exec("echo '$previewData' | wc -l");


echo "<thead>";
for ($j=0; $j<$nCols; $j++) {
    echo "<th style='position:sticky;'>'$headArr[$j]'</th>";
}
echo "</thead>";


for ($i = 1; $i <= 5; $i++) {

    $line = shell_exec("echo '$data' | head -n'$i' | tail -n1");  
    $lineArr = explode("\t", $line);

    echo "<tr>";
    for ($j=0; $j<$nCols; $j++) {
    	echo "<td>'$lineArr[$j]'</td>";
    }
    echo "</tr>";
}


for ($i = 1; $i <= 3; $i++) {
	echo "<tr>";
	for ($j=0; $j<$nCols; $j++) {
	    echo "<td>...</td>";
	}
	echo "</tr>";
}

for ($i = 6; $i >= 2; $i--) {

    $line = shell_exec("echo '$data' | tail -n'$i' | head -n1");
    $lineArr = explode("\t", $line);

    echo "<tr>";
    for ($j=0; $j<$nCols; $j++) {
    	echo "<td>'$lineArr[$j]'</td>";
    }
    echo "</tr>";
}

?>