<!DOCTYPE html>
<html>
<head>
  <title>Car Status Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    h2 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    table th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<h2>Car Status Report</h2>

<form method="get" action="">
  <label for="start_date">Start Date:</label>
  <input type="date" id="start_date" name="start_date" required>
  
  <label for="end_date">End Date:</label>
  <input type="date" id="end_date" name="end_date" required>
  
  <input type="submit" value="Search">
</form>

<table>
  <thead>
    <tr>
      <th>Car ID</th>
      <th>Car Model</th>
      <th>Car Year</th>
      <th>Car Color</th>
      <th>Status</th>
      <th>Start Date</th>
      <th>End Date</th>
    </tr>
  </thead>
  <tbody>
  <?php
    include 'config.php'; // Include your database connection file

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        $sql = "SELECT cf.car_id, cf.car_model, cf.car_year, cf.car_color, cf.status, r.start_date, r.end_date
                FROM car_form cf
                LEFT JOIN reservations r ON cf.car_id = r.car_id
                WHERE r.start_date IS NOT NULL AND r.end_date IS NOT NULL
                  AND ((r.start_date <= '$start_date' AND r.end_date >= '$start_date')
                  OR (r.start_date <= '$end_date' AND r.end_date >= '$end_date'))";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["car_id"] . "</td>";
                echo "<td>" . $row["car_model"] . "</td>";
                echo "<td>" . $row["car_year"] . "</td>";
                echo "<td>" . $row["car_color"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>" . $row["start_date"] . "</td>";
                echo "<td>" . $row["end_date"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No cars found for the specified date range.</td></tr>";
        }

        $conn->close();
    }
    ?>
  </tbody>
</table>

</body>
</html>