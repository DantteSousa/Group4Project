<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";
include "class/retriveDB.php";

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
    $userID = $_SESSION['userID'];
    header_USER($user_customer);
}else{
    header_HTML();
}
searchPremium($conn);
searchChefRegular($conn);
footer_HTML();

function searchPremium($conn)
{
    echo <<<SEARCH_HTML
        <div class="search">
            <h2>Check out our favorite chefs!!</h2>
            <div class="search-users-container clearfix">
    SEARCH_HTML;

    $query = "SELECT * FROM user_form WHERE user_type= 'chef'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $lastname = $row['lastName'];
            $idChef = $row['id'];
            $chef = retrieveChef($conn, $idChef);
            if($chef->getIsPremium()) {
                echo <<<DISPLAY_USER
                <div class="search-user">
                    <img src="images/cheficon.png" alt="chef-icon">
                    <div>
                        <h3>$name $lastname</h3>
                        <p>{$chef->getDescription()}</p>
                        <p><strong>Specialities:</strong> {$chef->getSpecialities()}</p>
                        <p><strong>Education:</strong> {$chef->getEducation()}</p>
                        <a href="view_profile.php?id={$idChef}">see more</a> 
                    </div>
                </div>
               DISPLAY_USER;
            }
            
        }
    } else {
        echo <<<NO_USER
               <p> No chef available <br>
               <button onclick="location.href = 'index.php';"">Go Back</button></p> 
               NO_USER;
    }
    echo '</div>';

    echo <<<SCRIPT
    <script>
        function redirectToProfile(id) {
            window.location.href = 'view_profile.php?id=' + id;
        }
    </script>
    SCRIPT;

}

function searchChefRegular($conn)
{
    echo <<<SEARCH_HTML
        <div class="search">
            <h2 id="andmore">... and more</h2>
            <div class="search-users-container clearfix">
    SEARCH_HTML;

    $query = "SELECT * FROM user_form WHERE user_type= 'chef'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $lastname = $row['lastName'];
            $idChef = $row['id'];
            $chef = retrieveChef($conn, $idChef);
            if(!$chef->getIsPremium()) {
                echo <<<DISPLAY_USER
                <div class="search-user">
                    <img src="images/cheficon.png" alt="chef-icon">
                    <div>
                        <h3>$name $lastname</h3>
                        <p>{$chef->getDescription()}</p>
                        <p><strong>Specialities:</strong> {$chef->getSpecialities()}</p>
                        <p><strong>Education:</strong> {$chef->getEducation()}</p>
                        <a href="view_profile.php?id={$idChef}">see more</a> 
                    </div>
                </div>
               DISPLAY_USER;
            }
            
        }
    } else {
        echo <<<NO_USER
               <p> No chef available <br>
               <button onclick="location.href = 'index.php';"">Go Back</button></p> 
               NO_USER;
    }
    echo '</div>';

    echo <<<SCRIPT
    <script>
        function redirectToProfile(id) {
            window.location.href = 'view_profile.php?id=' + id;
        }
    </script>
    SCRIPT;

}
?>