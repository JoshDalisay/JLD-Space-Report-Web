<!DOCTYPE html>
<html>
<body>
<?php
// NEEDS PHP GD2 TO WORK
// Connect to the database
$servername = "localhost";
$username = "jdalis5n";
$password = "South567456843!";
$database = "space_report";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query the database for name counts
$sql = "SELECT workstation_name, COUNT(*) as count FROM space_report_table GROUP BY workstation_name ORDER BY count DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

// Create an associative array of name counts
$name_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $name_counts[$row['workstation_name']] = $row['count'];
}


//echo json_encode($name_counts);

// Set up the chart parameters
$chart_width = 1280;
$chart_height = 720;
$bar_width = 50;
$bar_spacing = 80;
$font_size = 10;
$chart_title = "Most Common";

// Create the chart image
$chart = imagecreate($chart_width, $chart_height);

// Set up colors

$background_color = imagecolorallocate($chart, 161, 157, 157);
$bar_color = imagecolorallocate($chart, 100, 100, 255);
$label_color = imagecolorallocate($chart, 255, 255, 255);
$title_color = imagecolorallocate($chart, 255, 255, 255);

// Set the font
$font = "arial.ttf";

// Calculate the maximum count
$max_count = max($name_counts);

// Draw the bars and labels
$x = $bar_spacing;
$y = $chart_height - 50;
foreach ($name_counts as $name => $count) {
    // Calculate the bar height
    $bar_height = ($count / $max_count) * ($chart_height - 100);

    // Draw the bar
    imagefilledrectangle($chart, $x, $y - $bar_height, $x + $bar_width, $y, $bar_color);

    // Draw the label
    imagettftext($chart, $font_size, 0, $x + ($bar_width / 2) - (strlen($name) * ($font_size / 2)), $y + 20, $label_color, $font, $name);

    // Increment the x position
    $x += $bar_width + $bar_spacing;
}

// Draw the title
imagettftext($chart, $font_size + 4, 0, 20, 30, $title_color, $font, $chart_title);

// Output the image
ob_end_clean();
header("Content-Type: image/png");
imagepng($chart);

// Clean up
imagedestroy($chart);
mysqli_close($conn);

?>

<?php
/*
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "PHP GD library is installed on your web server";
}
else {
    echo "PHP GD library is NOT installed on your web server";
}
*/
?>
</body>
</html>