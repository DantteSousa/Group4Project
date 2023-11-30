<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/plate.php';
include 'class/order_class.php';
include 'class/payment_info.php';

session_start();
$user_chef = 'chef';
$user_customer = 'customer';
$userID = "";

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
   //header_USER($user_chef);
   $GLOBALS['userID'] = $_SESSION['userID'];
    echo '<script type="text/javascript">
    alert("Please use an customer account!");
    location="settings.php";
    </script>';

 } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    //header_USER($user_customer);    
   $GLOBALS['userID'] = $_SESSION['userID'];
 }else{
    //header_HTML();
}
$order = new Orders();
$plate = new Plate();
$customer = retriveCustomer($conn, $userID);

echo $GLOBALS['userID'];
order_body($conn, $order, $plate, $customer);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //If validate_form returns errors, pass them to show_form()
    if($form_errors = validate_payment_form($conn, $order, $plate, $customer)){
        show_payment_form($form_errors);
    }
} else{
    show_payment_form();
}

function order_body($conn, $order, $plate, $customer){
    if (isset($_GET['id'])) {
        $plateID = $_GET['id'];
        $query = "SELECT * FROM plate WHERE plateID = '$plateID'";
        $result = $conn->query($query);   
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $plate->setPlateID($row["plateID"]);
            $plate->setChefID($row["chefID"]);
            $plate->setPlateName($row["plateName"]);
            $plate->setMealRangeType($row["mealRangeType"]);
            $plate->setCusineType($row["cusineType"]);
            $plate->setStarterMenu($row["starterMenu"]);
            $plate->setFirstCourse($row["firstCourse"]);
            $plate->setMainCourse($row["mainCourse"]);
            $plate->setDessert($row["dessert"]);

        } 
        
        // $userID = $GLOBALS['userID'];
        //In case the user is not logged, it will redirect to the login form page
        if($GLOBALS['userID'] == '') {
            header("Location: login_form.php");
            exit();
        } 

        $order->setChefID($plate->getChefID());
        $order->setCustomerID($GLOBALS['userID']);
        $order->setDateExperience($customer->getEventDay());
        $order->setStatus(0);
        $price = $plate->calculateUnitPlatePrice($customer->getNumOfPeople());
        $total = $order->calculateTotal($customer->getNumOfPeople(),$price);
        $order->setTotal($total);
        $order->makeOrder($conn);

        echo <<<ORDERREVIEW
            <h2>Order Review</h2>
            Please, check the information before purchasing
    
            <strong>Chef: </strong>
            <h3>About the meal</h3>
            <strong>Plate name</strong> {$plate->getPlateName()} <br>
            <strong>Cusine Type: </strong> {$plate->getStringCusineType()}<br>
            <strong>Meal Range Type: </strong> {$plate->getStringMealRange()}<br>
            <strong>Starter Menu: </strong> {$plate->getStarterMenu()}<br>
            <strong>First Course: </strong>{$plate->getFirstCourse()}<br>
            <strong>Main Course: </strong>{$plate->getMainCourse()}<br>
            <strong>Dessert:</strong>{$plate->getDessert()}<br>
            <br>
    
            <h3>Customer Information</h3>
            <strong>Stove top type: </strong>{$customer->getStringStoveTopType()}<br>
            <strong>Number of burners: </strong>{$customer->getNumBurners()} burners<br>
            <strong>Does it have an oven? </strong>{$customer->doesHaveOven()}<br>
            <button onclick="location.href = 'customer_experience.php';"">Edit</button>
    
            <h3>About the Experience</h3>
            <strong>Event Day: </strong>{$customer->getEventDay()}<br>
            <strong>Time: </strong> {$customer->getStringDayTime()}<br>
            <strong>Price per person:</strong> $ {$price}<br>
            <strong>Number of people</strong> {$customer->getNumOfPeople()} people <br>
            <strong>Restriction: </strong> {$customer->doesHaveRestriction()}<br>        
            <button onclick="location.href = 'customer_information.php';"">Edit</button>
    
            <h4> Total: $ {$total}</h4>            
        ORDERREVIEW;
    } 
}

function show_payment_form($errors = array()) {
    $combinedText = null;
    if($errors){
        $combinedText = implode("<br> ", $errors);
    }

    echo <<<PAYFORM
        <form action="$_SERVER[PHP_SELF]" method="post">
        <h3>Billing Address</h3>
        <span class="error-msg">$combinedText</span><br>
        <label for="fname">Full Name</label>
        <input type="text" id="fname" name="firstname" placeholder="John M. Doe" required> <br>
        
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="john@example.com" required><br>
        
        <label for="adr">Address</label>
        <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required><br>
        
        <label for="city">City</label>
        <input type="text" id="city" name="city" placeholder="Burnaby" required><br>           
        
        <label for="state">State</label>
        <input type="text" id="state" name="state" placeholder="BC" required><br>
        
        <label for="zip">Zip</label>
        <input type="text" id="zip" name="zip" placeholder="XXX XXX" required><br><br>
            
        <h3>Payment</h3>
        <label for="fname">Accepted Cards</label>
        <div class="icon-container">
            <i class="fa fa-cc-visa" style="color:navy;"></i>
            <i class="fa fa-cc-amex" style="color:blue;"></i>
            <i class="fa fa-cc-mastercard" style="color:red;"></i>
            <i class="fa fa-cc-discover" style="color:orange;"></i>
        </div>
        
        <label for="cname">Name on Card</label>
        <input type="text" id="cname" name="cardname" placeholder="John More Doe" required><br>
        <label for="ccnum">Credit card number</label>
        <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444" required><br>
        <label for="expmonth">Exp Month</label>
        <input type="text" id="expmonth" name="expmonth" placeholder="XX" required><br>
            <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="XXXX" required>
            </div>
            <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="XXX" required>
            </div>            
        <input type="submit" value="Continue to checkout" class="btn">
    </form>
    PAYFORM;
}

function validate_payment_form($conn, $order, $plate, $customer){
    $errors = array();

    // Validate other form fields as needed
    $fullName = $_POST['firstname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardName = $_POST['cardname'];
    $cardNumber = $_POST['cardnumber'];
    $expMonth = $_POST['expmonth'];
    $expYear = $_POST['expyear'];
    $cvv = $_POST['cvv'];

    // Validate the fields
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) ||  !is_numeric($cardNumber) || !is_numeric($expMonth) || !is_numeric($expYear) || !is_numeric($cvv)) {
        $errors[] = "Please fill out correctly the fields";
    } else{
        $order->makeOrder($conn);
        $userID = $GLOBALS['userID'];
        $total = $order->getTotal();
        $payment = new PaymentInfo($userID, $fullName, $email, $address, $city, $state, $zip, $cardName, $cardNumber, $expMonth, $expYear, $cvv);
        $paymentID = $payment->makePayment($conn, $total);
        $order->updatePayment($conn, $paymentID);
    }
    
    return $errors;
}


footer_USER();
?>
