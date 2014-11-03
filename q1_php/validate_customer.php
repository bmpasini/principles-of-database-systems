<?php

	// $host = "localhost"; // Host name 
	// $username = "root"; // Mysql username 
	// $password = ""; // Mysql password 
	// $db_name = "hw3_ex1"; // Database name 
	// $tbl_name = "customer"; // Table name 

	// // Connect to server and select databse.
	// mysql_connect("$host", "$username", "$password")OR die("cannot connect"); 
	// mysql_select_db("$db_name")OR die("cannot select DB");

	require_once('mysqli_connect.php');

	// username and password sent from form 
	$phone = $_POST['phone'];
	$keyword = $_POST['keyword'];

	// To protect MySQL injection
	$phone = stripslashes($phone);
	$phone = mysql_real_escape_string($phone);

	// SQL query
	$find_customer = "SELECT * FROM customer WHERE phone = '$phone'";
	$result_customer = mysql_query($find_customer);

	// Mysql_num_row is counting table row
	$count_customer = mysql_num_rows($result_customer);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count_customer == 1) {

		// Register $myusername, $mypassword and redirect to file "login_success.php"
		// session_register("phone");
		// session_register("keyword");
		$_SESSION["phone"] = $phone;
		$_SESSION["keyword"] = $keyword;
		header("location:order_new.php");
	}
	else {
		echo "Wrong Username or Password";
	}

?>