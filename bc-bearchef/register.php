<?php
include "views/helpers_HTML.php";
include 'includes/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header_HTML();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If validate_form returns errors, pass them to show_form()
    if ($form_errors = validate_form($conn)) {
        show_form($form_errors);
    }
} else {
    show_form();
}

footer_HTML();

function validate_form($conn)
{
    $errors = array();

    if ($_POST['password'] != $_POST['cpassword']) {
        $errors[] = 'Passwords do not match!';
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = $_POST['password'];
        $user_type = $_POST['user_type'];

        $select = "SELECT * FROM user_form WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'User already exists!';
        } else {
            $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

            $insertUser = "INSERT INTO user_form (name, lastName, email, password, user_type, address, phone) 
                           VALUES ('$name', '', '$email', '$hashedPassword', '$user_type', '', '')";

            if (!mysqli_query($conn, $insertUser)) {
                $errors[] = "Error inserting record: " . mysqli_error($conn);
            } else {
                $currentID = mysqli_insert_id($conn);

                if ($user_type == "chef") {
                    $userTypeTable = "INSERT INTO chef (chefID, specialities, description, education, plates, isPremium) 
                                       VALUES ('$currentID', '', '', '', '', 'false')";
                } else {
                    $userTypeTable = "INSERT INTO customer (customerID, numOfPeople, dayTime, eventDay, cusineType, stoveTopType, numBurners, oven, mealType, restrictions, typeRestrictions, extraInfo)
                                       VALUES ('$currentID', '', '', '', '', '','','','','','','')";
                }

                if (!mysqli_query($conn, $userTypeTable)) {
                    $errors[] = "Error inserting user type record: " . mysqli_error($conn);
                    // Consider rolling back the transaction here
                } else {
                    header('location:login_form.php');
                    exit();
                }
            }
        }
    }

    return $errors;
}

function show_form($errors = array())
{
    $combinedText = null;
    if ($errors) {
        $combinedText = implode(" ", $errors);
    }

    echo <<<FORM
    <div class="form-container">
        <form action="$_SERVER[PHP_SELF]" method="post">
            <h3>Register Now</h3>
            <span class="error-msg">$combinedText</span>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
            <select name="user_type">
                <option value="chef">Chef</option>
                <option value="customer">Customer</option>
            </select>
            <input type="submit" name="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>
    </div>
FORM;
}
?>
