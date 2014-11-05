<?php

// Connect to db
require_once('mysqli_connect.php');

// phone and keyword sent from form
$phone = $_POST['phone'];
$keyword = $_POST['keyword'];

// Protect from MySQL injection
$phone = stripslashes($phone);
$dbc->real_escape_string($phone);

// SQL query: Select customer whose phone number matches the number entered in the form of previous page
$find_customer = "SELECT * FROM customer WHERE phone = ? ";

// Prepare statement
if ($stmt = $dbc->prepare($find_customer)) {

	// Bind parameters
	$stmt->bind_param("s", $phone);

	// Execute prepared statement
	$stmt->execute();

	// Store result
	$stmt->store_result();

	// Check the number of rows in the result (it has to be 1, due to unique phone numbers identifing customers)
	$count_customer = $stmt->num_rows;

	// Free result
    $stmt->free_result();

	// Close statement
    $stmt->close();
}

// Close connection
$dbc->close();

// If phone number is in db, query was successful
if($count_customer == 1) {
	// Store phone and keyword in session and redirect to file "order_new.php"
	session_start();
	$_SESSION['phone'] = $phone;
	$_SESSION['keyword'] = $keyword;
	session_write_close();
	header("Location:order_new.php");
}
else {
	// If number is not on db, display error message
	echo "Phone number doesn't exist in database";
	echo '<br><br><a href="search_sandwiches.php" style="background-color:#CCCCCC">Go back</a>';
}

?>