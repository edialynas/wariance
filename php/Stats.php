<?php
// AUTHOR: Dimitrios Kyriakis
// EMAIL:  kyriakds@gmail.com
//
// C_INFO = USER INFORMATION TABLE
// 
// ************************************

$link = mysqli_connect("127.0.0.1","root","password","database");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


// FIND ID  
$query = "SELECT COUNT(ID) AS RESULT From C_INFO";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$num = $row['RESULT'];

$query2 = "SELECT COUNT(DISTINCT Institute) AS Inst From C_INFO";
$result2 = mysqli_query($link, $query2);
$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
$inst = $row2['Inst'];


print($num);
print("_");
print($inst);

/* close connection */
mysqli_close($link);
?>