<?php


function header_USER($user_type){
    echo <<<HEADER_USER
        <header>
            <div class="logo">
                <a href="index.php" class="logo"><img src="images/bear.png" alt="Your Chef Service Logo"></a>
            </div>
            <nav>
                <ul>                
                    <li><a href="index.php">Home</a></li>
                    <li><a href="${user_type}.php">Profile</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        <main>
    HEADER_USER;
}

function footer_USER(){
    echo <<<HTML_FOOTER
        </main>
        <footer id="contact">
            <section class="contact">
                <h2>Contact Us</h2>
                <p>Email: info@yourchefservice.com</p>
                <p>Phone: (123) 456-7890</p>
            </section>
            <section class="social-media">
                <h2>Follow Us</h2>
                <a href="#" target="_blank" rel="noopener noreferrer">Facebook</a>
                <a href="#" target="_blank" rel="noopener noreferrer">Twitter</a>
                <a href="#" target="_blank" rel="noopener noreferrer">Instagram</a>
            </section>
        </footer>
    HTML_FOOTER;
}

function customer_Bottom(){
    echo <<<ORDERBOTTOM
    </div>
        </div>
        <script>
        function showOption(option) {
        // Add logic for each option
        switch (option) {
            case 'Option1':
                window.location.href = 'customer_orders.php'; 
                break;
            case 'Option2':
                window.location.href = 'customer_display.php'; 
                break;
            case 'Option3':
                window.location.href = 'customer_read.php'; 
                break;
            case 'Option4':
                window.location.href = 'customer_reviews.php'; 
                break;           
            default:
                // You can choose to do nothing or redirect to a default page
                break;
        }
        }
    </script> 
    ORDERBOTTOM;
}

function customer_top(){
    echo <<<ORDERTOP
        <div class="main-container">
        <div class="options-bar">
                <ul>
                    <li><a href="#" onclick="showOption('Option1')">Recent Orders</a></li>
                    <li><a href="#" onclick="showOption('Option2')">Experience</a></li>
                    <li><a href="#" onclick="showOption('Option3')">Messages</a></li>
                    <li><a href="#" onclick="showOption('Option4')">Reviews History</a></li>
                </ul>
        </div>
        <div class="account-info" id="account-info">
       ORDERTOP;
}

?>
