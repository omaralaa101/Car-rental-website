<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Car Control Panel</title>
   <link rel="stylesheet" href="style.css">

   
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
      select,
      input[type="file"] {
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

      .car-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .car-info img {
            width: 150px;
            margin-right: 20px;
        }
        .car-details {
            font-size: 16px;
        }
    
   </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Add a Car</h2>
        <label for="car_model">Car Model:</label>
        <input type="text" name="car_model" required>

        <label for="car_year">Car Year:</label>
        <input type="text" name="car_year" required>

        <label for="car_color">Car Color:</label>
        <input type="text" name="car_color" required>

        <label for="rent_price">Rent Price (per day):</label>
        <input type="text" name="rent_price" required>

        <label for="car_status">Car Status:</label>
    <select name="car_status" required>
        <option value="available">Available</option>
        <option value="rented">Rented</option>
        <option value="out of service">Out of Service</option>
    </select>


        <label for="image_url">Upload Image:</label>
        <input type="file" name="image_url" accept="image/*" required>

        <input type="submit" name="submit" value="Add">
    </form>


    
    <form action="" method="POST" enctype="multipart/form-data">
    <h2>Modify Car Status</h2>
    <label for="modify_car_id">Select Car to Modify:</label>
    <select name="modify_car_id" required>
        <?php
        include 'config.php'; // Include database connection file

        $sql = "SELECT car_id, car_model FROM car_form";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['car_id'] . "'>" . $row['car_id'] . " - " . $row['car_model'] . "</option>";
            }
        } else {
            echo "<option value=''>No cars available</option>";
        }
        ?>
    </select>
       <label for="new_status">Select New Status:</label>
       <select name="new_status" required>
           <option value="available">Available</option>
           <option value="rented">Rented</option>
           <option value="out of service">Out of Service</option>
       </select>

       <input type="submit" name="modify" value="Modify Status">
   </form>
   <?php
include 'config.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify'])) { // Update this line
    $modify_car_id = mysqli_real_escape_string($conn, $_POST['modify_car_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);

    // Perform the update query
    $update_query = "UPDATE car_form SET status = '$new_status' WHERE car_id = '$modify_car_id'";

    if ($conn->query($update_query) === TRUE) {
        echo "Car status updated successfully";
    } else {


echo "Error updating car status: " . $conn->error;
    }

    $conn->close();
}

?>

    <?php
    include 'config.php'; // Include database connection file

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Collect form data
        $car_model = isset($_POST['car_model']) ? $_POST['car_model'] : '';
        $car_year = isset($_POST['car_year']) ? $_POST['car_year'] : '';
        $car_color = isset($_POST['car_color']) ? $_POST['car_color'] : '';
        $rent_price = isset($_POST['rent_price']) ? $_POST['rent_price'] : '';
        $car_status = isset($_POST['car_status']) ? $_POST['car_status'] : ''; // Fetch the car status

        // File upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image_url"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["image_url"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";

               // Create the 'uploads' directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["image_url"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }   
        }

        // Insert data into the table if the file upload was successful
        if ($uploadOk == 1) {
            $image_url = $target_file;
            // Insert data into the table
            $sql = "INSERT INTO car_form (car_model, car_year, car_color, rent_price, image_url, status)
            VALUES ('$car_model', '$car_year', '$car_color', '$rent_price', '$image_url', '$car_status')"; // Include status in the SQL query


            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    ?>   
   <form action="" method="post" enctype="multipart/form-data">
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