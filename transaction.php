<!DOCTYPE html>
<html>
<head>
  <title>Transaction Details</title>
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

    .transaction-details {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
      margin: 0 auto;
    }

    .transaction-details p {
      margin: 5px 0;
    }

    .transaction-details strong {
      font-weight: bold;
    }

    .pay-now-btn {
      display: block;
      margin-top: 15px;
      padding: 10px 20px;
      background-color: #ffac38;
      color: white;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
    }

    .pay-now-btn:hover {
      background-color: #45a049;
    }

  </style>
</head>
<body>

<h2>Transaction Details</h2>

<div class="transaction-details">
  <?php
  include 'config.php'; // Include your database connection file

  // Perform a JOIN query to retrieve required information
  $sql = "SELECT t.transaction_id, t.transaction_date, t.reservation_id, 
          r.customer_name, r.email, r.start_date, r.end_date, r.location, 
          c.car_model, c.car_year, c.car_color, c.rent_price
          FROM transactions t
          JOIN reservations r ON t.reservation_id = r.reservation_id
          JOIN car_form c ON r.car_id = c.car_id";
          

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Output data of each row
      while ($row = $result->fetch_assoc()) {
          echo "<p><strong>Transaction ID:</strong> " . $row["transaction_id"] . "</p>";
          echo "<p><strong>Transaction Date:</strong> " . $row["transaction_date"] . "</p>";
          echo "<p><strong>Reservation ID:</strong> " . $row["reservation_id"] . "</p>";
          echo "<p><strong>Customer Name:</strong> " . $row["customer_name"] . "</p>";
          echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
          echo "<p><strong>Start Date:</strong> " . $row["start_date"] . "</p>";
          echo "<p><strong>End Date:</strong> " . $row["end_date"] . "</p>";
          echo "<p><strong>Location:</strong> " . $row["location"] . "</p>";
          echo "<p><strong>Car Model:</strong> " . $row["car_model"] . "</p>";
          echo "<p><strong>Car Year:</strong> " . $row["car_year"] . "</p>";
          echo "<p><strong>Car Color:</strong> " . $row["car_color"] . "</p>";
          echo "<p><strong>Rent Price:</strong> " . $row["rent_price"] . "</p>";
          echo "<hr>";
      }
  } else {
      echo "<p>0 results</p>";
  }

  $conn->close();
  ?>
   
   <a href="transaction_success.php" class="pay-now-btn">Pay Now</a>
</div>

</body>
</html>
