<?php

// For debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Setup db connection
require_once('mysqli_connect.php');
session_start();

// Get keyword from session
$keyword = $_SESSION['keyword'];

// Protect from SQL injection
if($keyword){
	$keyword = stripslashes($keyword);
	$dbc->real_escape_string($keyword);
}

// Check presence of keyword, if so, search for matches in db, if not, fetch all options of sandwiches from db
if($keyword){

	// Create SQL query: Fetch sandwich info for sandwiches whose description includes the keyword
	$sandwiches_query = "SELECT sname, description, size, price FROM sandwich NATURAL JOIN menu WHERE description LIKE ?";

	// Prepare statement
	if ($stmt = $dbc->prepare($sandwiches_query)) {

		// Prepare keyword for preparred statement SQL query using LIKE
		$keyword = '%' . $keyword . '%';

		// Bind parameters
		$stmt->bind_param("s", $keyword);

		// Execute prepared statement
		$sandwiches_response = $stmt->execute();


		// OBS: Here I couldn't use mysqli_stmt::get_result, because I don't have the mysqlnd driver installed, so I had to use bind_result and fetch() instead. That's why the if statements here and in the case where there is no keyword input. Otherwise, it would have been possible to skip this verification, as it is done below again.

		// Run only if query executed successfully
		if($sandwiches_response) {

			// Bind result variables
		    $stmt->bind_result($sname, $description, $size, $price);

		    // Fetch values from db and also save results from db, in a way that it is possible to show sandwich name only once, while showing all of its available sizes
		    while ($stmt->fetch()) {
		    	$sandwiches_arr_dup[] = array("name" => $sname, "description" => $description);
		        $sandwiches_data[] = array("name" => $sname, "description" => $description, "size" => $size ,"price" => $price);
		    }
		}

		// Close statement
		$stmt->close();

	// Set response value to false, so that error message can be called below
	} else {
		$sandwiches_response = FALSE;
	}

	// Close connection
	$dbc->close();

} else {
	// Create db query
	$sandwiches_query = "SELECT sname, description, size, price FROM sandwich NATURAL JOIN menu";

	// Get response from db by sending the query
	$sandwiches_response = $dbc->query($sandwiches_query);

	// Run only if query was executed successfully
	if($sandwiches_response) {
		// Save results from db, in a way that it is possible to show sandwich name only once, while showing all of its available sizes
		while($row = $sandwiches_response->fetch_array(MYSQL_BOTH)) {	
			$sandwiches_arr_dup[] = array("name" => $row['sname'], "description" => $row['description']);
			$sandwiches_data[] = array("name" => $row['sname'], "description" => $row['description'], "size" => $row['size'] ,"price" => $row['price']);
		}
	}
};

// If the query was executed properly, proceed
if($sandwiches_response){

	// Add form and request user to select a sandwich along with its size
	echo '<form action="submit_order.php" method="post">
	<b>Select your sandwich and its size</b><br>';

	// Function created to get rid of duplicate arrays inside of any array
	function multi_unique($dup_arr) {
        foreach ($dup_arr as $k => $na)
            $new[$k] = serialize($na);
        $unique = array_unique($new);
        foreach($unique as $k => $ser)
            $new_arr[$k] = unserialize($ser);
        return ($new_arr);
    }

    // Get rid of duplicate arrays inside of the array gotten above as result of query
	$sandwiches_arr = multi_unique($sandwiches_arr_dup);

	// Loop over this array
	foreach ($sandwiches_arr as &$sandwich) {

		// Display sandwich name and description
		echo '<br><b>' . $sandwich['name'] . '</b>';
		echo '<br><em>' . $sandwich['description'] . '</em><br>';

		// Loop over original array gotten from the query
		foreach ($sandwiches_data as $row) {

			// When sandwich name matches in both arrays, show the sandwaich size and price only
			if($sandwich['name'] == $row['name']) {

				// Request user to select a sandwich and its size, through clicking in only one radio button
				echo '&nbsp;<input type="Radio" name="sname_size" value="' . $row['name'] . '_' . $row['size'] . '">' . $row['size'] . '</input> - ';
				echo '<em>$' . $row['price'] . '</em><br>';
			}
		}
	}

	// Submit button
	echo '<br><input type="submit" name="submit" value="Submit" />';
	echo '</form>';

// If the query doesn't execute properly, show error message
} else {

	// Show error message
	echo "Couldn't issue database query<br><br>";
	echo mysqli_error($dbc);

}

?>

<!-- Link to show db orders -->
<a href="order_show.php" style="background-color:#CCCCCC">Show all orders in database</a>
