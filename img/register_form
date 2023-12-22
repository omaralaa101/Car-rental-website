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

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="style2.css">
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
        <h3>&copy; 2023 Omar Alaa Eldin</h3>
    </footer>
</body>
</html>
