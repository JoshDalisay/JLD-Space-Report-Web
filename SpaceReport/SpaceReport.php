<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <?php 

    include 'DatabaseConnection.php';
    
    ?>
    <title>Space Report</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="images/device-hdd-fill.svg">
  </head>
<body>

<h1>Space Report</h1>


<button type="button" class="btn btn-outline-primary" onclick="myFunction()">Change Date</button>
<div id="DateSelector" style="display:none;" >
  <form method="post" action="">
  Start Date: <input type="date" name="start_date" value="2023-04-01"><br><br>
  End Date: <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>"><br><br>
  <input type="submit" name="submit" value="Submit">
  </form>
</div>




<script>
function myFunction() {
  var x = document.getElementById("DateSelector");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<?php 
$start_date = '2023-04-01';
$end_date = date('Y-m-d');

if (isset($_POST['submit'])) {

  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];


  session_start();
  $_SESSION['startDate'] = $start_date;
  $_SESSION['endDate'] = $end_date;
}
?>


<div class="container-fluid">
  <div class="row gy-5">
    <div class="col-4">
      <?php

      $sql = "SELECT * FROM space_report_table WHERE scan_date BETWEEN '$start_date' AND '$end_date'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0) {
        echo '<table class="table table-hover"> <tr> <th> Id </th> <th> Name </th> <th> Date Scanned </th> <th> Storage Left </th> </tr>';
        while($row = mysqli_fetch_assoc($result)) {
          // to output mysql data in HTML table format
          echo '<tr > <td>' . $row["scan_id"] . '</td>
          <td>' . $row["workstation_name"] . '</td>
          <td>' . $row["scan_date"] . '</td>
          <td> ' . $row["storage_left"] . " GB" . '</td> </tr>';
        }
        echo '</table>';
        }
        else {
          echo "0 results";
        }

      // closing connection
      mysqli_close($conn);

      ?>
    </div>
    <div class="col-8">
      <?php 

      #include "SpaceReportBarGraph.php" 
      include "SpaceReportDoughnutGraph.php"

      ?>
    </div>
  </div>
</div>

<footer>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
  <div></div>
</footer>
</body>
</html>