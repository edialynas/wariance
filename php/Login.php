<?php
// AUTHOR: Dimitrios Kyriakis
// EMAIL:  kyriakds@gmail.com
//
// C_INFO = USER INFORMATION TABLE
// 
// ************************************

$a = $_GET[ 'email' ];
$b = $_GET[ 'pass' ];
$enc_pass = md5($b);



$link = mysqli_connect("127.0.0.1","root","password","database");


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


//  PSAKSE AMA YPARXERI TO MAIL
$query = "SELECT ID FROM C_INFO WHERE email='$a'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$id = $row['ID'];
// NO ACCOUNT
if($id==""){
	print("error");
	exit();
}

//  YPARXEI MAIL OPOTE OK
$query2 = "SELECT ID FROM C_INFO WHERE email='$a' AND PassKey='$enc_pass'";
$result2 = mysqli_query($link, $query2);
$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
$id2 = $row2['ID'];
// WRONG PASS
if($id2==""){
	print("wrong");
	exit();
}

$query3 = "SELECT * FROM C_INFO WHERE email='$a'";
$result3 = mysqli_query($link, $query3);
$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
$id3 = $row3['Active'];


if($id3=="yes"){
	print($row3['ID']);
	session_start();
	$_SESSION["userID"] = $row3['ID'];
	exit();
}

print($id3);


/* close connection */
mysqli_close($link);
?>
