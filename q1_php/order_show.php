<?php

// Setup db connection
require_once('mysqli_connect.php');

// SQL query to fetch all orders from db
$query = "SELECT phone, sname, size, o_time, quantity, status FROM orders";

// Get response from db by sending query
$response = $dbc->query($query);

// If the query executed properly, proceed
if($response){

	// Table headers
	echo '<table align="left"
	cellspacing="5" cellpadding="8">

	<tr><td align="left"><b>Phone Number</b></td>
	<td align="left"><b>Sandwich Name</b></td>
	<td align="left"><b>Sandwich Size</b></td>
	<td align="left"><b>Order Time</b></td>
	<td align="left"><b>Quantity</b></td>
	<td align="left"><b>Status</b></td></tr>';

	// Scan through result of query
	while($row = mysqli_fetch_array($response)) {

		// Table rows
		echo '<tr><td align="left">' . 
		$row['phone'] . '</td><td align="left">' . 
		$row['sname'] . '</td><td align="left">' .
		$row['size'] . '</td><td align="left">' . 
		$row['o_time'] . '</td><td align="left">' .
		$row['quantity'] . '</td><td align="left">' . 
		$row['status'] . '</td></tr>';
	}

	// Provide a link to user be able to go make a new order
	echo '<tr><td><a href="search_sandwiches.php" style="background-color:#CCCCCC">Go make a new order</a></tr></td>';

	// Close table tag
	echo '</table>';



// Show error message if query wasn't executed properly
} else {

	// Show error message
	echo "Couldn't issue database query<br>";
	echo mysqli_error($dbc);

}

// Close connection to the database
mysqli_close($dbc);

?>
