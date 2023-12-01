<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/message.php';
session_start();

$user_customer = 'customer';
$userID = $_SESSION['userID'];
$order = new Orders();

head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer){
   header_USER('customer');
}else{
   header_HTML();
}

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    $order = retriveOrders($conn, $orderID);
    $chef = retrieveChef($conn, $order->getChefID());

    echo <<<MESSAGEFORM
        <div class="form-container">
            <form method="post" action="$_SERVER[PHP_SELF]">
                <h1>Send Message</h1>
                <p>From: You</p>
                <p>To: {$chef->getName()}</p>
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
    $receiverID = $order->getChefID();    

    $full_message = new Message($userID, $receiverID, $today, $message);
    $full_message->setOrderID($order->getOrderID());
    $full_message->sendMessageToChef($conn);

} else {    
    header("Location: index.php"); 
    exit();
}

footer_USER();
?>