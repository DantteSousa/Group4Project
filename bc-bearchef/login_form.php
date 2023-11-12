<?php

@include 'config.php';


session_start();

if(isset($_POST['submit'])){

   $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
   $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
   $pass = isset($_POST['password']) ? md5($_POST['password']) : '';
   $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
   
   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'chef'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:chef.php');

      }elseif($row['user_type'] == 'customer'){

         $_SESSION['user_name'] = $row['name'];
         header('location:customer.php');

      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style_index.css">

</head>
<body>
   <!-- ======== START OF THE NAV MENU ======== -->
   <!--
   <header>
      <a href="#" class="logo">Logo</a>
      <div class="group">
         <ul class="navigation">
               <li><a href="login_form.php">Login</a></li>
               <li><a href="register_form.php">Sign In</a></li>
         </ul>
         <div class="search">
               <span class="icon">
                  <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                  <ion-icon name="close-outline" class="closeBtn"></ion-icon>
               </span>
         </div>
         <ion-icon name="menu-outline" class="menuToggle"></ion-icon>
      </div>
      <div class="searchBox">
         <input type="text" placeholder="Search here...">
      </div>
   </header>
-->
   <!-- Import the menu the icons -->
   <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

   <script>
      // Click on the search button
      let searchBtn = document.querySelector('.searchBtn');
      let closeBtn = document.querySelector('.closeBtn');
      let searchBox = document.querySelector('.searchBox');
      
      // Hide menu to make the screen responsible
      let navigation = document.querySelector('navigation');
      let menuToggle = document.querySelector('.menuToggle');
      let header = document.querySelector('header');

      searchBtn.onclick = function(){
         searchBox.classList.add('active');
         closeBtn.classList.add('active');
         searchBtn.classList.add('active');
         menuToggle.classList.add('hide');
      }

      closeBtn.onclick = function(){
         searchBox.classList.remove('active');
         closeBtn.classList.remove('active');
         searchBtn.classList.remove('active');
         menuToggle.classList.remove('hide');
      }

      menuToggle.onclick = function(){
         header.classList.toggle('open');
         searchBox.classList.remove('active');
         closeBtn.classList.remove('active');
         searchBtn.classList.remove('active');
      }

   </script>
   <!-- ======== END OF THE NAV MENU ======== -->
   <div class="form-container">

      <form action="" method="post">
         <h3>login now</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="enter your email">
         <input type="password" name="password" required placeholder="enter your password">
         <input type="submit" name="submit" value="login now" class="form-btn">
         <p>don't have an account? <a href="register_form.php">register now</a></p>
      </form>

   </div>

</body>
</html>