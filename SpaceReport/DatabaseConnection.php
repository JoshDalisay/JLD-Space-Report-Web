<?php
$servername = "localhost";
$username = "jdalis5n";
$password = "South567456843!";
$database = "space_report";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
/*
else {
    echo "Successfully Connected! <br>";
  }
*/