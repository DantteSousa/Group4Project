<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/message.php';
session_start();

// Retrieve user information from the session
$userID = $_SESSION['userID'];
$order = new Orders();
head_HTML();

$user_type = 'chef';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

head_HTML();
header_USER('chef');

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    $order = retriveOrders($conn, $orderID);
    $customer = retriveCustomer($conn, $order->getCustomerID());

    echo <<<MESSAGEFORM
    <div class="form-container">
        <form method="post" action="$_SERVER[PHP_SELF]">
            <h1>Send Message</h1>
            <p>From: You <br></p>
            <p>To: {$customer->getName()}</p>
            <input type="hidden" name="orderID" value="$orderID">
            <textarea name="message" rows="4" cols="50" placeholder="Type your message here"></textarea>
            <br>
            <input type="submit" value="Send Message">
            </form>
        </div>
    MESSAGEFORM;

} elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
    $orderID = $_POST["orderID"];
    $message = $_POST['message'];
    $today = date("Y-m-d");
    $order = retriveOrders($conn, $orderID);
    $receiverID = $order->getCustomerID();    

    $full_message = new Message($userID, $receiverID, $today, $message);
    $full_message->setOrderID($order->getOrderID());
    $full_message->sendMessage($conn);

} else {
    header("Location: index.php"); // Redirect to the homepage or another page
    exit();
}
footer_USER();
?>