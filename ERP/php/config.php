<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "assignment"; // the name of the database used in the SQL dump
$port = 3307; // Default MySQL port


// Create a database connection
$conn =mysqli_connect($servername, $username, $password, $database,$port);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//else {
//    echo "success";
//}
?>
