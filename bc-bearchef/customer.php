<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'views/helpers_HTML.php';

// customer_page.php or chef_page.php
session_start();
$user_type = 'customer';
$userID = '';

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type) {
   $GLOBALS['userID'] = $_SESSION['userID'];   
   $userType = $_SESSION['user_type'];
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

head_HTML();
header_USER('customer');
body_customer($conn);
footer_USER();

function body_customer($conn){
   $userID = $GLOBALS['userID'];
   $customer = retriveCustomer($conn, $userID);
  
   echo <<<BODY
      <div class="main-container">
         <div class="options-bar">
               <ul>
                  <li><a href="#" onclick="showOption('Option1')">Recent Orders</a></li>
                  <li><a href="#" onclick="showOption('Option2')">Experience</a></li>
                  <li><a href="#" onclick="showOption('Option3')">Messages</a></li>
                  <li><a href="#" onclick="showOption('Option4')">Reviews History</a></li>
               </ul>
         </div>
         <div class="account-info" id="account-info">
            <h2>Welcome, {$customer->getName()}</h2>
            <p><strong>Email:</strong> {$customer->getEmail()}</p>            
            <p><strong>Address:</strong> {$customer->getAddress()}</p>            
            <p><strong>Phone:</strong> {$customer->getPhone()}</p>           
            <br>
            <h3>Settings from your house </h3>
            <p><strong>Type of Stove top:</strong> {$customer->getStringStoveTopType()}</p>
            <p><strong>Number of burners:</strong> {$customer->getNumBurners()} burners</p>
            <p><strong>Does it have an oven?</strong> {$customer->doesHaveOven()} </p>
            <p><strong></strong></p>
         </div>
      </div>

      <script>
      function showOption(option) {
         // Add logic for each option
         switch (option) {
            case 'Option1':
               window.location.href = 'customer_orders.php'; 
               break;
            case 'Option2':
               window.location.href = 'customer_display.php'; 
               break;
            case 'Option3':
               window.location.href = 'customer_read.php'; 
               break;
            case 'Option4':
               window.location.href = 'customer_reviews.php'; 
               break;           
            default:
               // You can choose to do nothing or redirect to a default page
               break;
         }
      }
   </script> 
   BODY;
}
?>
