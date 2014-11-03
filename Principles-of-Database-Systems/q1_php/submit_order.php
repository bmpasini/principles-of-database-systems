<?php

if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['sname'])){

        // Adds name to array
        $data_missing[] = 'Sandwich Name';

    } else {

        // Trim white space from the name and store the name
        $sname = trim($_POST['sname']);

    }

    if(empty($_POST['size'])){

        // Adds size to array
        $data_missing[] = 'Sandwich Size';

    } else {

        // Trim white space from the size and store the size
        $size = trim($_POST['size']);

    }

    if(empty($data_missing)){

		require_once('mysqli_connect.php');

		// username and password sent from form 
		$sname = $_POST['sname'];
		$size = $_POST['size'];
		$phone = $_SESSION['phone'];

		// To protect MySQL injection
		$sname = stripslashes($sname);
		$sname = mysql_real_escape_string($sname);
		$size = stripslashes($size);
		$size = mysql_real_escape_string($size);
		$phone = stripslashes($phone);
		$phone = mysql_real_escape_string($phone);

		// Get quantity
		$find_quantity = "SELECT quantity FROM orders WHERE phone = '$phone' AND sname = '$sname' AND size = '$size' AND status = 'pending'";
		$result_quantity = @mysqli_query($dbc, $find_quantity);

		if($result_quantity) {
			while($row = mysqli_fetch_array($result_quantity)) {
				if($row['quantity']) {
					$quantity = $row['quantity'] + 1;
				} else {
					$quantity = 1;
				}
			}
		} else {
			echo "Couldn't issue database query<br />";
			echo mysqli_error($dbc);
		}

		// SQL query
		$query = "INSERT INTO order (phone, sname, size, o_time, quantity, status) VALUES (?, ?, ?, NOW(), ?, 'pending')";
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, "ssss", $phone, $sname, $size, $quantity);

		mysqli_stmt_execute($stmt);

		$affected_rows = mysqli_stmt_affected_rows($stmt);

		if($affected_rows == 1){
	        
	        echo 'Order Submited';
	        
	        mysqli_stmt_close($stmt);
	        
	        mysqli_close($dbc);
	        
	    } else {
	        
	        echo 'Error Occurred<br>';
	        echo mysqli_error();
	        
	        mysqli_stmt_close($stmt);
	        
	        mysqli_close($dbc);
	        
	    }

	} else {
        
        echo 'You need to enter the following data<br>';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br>";
            
        }
        
    }
    
}

?>