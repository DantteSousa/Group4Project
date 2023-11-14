<?php

   include "views/helpers_HTML.php";
   include 'includes/config.php';

   session_start();
   header_HTML();
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
      //Empty array of errors messages
      $errors = array();

      $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
      $pass = isset($_POST['password']) ? md5($_POST['password']) : '';
      

      $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

      $result = mysqli_query($conn, $select);
      
      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);
         if ($row['user_type'] == 'customer') {
            // Store user information in session
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['id'] = $row['id'];
             
            // Redirect customer to the customer page
            header("Location: customer.php");
            exit();
         } elseif ($row['user_type'] == 'chef') {
             // Store user information in session
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['id'] = $row['id'];
             
            // Redirect chef to the chef page
            header("Location: chef.php");
            exit();
         } else {
             $errors[] = 'Invalid user type!';
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