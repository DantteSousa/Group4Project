<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

// Start the session
session_start();

// Check if the user is logged in as a customer
$user_type = 'customer';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];

// Include the header and body functions
header_USER("customer");
if (isset($_POST['submit'])) {
    check_update_experience($conn);
} else {
    add_experience();
}

footer_USER();

function add_experience(){
    echo <<< PROFILE
        <div>
            <h2>Tell us about how do you want your experience</h2>      
            <form action="$_SERVER[PHP_SELF]" method="post">         
                <div>
                    <label for="stoveTopType">Our stove top is...</label><br>
                    <select name="stoveTopType" id="stoveTopType" required>
                        <option value="0">Eletric</option>
                        <option value="1">Induction</option>
                        <option value="2">Gas</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="numBurners">Our kitchen has...</label><br>
                    <select name="numBurners" id="numBurners" required>
                        <option value="2">2 burners</option>
                        <option value="3">3 burners</option>
                        <option value="4">4 burners</option>
                        <option value="5">5 burners</option>                        
                    </select>
                </div>
                <br>
                <div>
                    <label for="oven">We have an oven...</label><br>
                    <select name="oven" id="oven" required>
                        <option value="0">No</option>                      
                        <option value="1">Yes</option>
                    </select>
                </div>
                <br>                
                <input type="submit" name="submit" value="save information">
            </form>
     
            <!-- Back button -->
            <button onclick="location.href = 'settings.php';"">Go Back</button>
        </div>
    PROFILE;
}

function check_update_experience($conn){
    // Retrieve form values

    $stoveTopType = $_POST['stoveTopType'];
    $numBurners = $_POST['numBurners'];
    $oven = $_POST['oven'];
    $userID = $GLOBALS['userID'];
    
    echo "$stoveTopType $userID";
    $customer = retriveCustomer($conn,$userID);

    $customer->setCustomerID($userID);
    $customer->setStoveTopType($stoveTopType);
    $customer->setNumBurners($numBurners);
    $customer->setOven($oven);
    
    $customer->addInformationAboutCustomer($conn);
}



?>