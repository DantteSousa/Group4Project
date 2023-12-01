<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";

session_start();
$user_chef = 'chef';
$user_customer = 'customer';

head_HTML();
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
    header_USER($user_chef);
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);
}else{
    header_HTML();
}
hero();
howWorks();
becomeAchef();
ourchefs();
footer_HTML();

function hero(){
    echo <<<HERO
        <section class="hero" id="home">
            <h2>Your Personal Chef Experience</h2>
            <p>Elevate your dining moments as our Private Chef crafts a tailor-made culinary journey, bringing exceptional flavors and gourmet expertise right to the heart of your home.</p>
            <br>
            <a href="search.php">Find your Chef</a>
        </section>
        <section class="empty"></section>
    HERO;
}

function howWorks(){
    echo <<<WORKS
    <section class="how-it-works" id="how-it-works">
            <div class="container-how-works">
                <h2>How it Works</h2>
                <div class="steps">
                    <div class="step">
                        <img src="images/ingredients.jpg" alt="Personalize your request">
                        <h4>Personalize your request</h4>
                        <p>Share the details of your dream meal, from preferred cuisine to specific tastes and dietary preferences.</p></p>
                    </div>

                    <div class="step">
                        <img src="images/menu.jpg" alt="Receive menu proposals">
                        <h4>Tell us about your culinary desires</h4>                       
                        <p>Our skilled chefs will craft menus tailored to your preferences, presenting you with enticing proposals.</p>
                    </div>

                    <div class="step">
                        <img src="images/chat.jpg" alt="Get chatty with your chefs">
                        <h4>Engage in delightful conversations</h4>                     
                        <p>Feel free to communicate with your chefs, exchanging messages to ensure your menu becomes a culinary masterpiece.</p>
                    </div>

                    <div class="step">
                        <img src="images/hands.webp" alt="Book your experience">
                        <h4>Secure your culinary adventure</h4>                        
                        <p>Once satisfied with your choice, proceed to submit your payment and secure the experience of a lifetime.</p>
                    </div>

                    <div class="step">
                        <img src="images/enjoy.jpg" alt="Countdown to your culinary experience">
                        <h4>Savor the anticipation</h4>                       
                        <p>Count down the days until your culinary journey begins, bringing you closer to a delightful experience.</p>
                    </div>

                    <div class="step">                        
                        <img src="images/chef.jpg" alt="Find your chef">
                        <h4>Enjoy an amazing experience</h4>
                        <p>Customize your request and start talking with your chefs</p>                     
                       <br>
                    </div>

                    <div class="step">
                       <p><a href="login_form.php">Discover your perfect chef</a></p>
                    </div>
                </div>
            </div>
        </section>
        <section class="empty"></section>
    WORKS;
}

function becomeAchef(){
    echo <<<BECOMECHEF
        <section class="become-a-chef" id="become-a-chef">
        <h2>Become a Chef</h2>
        <p>Fuel your culinary passion and take control of your destiny! Join our team of talented chefs and be your own boss in the kitchen. Unleash your creativity, showcase your skills, and embark on a delicious journey of independence.</p>
        
        <div class="chef-info">
            <div class="chef-image">
                <img src="images/startchef.jpg" alt="Aspiring Chef 1">
            </div>
            <div class="chef-details">
                <h3>Start Your Culinary Journey</h3>
                <p>Forge your own path as a chef! Show your skills, gain exposure, and shape your culinary career on your terms. </p>
            </div>
        </div>

        <div class="chef-info">
            <div class="chef-image">
                <img src="images/skills.jpg" alt="Aspiring Chef 2">
            </div>
            <div class="chef-details">
                <h3>Showcase Your Skills</h3>
                <p>Create your chef profile, highlight your specialties, and connect with food enthusiasts.</p>
                <a href="register.php">Register as a Chef</a>
            </div>
        </div>
    </section>
    BECOMECHEF;
}

function ourchefs(){
    echo <<<OURCHEF
    <section class="chefs" id="chefs">
            <h2>Our Chefs</h2>
            <div class="chef-profile">
                <img src="images/profile.jpg" alt="Chef 1">
                <h3>Chef John Doe</h3>
                <p>Specialties: Italian Cuisine</p>
                <p>Experience: 10+ years</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et est in turpis commodo consequat.</p>
            </div>
            <div class="chef-profile">
                <img src="images/profile.jpg" alt="Chef 2">
                <h3>Chef Jane Smith</h3>
                <p>Specialties: French Cuisine</p>
                <p>Experience: 8+ years</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et est in turpis commodo consequat.</p>
            </div>
            <div class="chef-profile">
                <img src="images/profile.jpg" alt="Chef 2">
                <h3>Chef Jane Smith</h3>
                <p>Specialties: French Cuisine</p>
                <p>Experience: 8+ years</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et est in turpis commodo consequat.</p>
            </div>
        </section>
    OURCHEF;
}

?>