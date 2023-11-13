<?php

include 'includes/config.php';

// customer_page.php or chef_page.php
session_start();

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'chef') {
   $userType = $_SESSION['user_type'];
   $userId = $_SESSION['id'];
   // ... any other information you stored in the session

   // Now you can use $userType, $userId, and other session data as needed
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hi, <span>chef</span></h3>
      <h1>welcome <span><?php echo $_SESSION['name'] ?></span></h1>
      <p>this is an admin page</p>
      <a href="login_form.php" class="btn">login</a>
      <a href="register.php" class="btn">register</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>