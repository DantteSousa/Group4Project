<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include "views/helpers_HTML.php";

session_start();
// Check if the user is logged in as a chef
$user_type = 'chef';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page to handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];
$chef = retrieveChef($conn, $userID);

head_HTML();
header_USER('chef');
if (isset($_POST['submit'])) {
    check_update_about($conn);
} else {
    body_edit_profile();
}
footer_USER();

function body_edit_profile(){
    $chef = $GLOBALS['chef'];

    echo <<< PROFILE
    <div class="form-payment">
    <div class="outra-div">
    <form class="form" action="$_SERVER[PHP_SELF]" method="post">
            <h2>Edit Profile</h2>      
                <h3>profile settings</h3>
                <div><label>Specialities:</label><br> <textarea name="specialities" rows="4" cols="50">{$chef->getSpecialities()}</textarea></div>
                <div><label>Description:</label><br> <textarea name="description" rows="4" cols="50">{$chef->getDescription()}</textarea></div>
                <div><label>Education:</label><br> <textarea name="education" rows="4" cols="50">{$chef->getEducation()}</textarea></div>
                <input type="submit" name="submit" value="save information">
            </form>
            <button>VIEW PLATES</button> <br>
            <button onclick="location.href = 'settings.php';"">Go Back</button>
        </div>    
    PROFILE;
}

function check_update_about($conn) {
    $userID = $GLOBALS['userID'];
    $chef = $GLOBALS['chef'];

    // Retrieve form values
    $specialities = $_POST['specialities'];
    $description = $_POST['description'];
    $education = $_POST['education'];
   
    // Check if any data has changed
    if (
        $specialities != $chef->getSpecialities() ||
        $description != $chef->getDescription() ||
        $education != $chef->getEducation()
    ) {
        // Data has changed, update the database
        $chef->updateChefInfo($conn, $userID, $specialities, $description, $education);
    } else{
        echo '<script type="text/javascript">
            location="chef_about.php";
            </script>';
    }
}
?>


