<?php
// AUTHOR: Dimitrios Kyriakis
// EMAIL:  kyriakds@gmail.com
//
// C_INFO = USER INFORMATION TABLE

$a = $_GET[ 'email' ];

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

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = substr( str_shuffle( $chars ), 0, 8 );
$encrypted_pass = md5($password);

$query2 = "UPDATE C_INFO SET PassKey='$encrypted_pass',Institute='$password' WHERE email='$a'";
mysqli_query($link, $query2);

print("ok");

// // ============ SEND MAIL ===================
// // the message
// $msg = "Congratulations! Your new password is : &password.";
// // use wordwrap() if lines are longer than 70 characters
// $msg = wordwrap($msg,70);
// // send email
// mail("kyriads@gmail.com","VCF Project",$msg);


/* close connection */
mysqli_close($link);
?>
