<?php
$servername = "localhost";
$username = "";
$password = "";
$database = "";

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
