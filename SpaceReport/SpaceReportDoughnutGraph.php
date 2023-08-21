<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="utf-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php 

  include 'DatabaseConnection.php';

  ?>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link
    rel="stylesheet"
    href="../contrast-bootstrap-pro/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="../contrast-bootstrap-pro/css/cdb.css" />
  <script
    src="../contrast-bootstrap-pro/js/cdb.js"></script>
  <script
    src="../contrast-bootstrap-pro/js/bootstrap.min.js"></script>
  <script
    src="https://kit.fontawesome.com/9d1d9a82d2.js"
    crossorigin="anonymous"></script>

</head>
<style>
  .chart-container {
    width: 90%;
    height: 90%;
    margin: auto;
  }
</style>

<?php
session_start();
$_SESSION['startDate'] = $start_date;
$_SESSION['endDate'] = $end_date;

// Query the database for name counts
$sql = "SELECT workstation_name, COUNT(*) as count FROM space_report_table WHERE scan_date BETWEEN '$start_date' AND '$end_date' GROUP BY workstation_name ORDER BY count DESC LIMIT 1000";
$result = mysqli_query($conn, $sql);

// Create an associative array of name counts
$name_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $name_counts[$row['workstation_name']] = $row['count'];
}

//echo '<pre>'; print_r($name_counts); echo '</pre>';

mysqli_close($conn);

$newColors=file("BarGraphColors.txt");

?>

<body>
  
  <div class="card chart-container">
    <canvas id="chart"></canvas>
  </div>

</body>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js">


</script>

<script type="text/javascript">
var name_counts = <?php echo json_encode($name_counts); ?>;
nameCountsJson = JSON.stringify(name_counts);
//console.log(nameCountsJson)

const barLabels = Object.keys(name_counts);
const barData = Object.values(name_counts);

//console.log(barLabels, barData)


function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}

let barColors = [];

for (let i = 0; i < barLabels.length; i++) {
  x = random_rgba()
  barColors.push(x);
}


var newColors = <?php echo json_encode($newColors); ?>;
newColors = JSON.stringify(newColors);
//console.log(newColors)
barColors = newColors.split(" ");
//console.log(barColors)

const ctx = document.getElementById("chart").getContext('2d');
const myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Workstations',
            data: barData,
            backgroundColor: barColors,
            hoverOffset: 4
        }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
});
</script>

</html>