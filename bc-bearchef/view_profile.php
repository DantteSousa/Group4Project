<?php

include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include 'class/retriveDB.php';

session_start();
$user_chef = 'chef';
$user_customer = 'customer';


// if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
//    header_USER($user_chef);
// } elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
//    header_USER($user_customer);
// }else{
//    header_HTML();
// }

// Check if the 'idfortest' parameter is set in the URL
if (isset($_GET['id'])) {
   $idChef = $_GET['id'];

   // Now you can use $idfortest in your page logic
   // For example, you can fetch the user profile data using this ID and display it

   // Sample query (replace it with your actual query)
   $query = "SELECT * FROM user_form WHERE id = '$idChef'";
   $result = $conn->query($query);

   if ($result->num_rows > 0) {
      // Fetch and display user profile data
      $row = $result->fetch_assoc();
      $name = $row['name'];
      $lastname = $row['lastName'];
      echo "<h1>$name $lastname</h1>";
      // Add more details as needed
   } else {
      echo "<p>User not found.</p>";
   }

   retrivePlatesForOrder($conn, $idChef);

} else {
   // Redirect or display an error message if 'idfortest' is not set
   header("Location: index.php"); // Redirect to the homepage or another page
   exit();
}

footer_USER();
?>
