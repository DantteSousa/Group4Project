<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'views/helpers_HTML.php';
include 'class/retriveDB.php';

session_start();

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];
$user_chef = 'chef';
$user_customer = 'customer';

head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
    header_USER($user_chef);
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);
}else{
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}
// Include body functions
if (isset($_POST['submit'])) {
    check_update($conn);
} else {
    body_edit_profile($conn);
}
footer_USER();

function body_edit_profile($conn){
    $userID = $GLOBALS['userID'];

    if($GLOBALS['userID'] == 'chef'){
        $user = retrieveChef($conn, $userID);
    }else{
        $user = retriveCustomer($conn, $userID);
    }

    echo <<< PROFILE
    <div class="form-payment">
        <div class="outra-div">
            <form class="form" action="$_SERVER[PHP_SELF]" method="post">
            <h2>Edit Profile</h2>      
            <h3>profile settings</h3>
            <label>First name: </label>
            <input type="text" name="name" value="{$user->getName()}">

            <label>Last name</label>
            <input type="text" name="lastname" value="{$user->getLastName()}">

            <label>Email</label>
            <input type="email" name="email" value="{$user->getEmail()}">

            <label>Password</label>
            <input type="password" name="password" value="{$user->getPassword()}">

            <label>Address</label>
            <input type="text" name="address" value="{$user->getAddress()}">

            <label>Phone</label>
            <input type="number" name="phone" value="{$user->getPhone()}">
            <input type="submit" name="submit" value="save information" class="btn">
        </form>
        <!-- Back button -->
        <button onclick="location.href = 'settings.php';"">Go Back</button>
    </div>
    </div>
    PROFILE;
}

function check_update($conn) {
    $userID = $GLOBALS['userID'];
    if($GLOBALS['userID'] == 'chef'){
        $user = retrieveChef($conn, $userID);
    }else{
        $user = retriveCustomer($conn, $userID);
    }

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
        $name != $user->getName() ||
        $lastname != $user->getLastName() ||
        $email != $user->getEmail() ||
        $newHashedPassword != $user->getPassword() ||
        $address != $user->getAddress() ||
        $phone != $user->getPhone()
    ) {
        // Data has changed, update the database
        $user->updateUserInfo($conn, $userID, $name, $lastname, $email, $newHashedPassword, $address, $phone);
    } else{
        echo '<script type="text/javascript">
            location="edit_profile.php";
            </script>';
    }
}

?>


