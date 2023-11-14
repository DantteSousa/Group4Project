<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/user_class.php';

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
show_settings_chef_profile();
show_settings_chef_info();
footer_USER(); 

function show_settings_chef_profile($errors = array()){
    $combinedText = null;
    if($errors){
        $combinedText = implode(" ", $errors);
    }     

    echo <<<FORM
    <div>
        <form action="$_SERVER[PHP_SELF]" method="post">
            <h3>profile settings</h3>
            <span class="error-msg">$combinedText</span>
            <div><label>First name:</label><input type="text" name="name" required placeholder="enter your name"></div>
            <div><label>Last name:</label><input type="text" name="lastname" required placeholder="enter your name"></div>
            <div><label>Email:</label><input type="email" name="email" required placeholder="enter your email"></div>
            <div><label>Password:</label><input type="password" name="password" required placeholder="enter your password"></div>
            <div><label>Address:</label><input type="text" name="address" required placeholder="enter your name"></div>
            <div><label>Phone:</label><input type="number" name="phone" required placeholder="enter your name"></div>
            <input type="submit" name="submit" value="save information" class="form-btn">
        </form>

    </div>
    FORM;
}

function show_settings_chef_info($errors = array()){
    $combinedText = null;
    if($errors){
        $combinedText = implode(" ", $errors);
    } 
    echo <<<FORM
    <div>
        <form action="$_SERVER[PHP_SELF]" method="post">
            <h3>About the Chef</h3>
            <span class="error-msg">$combinedText</span>
            <div><label>Membership Level:</label><input type="text" name="address" required placeholder="enter your name"></div>
            <div><label>Specialities:</label><input type="text" name="name" required placeholder="enter your name"></div>
            <div><label>Description:</label><input type="text" name="lastname" required placeholder="enter your name"></div>
            <div><label>Education:</label><input type="email" name="email" required placeholder="enter your email"></div>
            <div><label>Plates:</label><input type="password" name="password" required placeholder="enter your password"></div>
            <input type="submit" name="submit" value="save information" class="form-btn">
        </form>

    </div>
    FORM;
}
?>