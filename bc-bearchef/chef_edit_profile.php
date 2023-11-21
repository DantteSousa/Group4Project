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
    check_update($conn);
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
                <div><label>First name: </label><input type="text" name="name" value="{$chef->getName()}"></div>
                <div><label>Last name</label><input type="text" name="lastname" value="{$chef->getLastName()}"></div>
                <div><label>Email</label><input type="email" name="email" value="{$chef->getEmail()}"></div>
                <div><label>Password</label><input type="password" name="password" value="{$chef->getPassword()}"></div>
                <div><label>Address</label><input type="text" name="address" value="{$chef->getAddress()}"></div>
                <div><label>Phone</label><input type="number" name="phone" value="{$chef->getPhone()}"></div>
                <input type="submit" name="submit" value="save information" class="btn">
            </form>
            <!-- Back button -->
            <button onclick="goBack()">Go Back</button>
        </div>
        
        <script>
            function goBack() {
                // Use the browser's history to go back
                window.history.back();
            }
        </script>
    PROFILE;
}

function check_update($conn) {
    $userID = $GLOBALS['userId'];
    $chef = retrieveChef($conn, $userID);

    // Retrieve form values
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Check if any data has changed
    if (
        $name != $chef->getName() ||
        $lastname != $chef->getLastName() ||
        $email != $chef->getEmail() ||
        $newHashedPassword != $chef->getPassword() ||
        $address != $chef->getAddress() ||
        $phone != $chef->getPhone()
    ) {
        // Data has changed, update the database
        updateUserInfo($conn, $userID, $name, $lastname, $email, $newHashedPassword, $address, $phone);
    } else{
        echo <<<GOBACK
            <div><h3> No changes made to the profile. 2</h3> <br>
        GOBACK;
    }
}

?>


