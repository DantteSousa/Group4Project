<?php

function head_HTML(){
    echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BC - Bear Chefs</title>
        </head>
        <body>
    HTML;
}

function header_HTML(){
    echo <<<HEADER
    <header>
        <div class="logo">
            <a href="index.php" class="logo"><img src="images/bear.png" alt="Your Chef Service Logo"></a>     
        </div>
        <nav>
            <ul>                
                <li><a href="register.php">Register</a></li>
                <li><a href="login_form.php">Log in</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
    HEADER;
}

function footer_HTML(){
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