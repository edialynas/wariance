<?php
// AUTHOR: Dimitrios Kyriakis
// EMAIL:  kyriakds@gmail.com
//
// C_INFO = USER INFORMATION TABLE
// 
// ************************************

$a = $_GET[ 'FName' ];
$b = $_GET[ 'LName' ];
$c = $_GET[ 'email' ];
$d = $_GET[ 'Inst' ];
$e = $_GET[ 'Count' ];



$link = mysqli_connect("127.0.0.1","root","password","database");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// ========== Create Password =============
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = substr( str_shuffle( $chars ), 0, 8 );
$encrypted_pass = md5($password);
$activation = substr( str_shuffle( $chars ), 0, 11 );

//  CHEKARE AN YPARXERI TO MAIL
if ($result = mysqli_query($link, "SELECT * FROM C_INFO where email='$c'")) {

    /* determine number of rows result set */
    $row_cnt = mysqli_num_rows($result);
    
    //  YPARXEI ARA MHN KANEIS KATI
    if ($row_cnt!=""){
		print(1);
	}
	// DEN YPARXEI ARE KANE REGISTER
	elseif($result1 = mysqli_query($link, "INSERT INTO C_INFO SET Name='$a',Last='$b',email='$c',PassKey='$encrypted_pass',Institute='$password',Country='$e',Activation_Key='$activation',Active='no'")) {
	// Register User

	
	// ============ SEND MAIL ===================
	// the message
	$msg = "Congratulations! You have been registered in VCF Project. Your password is : &password. You can activate your account from here: http://127.0.0.1/xaxa.htm#$activation";
	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($msg,70);
	// send email
	mail("kyriads@gmail.com","VCF Project",$msg);

	print(0);
	}
}



/* close connection */
mysqli_close($link);
?>