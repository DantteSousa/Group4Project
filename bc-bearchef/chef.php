<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/user_class.php';

session_start();
$user_type = 'chef';
$userId = '';

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type) {
   $userType = $_SESSION['user_type'];
   $GLOBALS['userId'] = $_SESSION['id'];   
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

header_USER('chef');
body($conn);
footer_USER();

function body($conn){
   $userID = $GLOBALS['userId'];
   $select = "SELECT * FROM user_form WHERE id = $userID";

   $chef = new Chef();
   $result = mysqli_query($conn, $select);
   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);
      $chef->setIdid = $row["id"];
      $name = $row["name"];
      $email = $row["email"];
      $chef->setPhone = $row["phone"];
   }
   
   
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
            <h2>Welcome, ${name}</h2>
            <p>Email: ${email}</p>
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