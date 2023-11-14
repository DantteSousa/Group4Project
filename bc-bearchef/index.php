<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";

session_start();
$user_chef = 'chef';
$user_customer = 'customer';


if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
    header_USER($user_chef);
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);
}else{
    header_HTML();
}

footer_HTML();
?>