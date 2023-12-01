<?php
include "views/helpers_HTML.php";
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

session_start();
$userID = '';
$userType = '';

if (isset($_SESSION['userID'])) {
   $GLOBALS['userID'] = $_SESSION['userID'];
   $GLOBALS['userType'] = $_SESSION['user_type'];
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

head_HTML();
header_USER($userType);
if($userType == 'chef'){
   body_settings_chef($conn);
} else {
   body_settings_customer($conn);
}
footer_USER(); 

function body_settings_chef($conn){
   $userID = $GLOBALS['userID'];
   $chef = retrieveChef($conn, $userID);
 
   echo <<<BODY
      <div class="container">
         <div class="content">
            <h3>hi, <span>chef</span></h3>
            <h1>welcome <span>{$chef->getName()}</span></h1>
            <p>This is your user page</p>
            <p>You can edit your profile and your plates here!!</p>
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="chef_about.php" class="btn">Edit About Chef</a>
            <a href="chef_add_plates.php" class="btn">Add Plates</a>
            <a href="chef_view_plates.php" class="btn">View Plates</a>
         </div>
      </div>
   BODY;
}

function body_settings_customer($conn){
   $userID = $GLOBALS['userID'];
   $customer = retriveCustomer($conn, $userID);
 
   echo <<<BODY
      <div class="container">
         <div class="content">
            <h3>hi, <span>customer</span></h3>
            <h1>welcome <span>{$customer->getName()}</span></h1>
            <p>This is your user page</p>
            <p>You can edit your profile and your experience here!!</p>
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="customer_information.php" class="btn">Edit Information</a>
            <a href="customer_experience.php" class="btn">Edit Experience</a>
         </div>
      </div>
   BODY;
}
?>