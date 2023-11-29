<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';
include 'class/plate.php';
include 'class/experience.php';
include 'class/order_class.php';

session_start();
$user_chef = 'chef';
$user_customer = 'customer';
$userId='';


 if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
   //header_USER($user_chef);
   $GLOBALS['userId'] = $_SESSION['id'];
 } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    //header_USER($user_customer);    
   $GLOBALS['userId'] = $_SESSION['id'];
 }else{
    //header_HTML();
}

if (isset($_GET['id'])) {
    $plateID = $_GET['id'];
 
    $query = "SELECT * FROM plate WHERE plateID = '$plateID'";
    $result = $conn->query($query);
 
    $plate = new Plate();
    $experience = new Experience(); 
    $order = new Orders();

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
 
    $usuario = $GLOBALS['userId'];
    $experience=retriveUserExperience($conn, $usuario);
    $order->setChefID($plate->getChefID());
    $order->setCustomerID($userId);
    $order->setExperienceID($experience->getExperienceID());
    $order->setStatus(0);

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
        <strong>Stove top type: </strong>{$experience->getStringStoveTopType()}<br>
        <strong>Number of burners: </strong>{$experience->getNumBurners()} burners<br>
        <strong>Does it have an oven? </strong>{$experience->doesHaveOven()}<br>
      
        <h3>About the Experience</h3>
        <strong>Event Day: </strong>{$experience->getEventDay()}<br>
        <strong>Time: </strong> {$experience->getStringDayTime()}<br>
        <strong>Price per person:</strong> $ {$plate->calculateUnitPlatePrice($experience->getNumOfPeople())}<br>
        <strong>Number of people</strong> {$experience->getNumOfPeople()} people <br>
        <strong>Restriction: </strong> {$experience->doesHaveRestriction()}<br>

        <h4> Total: $ {$order->calculateTotal($plate->calculateUnitPlatePrice($experience->getNumOfPeople()),$experience->getNumOfPeople())}</h4> 
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

    ORDERREVIEW;

} else {
  header("Location: index.php"); 
  exit();
}

footer_USER();
?>
