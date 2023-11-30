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
$userID = $_SESSION['userID'];
$chef = retrieveChef($conn, $userID);

// Include the header and body functions
header_USER('chef');
upgrade_body();
footer_USER();

function upgrade_body(){
    $chef = $GLOBALS['chef'];
    $membershipLevel = ($chef->getIsPremium() == 0) ? "Basic" : "Premium";

    echo <<<UPGRADE
        <div>
            <h2>Subscription</h2>
            <p>We are happy that you tried our system and decided to buy it. <strong>BC - Bear Chefs</strong> is in constant development and all of these new fancy features are available for you immediately, without extra charge. We believe in perfection, so we are and will be trying very hard to not dissapoint you!</p>
            <p><strong>BC - Bear Chefs</strong> is available on three differenct subscription plans. Please see the table below and select one package.</p>
            <br>
            <p>Your current account type is $membershipLevel
            <br>
            <button onclick="location.href = 'payment.php';"">Upgrate Here</button></p>
            <br>
            <table>
                <tr>
                    <th colspan='2'>Premium<th>
                    <th>Basic<th>
                <tr>
                <tr>
                    <td><strong>Yearly</strong></td>
                    <td><strong>Monthly</strong></td>
                    <td><strong>Free</strong></td>
                </tr>
                <tr>
                    <td>- Unlimited contacts and services</td>
                    <td>- Unlimited contacts and services</td>
                    <td>- Unlimited contacts and services</td>
                </tr> 
                <tr>
                    <td>- Priority on search result</td>
                    <td>- Priority on search result</td>
                    <td></td>
                </tr>               
            </table>
        </div>        
    UPGRADE;
}
?>



