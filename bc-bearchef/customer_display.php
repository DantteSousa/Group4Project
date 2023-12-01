<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/plate.php';
include 'class/payment_info.php';

session_start();
$userID = "";
head_HTML();
$user_type = 'customer';

if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

head_HTML();
header_USER("customer");    
$GLOBALS['userID'] = $_SESSION['userID'];
$order = new Orders();
$plate = new Plate();
$customer = retriveCustomer($conn, $userID);
customer_top();
order_body($conn, $order, $plate, $customer);
customer_Bottom();
footer_USER();

function order_body($conn, $order, $plate, $customer){
    echo <<<ORDERREVIEW
        <div>
            <h3>Customer Information</h3>
            <strong>Stove top type: </strong>{$customer->getStringStoveTopType()}<br>
            <strong>Number of burners: </strong>{$customer->getNumBurners()} burners<br>
            <strong>Does it have an oven? </strong>{$customer->doesHaveOven()}<br>
            <button class="btn-profile" onclick="location.href = 'customer_experience.php';"">Edit</button>

            <h3>About the Experience</h3>
            <strong>Event Day: </strong>{$customer->getEventDay()}<br>
            <strong>Time: </strong> {$customer->getStringDayTime()}<br>
            <strong>Number of people</strong> {$customer->getNumOfPeople()} people <br>
            <strong>Restriction: </strong> {$customer->doesHaveRestriction()}<br>        
            <strong>Extra: </strong> {$customer->getExtraInfo()}<br>        
            <button class="btn-profile" onclick="location.href = 'customer_information.php';"">Edit</button>         
        </div>             
        ORDERREVIEW;
}

?>
