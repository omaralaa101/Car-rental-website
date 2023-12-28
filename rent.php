<!DOCTYPE html>
<html>
<head>
  <title>Date and Location Form</title>
</head>
<body>

<h2>Rent Details</h2>

<form action="/submit" method="post">
  <label for="start_date">Start Date:</label>
  <input type="date" id="start_date" name="start_date" required><br><br>

  <label for="end_date">End Date:</label>
  <input type="date" id="end_date" name="end_date" required><br><br>

  <label for="location">Location:</label>
  <input type="text" id="location" name="location" required><br><br>

    <label for="Car_ID">Car ID:</label>
  <input type="text" id="Car_ID" name="Car_ID" required><br><br>

  
  <input type="submit" value="Submit">
</form>

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

</body>
</html>