<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';


// customer_page.php or chef_page.php
session_start();
$user_type = 'customer';
$userId = '';

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type) {
   $userType = $_SESSION['user_type'];
   $GLOBALS['userId'] = $_SESSION['id'];   
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

header_USER('customer');
body_customer($conn);
footer_USER();

function body_customer($conn){

   echo <<<BODY
      <div class="container">
         <div class="content">
            <h3>hi, <span>customer</span></h3>
            <h1>welcome <span>oi</span></h1>
            <p>this is an user page</p>
            <a href="login_form.php" class="btn">login</a>
            <a href="register.php" class="btn">register</a>
            <a href="logout.php" class="btn">logout</a>
         </div>
      </div>
   BODY;
}
?>
