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
   $userID = $GLOBALS['userId'];
   $customer = retriveCustomer($conn, $userID);


   echo <<<BODY
      <div class="main-container">
         <div class="options-bar">
               <ul>
                  <li><a href="#" onclick="showOption('Option1')">Recent Orders</a></li>
                  <li><a href="#" onclick="showOption('Option2')">Experience</a></li>
                  <li><a href="#" onclick="showOption('Option3')">Reviews History</a></li>
               </ul>
         </div>
         <div class="account-info" id="account-info">
            <h2>Welcome, {$customer->getName()}</h2>
            <p><strong>Email:</strong> {$customer->getEmail()}</p>            
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
               window.location.href = 'customer_experience.php'; 
               break;
            case 'Option3':
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
