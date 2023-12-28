<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Car Control Panel</title>
   
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 20px;
      }
      
      form {
         max-width: 400px;
         margin: 0 auto;
         padding: 20px;
         border: 1px solid #ccc;
         border-radius: 5px;
         background-color: #f9f9f9;
      }
      
      input[type="text"],
      select {
         width: 100%;
         padding: 10px;
         margin-bottom: 10px;
         border: 1px solid #ccc;
         border-radius: 3px;
         box-sizing: border-box;
      }
      
      input[type="submit"] {
         width: 100%; 
         padding: 10px;
         border: none;
         border-radius: 3px;
         background-color: #007bff;
         color: #fff;
         cursor: pointer;
      }
      
      input[type="submit"]:hover {
         background-color: #0056b3;
      }
   </style>
</head>
<body>
   <form action="" method="post">
       <h2>Add a Car </h2>
       <label for="car_id">Car ID:</label>
       <input type="text" name="car_id" required>

       <label for="car_model">Car Model:</label>
       <input type="text" name="car_model" required>

       <label for="car_year">Car Year:</label>
       <input type="text" name="car_year" required>

       <label for="car_color">Car Color:</label>
       <input type="text" name="car_color" required>

       <label for="rent_price">Rent Price (per day):</label>
       <input type="text" name="rent_price" required>

       <input type="submit" name="submit" value="Add">
   </form>

   <?php
   include 'config.php'; // Include database connection file

   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
       // Collect form data
       $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : '';
       $car_model = isset($_POST['car_model']) ? $_POST['car_model'] : '';
       $car_year = isset($_POST['car_year']) ? $_POST['car_year'] : '';
       $car_color = isset($_POST['car_color']) ? $_POST['car_color'] : '';
       $rent_price = isset($_POST['rent_price']) ? $_POST['rent_price'] : '';

       // Insert data into the table
       $sql = "INSERT INTO car_form (car_id, car_model, car_year, car_color, rent_price)
               VALUES ('$car_id', '$car_model', '$car_year', '$car_color', '$rent_price')";

       if ($conn->query($sql) === TRUE) {
           echo "New record created successfully";
       } else {
           echo "Error: " . $sql . "<br>" . $conn->error;
       }
   }

   ?>

   
   <form action="" method="post">
       <label for="remove_car_id"><h2>Remove a Car</h2></label>
       <select name="remove_car_id">
           <?php
           include 'config.php'; // Include database connection file

           $sql = "SELECT car_id, car_model, car_color, car_year, rent_price FROM car_form";
           $result = $conn->query($sql);

           if ($result->num_rows > 0) {
               while ($row = $result->fetch_assoc()) {
                   echo "<option value='" . $row['car_id'] . "'>" . 
                        "ID: " . $row['car_id'] . " | Model: " . $row['car_model'] . 
                        " | Color: " . $row['car_color'] . " | Year: " . $row['car_year'] .
                        " | Rent Price: $" . $row['rent_price'] . "</option>";
               }
           } else {
               echo "<option value=''>No cars available</option>";
           }
           ?>
       </select>
       <input type="submit" name="remove" value="Remove">
   </form>

   <?php
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
       if (!empty($_POST['remove_car_id'])) {
           $remove_car_id = $_POST['remove_car_id'];
           $sql_delete = "DELETE FROM car_form WHERE car_id = '$remove_car_id'";

           if ($conn->query($sql_delete) === TRUE) {
               echo "Record with Car ID $remove_car_id deleted successfully";
           } else {
               echo "Error deleting record: " . $conn->error;
           }
       }
   }

   $conn->close();
   ?>
</body>
</html>
