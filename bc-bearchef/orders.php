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


    ORDERREVIEW;


} else {
   // Redirect or display an error message if 'idfortest' is not set
   header("Location: index.php"); // Redirect to the homepage or another page
   exit();
}

footer_USER();
?>
