<!DOCTYPE html>
<html lang="en">

<head>
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

  <title>How to create bootstrap charts using bootstrap 5</title>
</head>
<style>
  .chart-container {
    width: 90%;
    height: 90%;
    margin: auto;
  }
</style>

<?php

// Query the database for name counts
$sql = "SELECT workstation_name, COUNT(*) as count FROM space_report_table GROUP BY workstation_name ORDER BY count DESC LIMIT 10";
$result = mysqli_query($conn, $sql);

// Create an associative array of name counts
$name_counts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $name_counts[$row['workstation_name']] = $row['count'];
}

//echo '<pre>'; print_r($name_counts); echo '</pre>';

mysqli_close($conn);

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
console.log(nameCountsJson)

const barLabels = Object.keys(name_counts);
const barData = Object.values(name_counts);

console.log(barLabels, barData)

</script>

<script>
      const ctx = document.getElementById("chart").getContext('2d');
      const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: barLabels,
          datasets: [{
            label: 'Workstations',
            //yAxisID: "Occured",
            backgroundColor: 'rgba(161, 198, 247, 1)',
            borderColor: 'rgb(47, 128, 237)',
            data: barData,
          }]
        },
        options: {
          scales: {
            xAxes: [{
              ticks: {
                fontSize: 8,
              }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                fontSize: 12,
              }
            }]
          }
        },
      });
</script>

</html>