<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';

session_start();
$user_chef = 'chef';
$user_customer = 'customer';

// Retrieve user information from the session
$userID = "";
head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
   header_USER($user_chef);
   $userID = $_SESSION['userID'];
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
   header_USER($user_customer);
   $userID = $_SESSION['userID'];
}else{
   header_HTML();
}

echo '<div class="view-profile"> ';
// Check if the idChef parameter is set in the URL
if (isset($_GET['id'])) {
   $idChef = $_GET['id'];

   $query = "SELECT * FROM user_form WHERE id = '$idChef'";
   $result = $conn->query($query);
   
   if ($result->num_rows > 0) {      
      // Fetch and display user profile data
      $row = $result->fetch_assoc();
      $name = $row['name'];
      $lastname = $row['lastName'];
      $chef = retrieveChef($conn, $idChef);     

      echo <<<DISPLAY_USER
         <div class='text-view-profile'>
            <h1>$name $lastname</h1>
            <p id="description">{$chef->getDescription()}</p>
            <p><strong>Specialities:</strong> {$chef->getSpecialities()}</p>
            <p><strong>Education:</strong> {$chef->getEducation()}</p>   
         </div>   
      DISPLAY_USER;
   } else {
      echo "<p>User not found.</p>";
   }   
   retrivePlatesForOrder($conn, $idChef);
   retriveReview($conn,$idChef);
} else {
   // Redirect or display an error message if 'idfortest' is not set
   header("Location: index.php"); // Redirect to the homepage or another page
   exit();
}


footer_USER();
?>
