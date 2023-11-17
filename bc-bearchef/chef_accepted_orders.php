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
header_USER('chef');
footer_USER();
?>

<!-- Additional HTML content for pending_orders.php if needed -->
<div class="content-container">
    <h2>Pending Orders</h2>
    <p>This is the content for pending orders. You can customize this page based on your requirements.</p>
    <!-- Add specific content for pending orders here -->

    <!-- Back button -->
    <button onclick="goBack()">Go Back</button>
</div>

<script>
    function goBack() {
        // Use the browser's history to go back
        window.history.back();
    }
</script>
