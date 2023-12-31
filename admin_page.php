<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">

<body>
</head>

   
<header>
        
        <div id="menu"><box-icon name='menu'></box-icon></div>
       
        <div class="header-btn">
            
            <a href="logout.php" class="sign-in">logout</a>
        </div>
        <a href="#"></a>
    </header>

    


    <!--home-->
    <section class="home" id="home">

    
     <div class="text">  

<!--USER WELCOME--> 
     
<div class="container">

<div class="content">
    <h1>hi, <span class="user-header">admin <?php echo $_SESSION['admin_name'] ?></h1>
</div>

</div>
<br>
<br>
<br>
<div class="rent-container">
      <div class="about-text">
      <a href="car_form.php" class="btn">Car Management</a>
      </div>
    </div>
<br> 
<br>

<div class="rent-container">
      <div class="about-text">
 <a href="reservations_report.php" class="btn">Reservations Report</a>
      </div>
    </div>
<br>
<br>


<div class="rent-container">
      <div class="about-text">
 <a href="car_report.php" class="btn">Car Report</a>
      </div>
    </div>
<br>
    

<br>



<div class="rent-container">
      <div class="about-text">
 <a href="car_search.php" class="btn">Car Search</a>
      </div>
    </div>

   
      

   <script src="https://unpkg.com/scrollreveal"></script>

    <script src="main.js"></script>
    
</body>
</html>
