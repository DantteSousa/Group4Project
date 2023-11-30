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

?>
