<?php
$conn = mysqli_connect("localhost", "root", "", "dorsuvoting");

// Check connection

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

?>