<?php

// Setup connection with db
$user = 'root';
$password = 'root';
$db = 'hw3_ex1';
$host = 'localhost';
$port = 8889;

$dbc = new mysqli($host, $user, $password, $db, $port);

// Check connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>