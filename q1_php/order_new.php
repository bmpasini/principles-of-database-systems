<?php
// Get a connection for the database
require_once('mysqli_connect.php');

// Get keyword from session
$keyword = $_SESSION["keyword"];

// Protect from SQL injection
if($keyword){
	$keyword = stripslashes($keyword);
	$keyword = mysql_real_escape_string($keyword);
}

// Create a query for the database
if($keyword){
	$sandwiches_query = "SELECT sname, description, size, price FROM sandwich NATURAL JOIN menu WHERE description LIKE %'$keyword'%";
} else {
	$sandwiches_query = "SELECT sname, description, size, price FROM sandwich NATURAL JOIN menu";
};

// Get a response from the database by sending the connection and the query
$sandwiches_response = @mysqli_query($dbc, $sandwiches_query);

// If the query executed properly proceed
if($sandwiches_response){

	echo '<form action="submit_order.php" method="post">
	<b>Select your sandwich</b>'

	while($row = mysqli_fetch_array($response)) {	
		$sandwiches_arr_dup[] = array("name" => $row['sname'], "description" => $row['description']);
	}

	$sandwiches_arr = array_unique($sandwiches_arr_dup);

	foreach ($sandwiches_arr as &$sandwich) {

		// echo '<strong>' . $sandwich['name'] . '</strong>';
		echo '<input type="Radio" name="sname" value="' . $sandwich['name'] . '">' . $sandwich['name'] . '</input><br>';
		echo '<em>' . $sandwich['description'] . '</em><br>';

		while($row = mysqli_fetch_array($response)) {

			if($sandwich['name'] == $row['sname']) {

				echo '<input type="Radio" name="size" value="' . $row['size'] . '">' . $row['size'] . '</input><br>';

				echo '<em>' . $row['price'] . '</em><br>';
			}
		}
	}

	echo '<input type="submit" name="submit" value="Submit" />'
	echo '</form>'

} else {

	echo "Couldn't issue database query<br />";

	echo mysqli_error($dbc);

}

?>