<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'class/payment_info.php';
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
$chef = retrieveChef($conn, $userID);

// Include the header and body functions
// header_USER('chef');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //If validate_form returns errors, pass them to show_form()
    if($form_errors = validate_payment($conn, $chef)){
        payment_body($form_errors);
    }
} else{
    payment_body();
}
footer_USER();

function validate_payment($conn, $chef){
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
    $premium = $_POST['premium'];

    // Validate the fields
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) ||  !is_numeric($cardNumber) || !is_numeric($expMonth) || !is_numeric($expYear) || !is_numeric($cvv)) {
        $errors[] = "Please fill out correctly the fields";
    } else{        
        $userID = $GLOBALS['userID']; 
        
        $payment = new PaymentInfo($userID, $fullName, $email, $address, $city, $state, $zip, $cardName, $cardNumber, $expMonth, $expYear, $cvv);
        $paymentID = $payment->makePayment($conn, $premium);
        $chef->setChefId($userID);

        // Check if the payment was successful before updating to premium
        if ($paymentID) {
            $chef->updateChefToPremium($conn);
        } else {
            echo '<script type="text/javascript">
                     alert("nao entrooooo");
                     location="chef.php";
                     </script>';
        }

    }
    
    return $errors;
}
function payment_body($errors = array()){
    $combinedText = null;
    if($errors){
        $combinedText = implode("<br> ", $errors);
    }

    echo <<<UPGRADE
    <form action="$_SERVER[PHP_SELF]" method="post">
            <span class="error-msg">$combinedText</span><br>
            <h3>Choose your upgrade</h3>
            <input type="radio" id="yearly" name="premium" value="150" checked="true">
            <label for="html">CA$150.00 / year</label><br>
            <input type="radio" id="monthly" name="premium" value="15">
            <label for="css">CA$15.00 / month </label><br>
            <br>
            <h3>Billing Address</h3>
            <label for="fname">Full Name</label>
            <input type="text" id="fname" name="firstname" placeholder="John M. Doe"> <br>
            
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="john@example.com"><br>
            
            <label for="adr">Address</label>
            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street"><br>
            
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="Burnaby"><br>           
            
            <label for="state">State</label>
            <input type="text" id="state" name="state" placeholder="BC"><br>
            
            <label for="zip">Zip</label>
            <input type="text" id="zip" name="zip" placeholder="XXX XXX"><br><br>
                
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe"><br>
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444"><br>
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="XX"><br>
                <div class="col-50">
                    <label for="expyear">Exp Year</label>
                    <input type="text" id="expyear" name="expyear" placeholder="XXXX">
                </div>
                <div class="col-50">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="XXX">
                </div>
            
            <input type="submit" value="Continue to checkout" class="btn">
        </form>

    UPGRADE;
}
?>



