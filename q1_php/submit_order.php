<?php

// If received a post request from previous page, proceed
if(isset($_POST['submit'])){
    
    // Keep track if user indeed selected an option in the previous page
    $data_missing = array();

    if(empty($_POST['sname_size'])){

        // Adds value 'sandwich and size' into array, indicating that user didn't select any value in the previous page
        $data_missing[] = 'Sandwich and size';

    } else {

        // Separate result in two different values, in order to input them in db
        $sname_size = explode("_", $_POST['sname_size']);

    }

    if(empty($data_missing)){

    	// Setup db connection and start session variables
		require_once('mysqli_connect.php');
		session_start();

		// Get splitted values from the form of the previous page, also the phone from session, and set status as 'pending'
		$sname = $sname_size[0];
		$size = $sname_size[1];
		$phone = $_SESSION['phone'];
		$status = 'pending';

		// Protect from MySQL injection
		$sname = stripslashes($sname);
		$size = stripslashes($size);
		$phone = stripslashes($phone);
		$dbc->real_escape_string($sname);
		$dbc->real_escape_string($size);
		$dbc->real_escape_string($phone);

		// Get current quantity of selected order, using prepared statement
		$find_quantity = "SELECT quantity FROM orders WHERE phone = ? AND sname = ? AND size = ? AND status = ?";
		
		// Prepare statement
		if ($stmt = $dbc->prepare($find_quantity)) {

			// Bind parameters
			$stmt->bind_param("ssss", $phone, $sname, $size, $status);

			// Execute prepared statement
			$executed = $stmt->execute();

			// If query was successfully executed, proceed
			if($executed) {

				// Bind result variable
		    	$stmt->bind_result($quantity);

				// If the user has a pending order of the same size of the same kind of sandwich, the quantity on that order must be increased by one. If that is not the case, we will just insert a new order to the db.
				if($stmt->fetch()) {
					$update = TRUE;
					$quantity = $quantity + 1;
				} else {
					$update = FALSE;
					$quantity = 1;
				}

			// If the query wasn't executed properly, show error message
			} else {
				// Show error message
				echo "Couldn't issue database query<br>";
				echo mysqli_error($dbc);
			}

			// Close statement
		    $stmt->close();

		// If the query couldn't be executed, show error message
		} else {
			// Show error message
			echo "Couldn't issue database query<br>";
			echo mysqli_error($dbc);
		}

		// $result_quantity = $dbc->query($find_quantity);

		// SQL queries, using preparred statements and following condition indicated above.
		if ($update) {
			$query = "UPDATE orders SET quantity = ?, o_time = NOW() WHERE phone = '$phone' AND sname = '$sname' AND size = '$size' AND status = 'pending'";
		} else {
			$query = "INSERT INTO orders (phone, sname, size, o_time, quantity, status) VALUES (?, ?, ?, NOW(), ?, ?)";
		}

		// Preparred statement
		$stmt = $dbc->prepare($query);
		
		// Bind parameters
		if ($update) {
			$stmt->bind_param("i", $quantity);
		} else {
			$stmt->bind_param("sssis", $phone, $sname, $size, $quantity, $status);
		}

		// Execute prepared statement
		$stmt->execute();

		// Check how many rows were affected. The result must be 1
		$affected_rows = $stmt->affected_rows;

		// If only one row was affected, proceed
		if($affected_rows == 1){
	        
	        echo 'Order Submited';
	       
	    // For any other value as a result, show error message
	    } else {
	        
	        // Show error message
	        echo 'Error Occurred<br>';
	        echo mysqli_error();
	        
	    }

	    // Close statement
		$stmt->close();
        
        // Close connection
        $dbc->close();

	    // Provide link to go to show orders page
	    echo '<br><br>';
	    echo '<a href="order_show.php" style="background-color:#CCCCCC">Show all orders in database</a>';

	// If any option was selected in previous page, user should to go back and select one
	} else {
        
        // Show warning message and provide a link to go back
        echo 'You need to select a sandwich and its size';
		echo '<br><br><a href="order_new.php" style="background-color:#CCCCCC">Go back</a>';

    }
    
}

?>


