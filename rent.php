<!DOCTYPE html>
<html>
<head>
  <title>Rent form</title>
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

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
      margin: 0 auto;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #333;
    }

    input[type="date"],
    input[type="text"],
    input[type="number"],
    select,
    input[type="email"],
    input[type="submit"] {
      width: calc(100% - 12px);
      padding: 8px;
      margin-bottom: 15px;
      border-radius: 3px;
      border: 1px solid #ffac38;
    }

    input[type="submit"] {
      background-color: #ffac38;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

</head>
<body>

<h2>Rent Details</h2>
<form action="" method="post" enctype="multipart/form-data">
        <h2>Add a Car Reservation</h2>
        <label for="car_id">Choose Car ID from the available cars below:</label>
<select name="car_id" required>
    <option value="">Select Car ID</option>
    <?php
include 'config.php'; // Include database connection file

$sql = "SELECT car_id, car_model, car_year, car_color, rent_price FROM car_form WHERE status = 'available'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['car_id'] . "'>" .
            "ID: " . $row['car_id'] . 
            " | Model: " . $row['car_model'] . 
            " | Year: " . $row['car_year'] . 
            " | Color: " . $row['car_color'] .
            " | Rent Price: " . $row['rent_price'] .
            "</option>";
    }
} else {
    echo "<option value=''>No cars available</option>";
}
$conn->close();
?>

</select>
<!-- html -->
<label for="customer_name">Customer Name:</label>
    <input type="text" name="customer_name">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required>

    <label for="location">Location:</label>
    <select name="location" id="location">
        <option value="Cairo">Cairo</option>
        <option value="Alexandria">Alexandria</option>
        <option value="Damanhour">Damanhour</option>
    </select>

    <!-- Existing fields for file upload and submit button remain unchanged -->

    <input type="submit" name="submit" value="Reserve">
</form>

<?php
include 'config.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';

    // Retrieve user  based on the provided email
    $user_id_query = "SELECT id FROM user_form WHERE email = '$email'";
    $result = $conn->query($user_id_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row['id'];

        // Insert data into the reservations table with customer_id
        $reservation_query = "INSERT INTO reservations (car_id, customer_id, start_date, end_date, location, customer_name, email)
                            VALUES ('$car_id', '$customer_id', '$start_date', '$end_date', '$location', '$customer_name', '$email')";

        if ($conn->query($reservation_query) === TRUE) {
            // If the reservation insertion was successful, retrieve the reservation_id
            $reservation_id = $conn->insert_id;

            // Insert data into the transactions table with reservation_id and transaction_date
            $transaction_date = date('Y-m-d H:i:s');
            $transaction_query = "INSERT INTO transactions (reservation_id, transaction_date)
                                VALUES ('$reservation_id', '$transaction_date')";

            if ($conn->query($transaction_query) === TRUE) {
                // Update the car status to 'rented' after successful transaction
                $update_query = "UPDATE car_form SET status = 'rented' WHERE car_id = '$car_id'";
                if ($conn->query($update_query) === TRUE) {
                    echo "New record created successfully and car status updated to 'rented'";
                    header('location:transaction.php');
                    exit();
                } else {
                    echo "Error updating car status: " . $conn->error;
                }
            } else {
                echo "Error inserting transaction: " . $transaction_query . "<br>" . $conn->error;
            }
        } else {
            echo "Error inserting reservation: " . $reservation_query . "<br>" . $conn->error;
        }
    } else {
        echo "No user found with this email";
    }

    $conn->close();
}


?>




</body>
</html>



