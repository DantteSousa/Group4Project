<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

session_start();
$userId = '';
$userType = '';

if (isset($_SESSION['id'])) {
   $GLOBALS['userId'] = $_SESSION['id'];
   $GLOBALS['userType'] = $_SESSION['user_type'];
} else {
   // Redirect to login page or handle unauthorized access
   header("Location: login_form.php");
   exit();
}

header_USER($userType);
body_settings($conn);
footer_USER(); 

function body_settings($conn){
   $userID = $GLOBALS['userId'];
   $chef = retrieveChef($conn, $userID);
 
    echo <<<BODY
      <div class="container">
         <div class="content">
            <h3>hi, <span>chef</span></h3>
            <h1>welcome <span>{$chef->getName()}</span></h1>
            <p>This is your user page</p>
            <p>You can edit your profile and your plates here!!</p>
            <a href="chef_edit_profile.php" class="btn">Edit Profile</a>
            <a href="chef_about.php" class="btn">Edit About Chef</a>
            <a href="chef_add_plates.php" class="btn">Add Plates</a>
            <a href="chef_view_plates.php" class="btn">View Plates</a>
         </div>
      </div>
    BODY;
 }
?>