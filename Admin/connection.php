<?php
    // Database connection
    $username = "root";
    $password = "";
    $database = "mydatabase";

    // Create connection
    $mysqli = new mysqli("localhost", $username, $password, $database);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
?>