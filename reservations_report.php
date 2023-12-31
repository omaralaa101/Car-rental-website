<?php
// Include database connection file
@include 'config.php';

// Fetch all data from the "reservations" table
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations List</title>
   
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-form label {
            margin-right: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .reservation-details {
            font-size: 14px;
            line-height: 1.5;
        }
        .reservation-details strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Reservations List</h2>

    <!-- Form for selecting a specific period -->
    <form action="" method="post" class="search-form">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <input type="submit" name="submit" value="Search">
    </form>

    <table>
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Car ID</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Location</th>
                <th>Customer Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Process form data to filter reservations by a specific period
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];

                // Fetch reservations within the specified period
                $sql = "SELECT * FROM reservations WHERE start_date >= '$startDate' AND end_date <= '$endDate'";
                $result = $conn->query($sql);
            }

            if ($result->num_rows > 0) {
                // Output data of each row as a table row
                while ($row = $result->fetch_assoc()) {
                    $reservationId = $row['reservation_id'];
                    $carId = $row['car_id'];
                    $startDate = $row['start_date'];
                    $endDate = $row['end_date'];
                    $location = $row['location'];
                    $customerName = $row['customer_name'];

                    echo "<tr>";
                    echo "<td>$reservationId</td>";
                    echo "<td>$carId</td>";
                    echo "<td>$startDate</td>";
                    echo "<td>$endDate</td>";
                    echo "<td>$location</td>";
                    echo "<td>$customerName</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>