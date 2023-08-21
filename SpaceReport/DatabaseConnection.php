<?php
$servername = "localhost";
$username = "report_space";
$password = "#Comp%Room3224!";
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