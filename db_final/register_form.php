<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $error = array(); // Initialize an error array

    // Validate the password using a JavaScript-like function
    function isValidPassword($password) {
        return preg_match('/[!@#\$%\^&\*]/', $password) && strlen($password) >= 10;
    }

    // Check if the email already exists
    $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Passwords do not match!';
        } else if (!isValidPassword($_POST['password'])) {
            $error[] = 'Password must contain at least one special character (!, @, #, $, %, ^, & or *) and be at least 10 characters long.';
        } else {
            $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')";
            mysqli_query($conn, $insert);
            header('location: login_form.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Register Now</h3>
            <?php
            if (isset($error) && count($error) > 0) {
                foreach ($error as $errMsg) {
                    echo '<span class="error-msg">' . $errMsg . '</span>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <select name="user_type">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>
    </div>
    <footer>
        <h3>&copy; 2023 Omar Alaa - Yehia Tarek </h3>
    </footer>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.form-container {
    width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
}

h3 {
    text-align: center;
    margin-bottom: 20px;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    border: none;
    border-radius: 5px;
    background-color: #fe5b3d;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #ffac38;
}
.error-msg {
    color: red;
    margin-bottom: 10px;
}

p {
    text-align: center;
    margin-top: 15px;
}

footer {
    text-align: center;
    margin-top: 30px;
}

footer h3 {
    color: #555;
}

</style>    
</body>
</html>
