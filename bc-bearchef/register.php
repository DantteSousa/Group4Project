<?php
    include "views/helpers_HTML.php";
    include 'includes/config.php';

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

        if($_POST['password'] != $_POST['cpassword']){
            $errors[ ] = 'Password not matched!';
        } else{
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $pass = md5($_POST['password']);
            $cpass = md5($_POST['cpassword']);
            $user_type = $_POST['user_type'];

            $select = "SELECT * FROM user_form WHERE email = '$email'";
            $result = mysqli_query($conn, $select);

            if (mysqli_num_rows($result) > 0) {
                $errors[] = 'User already exists!';
            } else {
                if ($pass != $cpass) {
                    $errors[] = 'Password not matched!';
                } else {
                    $insert = "INSERT INTO user_form (name, lastName, email, password, user_type, address, phone) VALUES ('$name', '', '$email', '$pass', '$user_type', '', '')";

                    if (!mysqli_query($conn, $insert)) {
                        $errors[] = "Error inserting record: " . mysqli_error($conn);
                    } else {
                    header('location:login_form.php');
                    exit();
                    }
                }
            }   
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
            <form action="$_SERVER[PHP_SELF]" method="post">
                <h3>register now</h3>
                <span class="error-msg">$combinedText</span>
                <input type="text" name="name" required placeholder="enter your name">
                <input type="email" name="email" required placeholder="enter your email">
                <input type="password" name="password" required placeholder="enter your password">
                <input type="password" name="cpassword" required placeholder="confirm your password">
                <select name="user_type">
                    <option value="chef">chef</option>
                    <option value="customer">customer</option>
                </select>
                <input type="submit" name="submit" value="register now" class="form-btn">
                <p>already have an account? <a href="login_form.php">login now</a></p>
            </form>
  
        </div>
        FORM;
    }

?>