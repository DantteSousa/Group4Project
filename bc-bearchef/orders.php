<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/plate.php';
include 'class/payment_info.php';

session_start();
$user_chef = 'chef';
$user_customer = 'customer';
$userID = "";

head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);    
    $GLOBALS['userID'] = $_SESSION['userID'];
}else{
    header_HTML();
    $GLOBALS['userID'] = $_SESSION['userID'];
    echo '<script type="text/javascript">
    alert("Please be logged on a customer account!");
    location="settings.php";
    </script>';
}

$order = new Orders();
$plate = new Plate();
$customer = retriveCustomer($conn, $userID);

order_body($conn, $order, $plate, $customer);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($form_errors = validate_payment_form($conn, $order, $plate, $customer)){
        show_payment_form($conn, $form_errors);
    }
} else{
    show_payment_form($conn);
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

        $order->setChefID($plate->getChefID());
        $order->setCustomerID($GLOBALS['userID']);
        $order->setDateExperience($customer->getEventDay());
        $order->setStatus(0);
        $price = $plate->calculateUnitPlatePrice($customer->getNumOfPeople());
        $total = $order->calculateTotal($customer->getNumOfPeople(),$price);
        $order->setTotal($total);
        $order->makeOrder($conn);

        echo <<<ORDERREVIEW
            <div class="order-review">
                <h1>Order Review</h1>
                <p>Please, check all information before making the reservation</p>
        
                <h2>Chef</h2>
                <h3>About the meal</h3>
                <ul>
                    <li><strong>Plate name</strong> {$plate->getPlateName()} </li>
                    <li><strong>Cusine Type: </strong> {$plate->getStringCusineType()}</li>
                    <li><strong>Meal Range Type: </strong> {$plate->getStringMealRange()}</li>
                    <li> <strong>Starter Menu: </strong> {$plate->getStarterMenu()}</li>
                    <li><strong>First Course: </strong>{$plate->getFirstCourse()}</li>
                    <li><strong>Main Course: </strong>{$plate->getMainCourse()}</li>
                    <li><strong>Dessert:</strong>{$plate->getDessert()}</li>
                </ul>
    
                <h2>Customer Information</h2>
                <h3>Information about the place</h3>
                <ul>
                    <li><strong>Address: </strong>{$customer->getAddress()}</li>
                    <li><strong>Phone: </strong>{$customer->getPhone()}</li>
                    <li><strong>Stove top type: </strong>{$customer->getStringStoveTopType()}</li>
                    <li><strong>Number of burners: </strong>{$customer->getNumBurners()} burners</li>
                    <li><strong>Does it have an oven? </strong>{$customer->doesHaveOven()}</li>
                </ul>
                <button onclick="location.href = 'customer_experience.php';"">Edit</button>

                <h3>About the Experience</h3>
                <ul>
                    <li><strong>Event Day: </strong>{$customer->getEventDay()}</li>
                    <li><strong>Time: </strong> {$customer->getStringDayTime()}</li>
                    <li><strong>Price per person:</strong> $ {$price}</li>
                    <li><strong>Number of people</strong> {$customer->getNumOfPeople()} people </li>
                    <li><strong>Restriction: </strong> {$customer->doesHaveRestriction()}</li>
                    <li><strong>Extra information: </strong> {$customer->getExtraInfo()}</li>
                </ul>       
                <button onclick="location.href = 'customer_information.php';"">Edit</button>
        
                <h3> Total: CAD$ {$total}.00</h3>   
            </div>         
        ORDERREVIEW;
    } 
}

function show_payment_form($conn, $errors = array()) {
    $combinedText = null;
    if($errors){
        $combinedText = implode("<br> ", $errors);
    }

    $user = $GLOBALS['userID'];
    $customer = retriveCustomer($conn, $user);
    echo <<<PAYFORM
        <div class="form-payment">
            <div class="outra-div">
            <form class="form" action="$_SERVER[PHP_SELF]" method="post">
                <h3>Billing Address</h3>
                <span class="error-msg">$combinedText</span><br>
                <label for="fname">Full Name</label>
                <input type="text" id="fname" name="firstname" placeholder="John M. Doe" required value="{$customer->getName()} {$customer->getLastName()}"> <br>
                
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com" required value="{$customer->getEmail()}"><br>
                
                <label for="adr">Address</label>
                <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" required value="{$customer->getAddress()}"><br>
                
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Burnaby" required><br>           
                
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="BC" required><br>
                
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="XXX XXX" required><br><br>
                    
                <h3>Payment</h3>        
                <label for="cname">Name on Card</label>
                <input type="text" id="cname" name="cardname" placeholder="John More Doe" required value="{$customer->getName()} {$customer->getLastName()}"><br>
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
        </div>
        </div>
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
        $order->updatePayment($conn, $payment->makePayment($conn, $total));
    }
    
    return $errors;
}


footer_USER();
?>
