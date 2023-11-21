<?php

   include "views/helpers_HTML.php";
   include 'includes/config.php';
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   
   session_start();
   // header_HTML();
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //If validate_form returns errors, pass them to show_form()
      if($form_errors = validate_form($conn)){
         show_form($form_errors);
      }
   } else{
      show_form();
   }
   footer_HTML();

    
   //Validate function
   //Will check if the user already exists or if the passwords match or not
   //In case everything is alright, it will go to the login page   
   function validate_form($conn){
      $errors = array();
  
      $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
      $enteredPassword = isset($_POST['password']) ? $_POST['password'] : '';
  
      $select = "SELECT * FROM user_form WHERE email = '$email'";
      $result = mysqli_query($conn, $select);
  
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);
          $hashedPassword = $row['password'];
  
          echo "Password que eu escrevi: $enteredPassword <br>";
          echo "PAssword hasshed $hashedPassword";

          // Verify the entered password against the hashed password
          if (password_verify($enteredPassword, $hashedPassword)) {
              // Password is correct
  
              // Store user information in session
              $_SESSION['user_type'] = $row['user_type'];
              $_SESSION['id'] = $row['id'];
  
              // Redirect based on user type
              if ($row['user_type'] == 'customer') {
                  header("Location: customer.php");
                  exit();
              } elseif ($row['user_type'] == 'chef') {
                  header("Location: chef.php");
                  exit();
              } else {
                  $errors[] = 'Invalid user type!';
              }
          } else {
              // Password is incorrect
              $errors[] = 'Incorrect email or password!';
          }
      } else {
          $errors[] = 'Incorrect email or password!';
      }
  
      return $errors;
  }
  
  
  
   function show_form($errors = array()){
      $combinedText = null;
      if($errors){
         $combinedText = implode(" ", $errors);
      }     

      echo <<<FORM
      <div class="form-container">
         <form action="" method="post">
               <h3>login now</h3>
               <span class="error-msg">$combinedText</span>
               <input type="email" name="email" required placeholder="enter your email">
               <input type="password" name="password" required placeholder="enter your password">
               <input type="submit" name="submit" value="login now" class="form-btn">
               <p>don't have an account? <a href="register.php">register now</a></p>
         </form>

      </div>
      FORM;
   }

?>