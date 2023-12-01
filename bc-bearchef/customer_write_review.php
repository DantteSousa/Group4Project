<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/message.php';
session_start();
$user_customer = 'customer';

// Retrieve user information from the session
$userID = $_SESSION['userID'];
$order = new Orders();

if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}
head_HTML();
header_USER('customer');
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    $order = retriveOrders($conn, $orderID);
    $chef = retrieveChef($conn, $order->getChefID());

    echo <<<REVIEWFORM
        <div class="form-review">
            <form method="post" action="$_SERVER[PHP_SELF]">
                <h1>Send your review about: {$chef->getName()}</h1>
                <label for="nameCustomer">Name</label>
                <input type="text" id="nameCustomer" name="nameCustomer" required placeholder="Customer name"><br>                
                <input type="checkbox" id="anonymus" name="anonymus">
                <label for="anonymus"> Anonymus?</label><br>
                <label for="rating"> Rate your chef: </label>
                <select name="rating" id="rating" required>
                    <option value="0">0 stars</option>
                    <option value="1">1 stars</option>
                    <option value="2">2 stars</option>
                    <option value="3">3 stars</option>                        
                    <option value="4">4 stars</option>                        
                    <option value="5">5 stars</option>                        
                </select><br>
                <input type="hidden" name="orderID" value="$orderID">
                <textarea name="reviewDescription" rows="4" cols="50" placeholder="Type your review here"></textarea>
                <br>
                <input type="submit" value="Send Message">
            </form>
        </div>
        REVIEWFORM;


} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nameCustomer = isset($_POST["nameCustomer"]) ? $_POST["nameCustomer"] : '';
    $anonymus = isset($_POST['anonymus']) ? 1 : 0;
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $orderID = isset($_POST['orderID']) ? $_POST['orderID'] : '';
    $reviewDescription = isset($_POST['reviewDescription']) ? $_POST['reviewDescription'] : '';
    $today = date("Y-m-d");
    $order = retriveOrders($conn, $orderID);
    $chefID = $order->getChefID();
    $customerID = $userID;
  
    sendReview($conn, $orderID, $customerID, $chefID, $today, $nameCustomer, $reviewDescription, $rating, $anonymus);
}
 else {
    // Redirect or display an error message if 'idfortest' is not set
    header("Location: index.php"); // Redirect to the homepage or another page
    exit();
}

footer_USER();
?>