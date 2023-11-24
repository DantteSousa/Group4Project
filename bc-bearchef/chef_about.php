<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

// Start the session
session_start();

// Check if the user is logged in as a chef
$user_type = 'chef';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userId = $_SESSION['id'];

// Include the header and body functions
header_USER($user_type);
if (isset($_POST['submit'])) {
    check_update_about($conn);
} else {
    body_edit_profile($conn);
}
footer_USER();

function body_edit_profile($conn){
    $userID = $GLOBALS['userId'];
    $chef = retrieveChef($conn, $userID);

    echo <<< PROFILE
        <div>
            <h2>Edit Profile</h2>      
            <form action="$_SERVER[PHP_SELF]" method="post">
                <h3>profile settings</h3>
                <div><label>Specialities:</label><br> <textarea name="specialities" rows="4" cols="50">{$chef->getSpecialities()}</textarea></div>
                <div><label>Description:</label><br> <textarea name="description" rows="4" cols="50">{$chef->getDescription()}</textarea></div>
                <div><label>Education:</label><br> <textarea name="education" rows="4" cols="50">{$chef->getEducation()}</textarea></div>
                <input type="submit" name="submit" value="save information">
            </form>
            <button>VIEW PLATES</button> <br>
            <!-- Back button -->
            <button onclick="location.href = 'settings.php';"">Go Back</button>
        </div>    
    PROFILE;
}


function check_update_about($conn) {
    $userID = $GLOBALS['userId'];
    $chef = retrieveChef($conn, $userID);

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
        updateChefInfo($conn, $userID, $specialities, $description, $education);
    } else{
        echo '<script type="text/javascript">
            location="chef_about.php";
            </script>';
    }
}

?>


