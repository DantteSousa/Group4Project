<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/message.php';
session_start();
$user_chef = 'chef';
$user_customer = 'customer';

// Retrieve user information from the session
$userID = $_SESSION['userID'];
$order = new Orders();
// if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
//    header_USER($user_chef);
// }else{
//    header_HTML();
// }


if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    $order = retriveOrders($conn, $orderID);
    $customer = retriveCustomer($conn, $order->getCustomerID());

    echo <<<MESSAGEFORM
        <div>
            <h1>Send Message</h1>
            From: You <br>
            To: {$customer->getName()}
            <form method="post" action="$_SERVER[PHP_SELF]">
                <textarea name="message" rows="4" cols="50" placeholder="Type your message here"></textarea>
                <br>
                <input type="submit" value="Send Message">
            </form>
        </div>
    MESSAGEFORM;

    
} elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
    $message = $_POST['message'];
    $today = date("Y-m-d");
    $receiverID = $order->getCustomerID();

    $full_message = new Message($userID, $receiverID, $today, $message);
    $full_message->sendMessage($conn);

    echo "mandoooo";
} else {
    // Redirect or display an error message if 'idfortest' is not set
    header("Location: index.php"); // Redirect to the homepage or another page
    exit();
}

footer_USER();
?>
