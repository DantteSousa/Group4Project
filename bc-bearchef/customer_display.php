<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/plate.php';
include 'class/payment_info.php';

session_start();
$user_customer = 'customer';
$userID = "";
head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);    
   $GLOBALS['userID'] = $_SESSION['userID'];
 }else{
    //header_HTML();
}
$order = new Orders();
$plate = new Plate();
$customer = retriveCustomer($conn, $userID);

order_body($conn, $order, $plate, $customer);
footer_USER();

function order_body($conn, $order, $plate, $customer){
    echo <<<ORDERREVIEW
        <div>
            <h3>Customer Information</h3>
            <strong>Stove top type: </strong>{$customer->getStringStoveTopType()}<br>
            <strong>Number of burners: </strong>{$customer->getNumBurners()} burners<br>
            <strong>Does it have an oven? </strong>{$customer->doesHaveOven()}<br>
            <button onclick="location.href = 'customer_experience.php';"">Edit</button>

            <h3>About the Experience</h3>
            <strong>Event Day: </strong>{$customer->getEventDay()}<br>
            <strong>Time: </strong> {$customer->getStringDayTime()}<br>
            <strong>Number of people</strong> {$customer->getNumOfPeople()} people <br>
            <strong>Restriction: </strong> {$customer->doesHaveRestriction()}<br>        
            <button onclick="location.href = 'customer_information.php';"">Edit</button>   
            
            <!-- Back button --><br>
            <button onclick="location.href = 'customer.php';"">Go Back</button>
        </div>             
        ORDERREVIEW;
}

?>
