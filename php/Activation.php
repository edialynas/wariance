<?php
// AUTHOR: Dimitrios Kyriakis
// EMAIL:  kyriakds@gmail.com
//
// C_INFO = USER INFORMATION TABLE
// 
// ******************************************************

$a = $_GET[ 'code' ];


$link = mysqli_connect("127.0.0.1","root","password","database");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


// FIND ID  
$query = "SELECT ID FROM C_INFO WHERE Activation_Key=\"$a\"";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$id = $row['ID'];

// IF THERE IS THIS ACTIVATION KEY
if($id==""){
	print("NO");
	exit();
}

$query2 = "UPDATE C_INFO SET Active=\"yes\" WHERE Activation_Key=\"$a\"  ";
mysqli_query($link, $query2);
$query3 = "UPDATE C_INFO SET Activation_Key=\"NULL\" WHERE ID=\"$id\"";
$result2 = mysqli_query($link, $query3);
print("Activated");

/* close connection */
mysqli_close($link);
?>