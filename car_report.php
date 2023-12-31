<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Car Report</title>
   <style>
        body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 20px;
         background-color: #f4f4f4;
      }

      /* Table styles */
      table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
         background-color: #fff;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      th, td {
         border: 1px solid #ddd;
         padding: 10px;
         text-align: left;
      }

      th {
         background-color: #f2f2f2;
      }

      tr:nth-child(even) {
         background-color: #f9f9f9;
      }

      td img {
         max-width: 80px;
         max-height: 80px;
         border-radius: 5px;
      }

      /* Header styles */
      h1 {
         margin-bottom: 20px;
      }
   </style>
</head>
<body>
   <h1>Car Report</h1>
   <table>
      <tr>
         <th>ID</th>
         <th>Model</th>
         <th>Color</th>
         <th>Year</th>
         <th>Rent Price</th>
         <th>Status</th>
         <th>Image</th>
      </tr>
      <?php
      include 'config.php'; // Include database connection file

      $sql = "SELECT * FROM car_form";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['car_id'] . "</td>";
            echo "<td>" . $row['car_model'] . "</td>";
            echo "<td>" . $row['car_color'] . "</td>";
            echo "<td>" . $row['car_year'] . "</td>";
            echo "<td>$" . $row['rent_price'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td><img src='" . $row['image_url'] . "' alt='Car Image' style='max-width: 100px; max-height: 100px;'></td>";
            echo "</tr>";
         }
      } else {
         echo "<tr><td colspan='7'>No cars available</td></tr>";
      }

      $conn->close();
      ?>
   </table>
</body>
</html>
