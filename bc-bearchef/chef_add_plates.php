<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'class/plate.php';
include "views/helpers_HTML.php";

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

// Include the header and body functions
head_HTML();
header_USER($user_type);
if (isset($_POST['submit'])) {
    check_update_plate($conn);
} else {
    add_plate_form();
}

footer_USER();

function add_plate_form(){
    echo <<< PROFILE
    <div class="form-payment">
        <div class="outra-div">
            <form class="form action="$_SERVER[PHP_SELF]" method="post">
                <h2>Plates</h2>      
                <h3>Add New Plate</h3>
                    <label>Name:</label>
                    <input type="text" name="plateName" placeholder="Plate name" required>

                    <label for="mealRangeType">Meal Range Type:</label>
                    <select name="mealRangeType" id="mealRangeType" required>
                        <option value="0">Basic ($190 - $230 per person)</option>
                        <option value="1">Indulge ($230 - $260 per person)</option>
                        <option value="2">Exclusive ($260 - $330 per person)</option>
                    </select>

                    <label for="cusineType">Cusine Type:</label>
                    <select name="cusineType" id="cusineType" required>
                        <option value="0">Mediterranean</option>
                        <option value="1">Italian</option>
                        <option value="2">French</option>
                        <option value="3">Asian</option>
                        <option value="4">Latin American</option>
                        <option value="5">Other</option>
                    </select>

                    <label>Starter Menu:</label>
                    <textarea name="starterMenu" rows="4" cols="50" required placeholder="Separete the first course options with a coma"></textarea>
             
                    <label>First Course:</label>
                    <textarea name="firstCourse" rows="4" cols="50" required placeholder="Separete the first course options with a coma"></textarea>
              
                    <label>Main Course:</label>
                    <textarea name="mainCourse" rows="4" cols="50" required placeholder="Separete the main course options with a coma"></textarea>
             
                    <label>Dessert:</label>
                    <textarea name="dessert" rows="4" cols="50" required placeholder="Separete the dessert options with a coma"></textarea>
              
                <input class="btn"type="submit" name="submit" value="save information">
            </form>
            <div class="chef-about">
                <button class="btn-chef" onclick="location.href = 'settings.php';"">Go back</button> <br>
                <button class="btn-chef" onclick="location.href = 'chef_view_plates.php';"">View Plates</button>
            </div>
        </div>
    </div>
    PROFILE;
}

function check_update_plate($conn){
    // Retrieve form values
    $plateName = $_POST['plateName'];
    $mealRangeType = $_POST['mealRangeType'];
    $cusineType = $_POST['cusineType'];
    $firstCourse = $_POST['firstCourse']; 
    $starterMenu = $_POST['starterMenu'];
    $mainCourse = $_POST['mainCourse'];
    $dessert = $_POST['dessert'];
    $userID = $GLOBALS['userID'];

    $plate = new Plate();
    $plate->setChefID($userID);
    $plate->setPlateName($plateName);
    $plate->setMealRangeType((int)$mealRangeType);
    $plate->setCusineType((int)$cusineType);
    $plate->setStarterMenu($starterMenu);
    $plate->setFirstCourse($firstCourse);
    $plate->setMainCourse($mainCourse);
    $plate->setDessert($dessert);
     
    $plate->addToDatabase($conn);
}


?>


