<?php
$servername = "localhost";
$username = "cloakme"; // replace with your DB username
$password = "@Newyork84@";     // replace with your DB password
$dbname = "cloakmedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
