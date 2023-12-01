<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include 'views/helpers_HTML.php';
include 'class/retriveDB.php';


session_start();
$user_type = 'customer';
head_HTML();
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];

// Include the header and body functions
head_HTML();
header_USER('customer');
customer_top();
retriveCustomerReviews($conn,$userID);
customer_Bottom();
footer_USER();
?>




