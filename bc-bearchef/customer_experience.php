<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'views/helpers_HTML.php';

// Start the session
session_start();
// Check if the user is logged in as a customer
$user_type = 'customer';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];
head_HTML();
header_USER($user_type);
if (isset($_POST['submit'])) {
    check_update_experience($conn);
} else {
    add_experience();
}
footer_USER();



function add_experience(){
    echo <<< PROFILE
    <div class="form-payment">
    <div class="outra-div">
        <form class="form" action="$_SERVER[PHP_SELF]" method="post">                
            <h2>Tell us about how do you want your experience</h2>      
            
            <div class="radio-group">
                <label for="numOfPeople">We are...</label>
                <div class="radio-item">
                    <input type="radio" id="2" name="numOfPeople" value="2">
                    <label for="2">2 people from $190</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="3" name="numOfPeople" value="3">
                    <label for="3">3 to 6 people from $170</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="7" name="numOfPeople" value="7">
                    <label for="7">7 to 12 people from $150</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="13" name="numOfPeople" value="13">
                    <label for="13">13+ people from $150</label>             
                </div>
            </div>
            <label for="dayTime">Its for...</label>
            <select name="dayTime" id="dayTime" required>
                <option value="0">Lunch</option>
                <option value="1">Dinner</option>
            </select>
            
            <label for="eventDay">Pick the date</label>
            <input type="date" id="eventDay" name="eventDay">
        
            <div class="radio-group">
                <label for="cusineType">Our preferred cuisine is...:</label>

                <div class="radio-item">
                    <input type="radio" id="0" name="cusineType" value="0">
                    <label for="0">Mediterranean</label>
                </div>
                
                <div class="radio-item">
                    <input type="radio" id="1" name="cusineType" value="1">
                    <label for="1">Italian</label>
                </div>
                
                <div class="radio-item">
                    <input type="radio" id="2" name="cusineType" value="2">
                    <label for="2">French</label>
                </div>
                
                <div class="radio-item">
                    <input type="radio" id="3" name="cusineType" value="3">
                    <label for="3">Asian</label>
                </div>
                
                <div class="radio-item">
                    <input type="radio" id="4" name="cusineType" value="4">
                    <label for="4">Latin American</label>
                </div>
                
                <div class="radio-item">
                    <input type="radio" id="5" name="cusineType" value="5">
                    <label for="5">Other</label>
                </div>
            </div>
            
            <label for="mealRangeType">We are looking for...:</label>
            <select name="mealRangeType" id="mealRangeType" required>
                <option value="0">Basic ($190 - $230 per person)</option>
                <option value="1">Indulge ($230 - $260 per person)</option>
                <option value="2">Exclusive ($260 - $330 per person)</option>
            </select>
            
            <label for="restrictions">Any dietary Restrictions?</label>
            <select name="restrictions" id="restrictions" required>
                <option value="0">No</option>                      
                <option value="1">Yes (Please inform on the message to the chef)</option>
            </select>
            
            <label for="extraInfo">We'd like the chef to know...</label>
            <textarea name="extraInfo" rows="4" cols="50" required placeholder="Hello Chef! We would like a four couser menu with a chocolat dessert. We'd like it serverd family-style. Thank You!"></textarea>
        
            <script>
                // Function to update mealRangeType options based on numOfPeople selection
                function updateMealRangeOptions() {
                    var numOfPeople = document.querySelector('input[name="numOfPeople"]:checked').value;
                    var mealRangeTypeSelect = document.getElementById('mealRangeType');
                    mealRangeTypeSelect.innerHTML = ''; // Clear existing options

                    // Define options based on numOfPeople selection
                    var options;
                    switch (numOfPeople) {
                        case '2':
                            options = ['Basic ($190 - $230 per person)', 'Indulge ($230 - $260 per person)', 'Exclusive ($260 - $330 per person)'];
                            break;
                        case '3':
                            options = ['Basic ($170 - $190 per person)', 'Indulge ($190 - $240 per person)', 'Exclusive ($240 - $300 per person)'];
                            break;
                        case '7':
                            options = ['Basic ($150 - $170 per person)', 'Indulge ($170 - $220 per person)', 'Exclusive ($220 - $264 per person)'];
                            break;
                        case '13':
                            options = ['Basic ($150 - $170 per person)', 'Indulge ($170 - $220 per person)', 'Exclusive ($220 - $260 per person)'];
                            break;    
                        default:
                            options = ['Default Option'];
                            break;
                    }

                    // Create and append new options to the mealRangeType dropdown
                    options.forEach(function (option, index) {
                        var optionElement = document.createElement('option');
                        optionElement.value = index;
                        optionElement.textContent = option;
                        mealRangeTypeSelect.appendChild(optionElement);
                    });
                }

                // Attach the updateMealRangeOptions function to the change event of numOfPeople radio buttons
                var radioButtons = document.querySelectorAll('input[name="numOfPeople"]');
                radioButtons.forEach(function (radioButton) {
                    radioButton.addEventListener('change', updateMealRangeOptions);
                });

                // Call the function initially to set the initial options
                updateMealRangeOptions(); 
                                
            </script>
            <input class="btn" type="submit" name="submit" value="save information">
        </form>
        <br>     
        <button onclick="location.href = 'settings.php';"">Go Back</button>
        </div>
        </div>
        </div>
    PROFILE;
}

function check_update_experience($conn){
    // Retrieve form values

    $numOfPeople = $_POST['numOfPeople'];
    $dayTime = $_POST['dayTime'];
    $eventDay = $_POST['eventDay'];
    $cusineType = $_POST['cusineType'];
    $mealRangeType = $_POST['mealRangeType'];
    $restrictions = $_POST['restrictions'];
    $extraInfo = $_POST['extraInfo'];
    $userID = $GLOBALS['userID'];
    
    $customer = new Customer();

    $customer->setCustomerID($userID);
    $customer->setNumOfPeople($numOfPeople);
    $customer->setDayTime($dayTime);
    $customer->setEventDay($eventDay);
    $customer->setCusineType((int)$cusineType);
    $customer->setMealType($mealRangeType);
    $customer->setRestrictions($restrictions);
    $customer->setExtraInfo($extraInfo);
    
    $customer->addExperience($conn);
}


?>