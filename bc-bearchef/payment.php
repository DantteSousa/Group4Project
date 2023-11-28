<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

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
$userID = $_SESSION['id'];
$chef = retrieveChef($conn, $userID);

// Include the header and body functions
header_USER('chef');
payment_body();
footer_USER();

function payment_body(){
    $chef = $GLOBALS['chef'];
    $membershipLevel = ($chef->getIsPremium() == 0) ? "Basic" : "Premium";

    echo <<<UPGRADE
        <form action="/action_page.php">
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



