<?php
include "views/helpers_HTML.php";
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

session_start();
$user_type = 'chef';
$userID = '';

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type) {
   $userType = $_SESSION['user_type'];
   $GLOBALS['userID'] = $_SESSION['userID'];   
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}
head_HTML();
header_USER('chef');
body($conn);
footer_USER();

function body($conn){
   $userID = $GLOBALS['userID'];
   $chef = retrieveChef($conn, $userID);

   $membershipLevel = ($chef->getIsPremium() == 0) ? "Basic" : "Premium";

   echo <<<BODY
      <div class="main-container">
         <div class="options-bar">
               <ul>
                  <li><a href="#" onclick="showOption('Option1')">Pending-Orders</a></li>
                  <li><a href="#" onclick="showOption('Option2')">Accepted Orders</a></li>
                  <li><a href="#" onclick="showOption('Option3')">Message</a></li>
                  <li><a href="#" onclick="showOption('Option4')">Reviews</a></li>
                  <li><a href="#" onclick="showOption('Option5')">Subscription</a></li>
               </ul>
         </div>
         <div class="account-info" id="account-info">
            <h2>Welcome, {$chef->getName()}</h2>
            <p><strong>Email:</strong> {$chef->getEmail()}</p>
            <p><strong>Membership Level:</strong> $membershipLevel</p>
            <br>
            <h3>About the Chef</h3>
            <p><strong>Specialities:</strong> {$chef->getSpecialities()}</p>
            <p><strong>Description:</strong> {$chef->getDescription()}</p>
            <p><strong>Education:</strong> {$chef->getEducation()}</p>
            <p><strong>Plates:</strong> <button onclick="location.href = 'chef_view_plates.php';"">View</button></p>
         </div>
      </div>

      <script>
      function showOption(option) {
         // Add logic for each option
         switch (option) {
            case 'Option1':
               window.location.href = 'chef_pending_orders.php';
               break;
            case 'Option2':
               window.location.href = 'chef_accepted_orders.php'; 
               break;
            case 'Option3':
               window.location.href = 'chef_read.php';
               break;
            case 'Option4':
               window.location.href = 'chef_reviews.php';
               break;
            case 'Option5':
               window.location.href = 'chef_upgrade.php';
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