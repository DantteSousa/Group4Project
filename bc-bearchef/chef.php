<?php

include 'includes/config.php';
include 'views/helpers_user.php';

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

header_USER('chef');
body();
footer_HTML();

function body(){
   echo <<<BODY
      <div class="main-container">
      <div class="options-bar">
            <ul>
               <li><a href="#" onclick="showOption('Option1')">Pending-Orders</a></li>
               <li><a href="#" onclick="showOption('Option2')">Accepted Orders</a></li>
               <li><a href="#" onclick="showOption('Option3')">Schedule</a></li>
               <li><a href="#" onclick="showOption('Option4')">Reviews</a></li>
            </ul>
      </div>
      <div class="account-info" id="account-info">
            <h2>Welcome, User123!</h2>
            <p>Email: user123@example.com</p>
            <p>Membership Level: Premium</p>
      </div>
   </div>

   <script>
      function showOption(option) {
            var accountInfoContainer = document.getElementById('account-info');
            var content = '';

            // Add logic for each option
            switch (option) {
               case 'Option1':
                  content = 'Specific content for Pending-Orders';
                  break;
               case 'Option2':
                  content = 'Specific content for Accepted Orders';
                  break;
               case 'Option3':
                  content = 'Specific content for Schedule.';
                  break;
               case 'Option4':
                  content = 'Specific content for Reviews';
                  break;
               default:
                  content = 'Select an option to view content.';
            }

            // Update content in the account info container
            accountInfoContainer.innerHTML = content;
      }
      </script>   
   BODY;
}
?>