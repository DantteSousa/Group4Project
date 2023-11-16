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
// show_settings_chef_profile($conn);
body_settings($conn);
// show_settings_chef_info($conn);
footer_USER(); 

function show_settings_chef_profile($chef){
    // $userID = $GLOBALS['userId'];
    // $chef = retrieveChef($conn, $userID);

    if($chef->getIsPremium() == 0){
        $membershipLevel = "Basic" ;
     }else{
        $membershipLevel = "Premium";
     }

    echo <<<FORM
    <div class="form-container">
        <form action="$_SERVER[PHP_SELF]" method="post">
            <h3>profile settings</h3>
            <div><label>First name</label><input type="text" name="name" placeholder="{$chef->getName()}"></div>
            <div><label>Last name</label><input type="text" name="lastname" placeholder="{$chef->getLastName()}"></div>
            <div><label>Email</label><input type="email" name="email" placeholder="{$chef->getEmail()}"></div>
            <div><label>Password</label><input type="password" name="passwod" placeholder="**********"></div>
            <div><label>Address</label><input type="text" name="address" placeholder="{$chef->getAddress()}"></div>
            <div><label>Phone</label><input type="number" name="phone" placeholder="{$chef->getPhone()}"></div>
            <input type="submit" name="submit" value="save information" class="form-btn">
            <h3>About the Chef</h3>
            <div><label>Membership Level</label><input type="submit" name="submit" value="${membershipLevel}" class="form-btn"></div>
            <div><label>Specialities</label><input type="text" name="name" required placeholder="{$chef->getSpecialities()}"></div>
            <div><label>Description</label><input type="text" name="lastname" required placeholder="{$chef->getDescription()}"></div>
            <div><label>Education</label><input type="email" name="email" required placeholder="{$chef->getEducation()}"></div>
            <div><label>Plates</label><input type="submit" name="submit" value="Add Plates" class="form-btn"></div>
            <input type="submit" name="submit" value="save information" class="form-btn">
        </form>

    </div>
    FORM;
}

function show_settings_chef_info($conn){

    $userID = $GLOBALS['userId'];
    $chef = retrieveChef($conn, $userID);

    if($chef->getIsPremium() == 0){
        $membershipLevel = "Basic" ;
    }else{
        $membershipLevel = "Premium";
    }
    echo <<<FORM
    <div>
        <form action="$_SERVER[PHP_SELF]" method="post">
            <h3>About the Chef</h3>
            <div><label>Membership Level:</label><input type="submit" name="submit" value="${membershipLevel}" class="form-btn"></div>
            <div><label>Specialities:</label><input type="text" name="name" required placeholder="{$chef->getSpecialities()}"></div>
            <div><label>Description:</label><input type="text" name="lastname" required placeholder="{$chef->getDescription()}"></div>
            <div><label>Education:</label><input type="email" name="email" required placeholder="{$chef->getEducation()}"></div>
            <div><label>Plates:</label><input type="submit" name="submit" value="Add Plates" class="form-btn"></div>
            <input type="submit" name="submit" value="save information" class="form-btn">
        </form>

    </div>
    FORM;
}

function body_settings($conn){
    $userID = $GLOBALS['userId'];
    $chef = retrieveChef($conn, $userID);
 
    if($chef->getIsPremium() == 0){
       $membershipLevel = "Basic" ;
    }else{
       $membershipLevel = "Premium";
    }
 
    echo <<<BODY
       <div class="main-container">
          <div class="options-bar">
                <ul>
                   <li><a href="#" onclick="showOption('Option1')">Edit Profile</a></li>
                   <li><a href="#" onclick="showOption('Option2')">Edit About the Chef</a></li>
                   <li><a href="#" onclick="showOption('Option3')">Edit Plates</a></li>
                </ul>
          </div>
          <div class="account-info" id="account-info">
            <h2>Welcome, {$chef->getName()}</h2>
            <p>Click on <h3>Edit Profile</h3> to edit your profile<p>
            <p>Click on <h3>Edit About the Chef</h3> to edit what your customer should know about you<p>
            <p>Click on <h3>Add Plates</h3> to add new plates on the menu<p>
          </div>
       </div>
 
       <script>
          function showOption(option) {
                var accountInfoContainer = document.getElementById('account-info');
                var content = '';
 
                // Add logic for each option
                switch (option) {
                   case 'Option1':
                        show_settings_chef_info($conn);
                        break;
                   case 'Option2':
                      content = 'Specific content for Accepted Orders';
                      break;
                   case 'Option3':
                      content = 'Specific content for Schedule.';
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