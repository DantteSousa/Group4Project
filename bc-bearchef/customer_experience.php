<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'class/experience.php';

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
$userId = $_SESSION['id'];

// Include the header and body functions
header_USER($user_type);
if (isset($_POST['submit'])) {
    check_update_experience($conn);
} else {
    add_experience();
}

footer_USER();

function add_experience(){
    echo <<< PROFILE
        <div>
            <h2>Tell us about how do you want your experience</h2>      
            <form action="$_SERVER[PHP_SELF]" method="post">                
                <div>
                    <label for="numOfPeople">We are...</label><br>
                    <input type="radio" id="2" name="numOfPeople" value="2">
                    <label for="2">2 people from $190</label><br>
                    <input type="radio" id="3" name="numOfPeople" value="3">
                    <label for="3">3 to 6 people from $170</label><br>
                    <input type="radio" id="7" name="numOfPeople" value="7">
                    <label for="7">7 to 12 people from $150</label><br>
                    <input type="radio" id="13" name="numOfPeople" value="13">
                    <label for="13">13+ people from $150</label><br>                
                </div>
                <br>
                <div>
                    <label for="dayTime">Its for...</label><br>
                    <select name="dayTime" id="dayTime" required>
                        <option value="0">Lunch</option>
                        <option value="1">Dinner</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="eventDay">Pick the date</label><br>
                    <input type="date" id="eventDay" name="eventDay">
                </div>
                <br>
                <div>
                    <label for="cusineType">Our preferred cuisine is...:</label><br>
                    <input type="radio" id="0" name="cusineType" value="0">
                    <label for="0">Mediterranean</label><br>
                    <input type="radio" id="1" name="cusineType" value="1">
                    <label for="1">Italian</label><br>
                    <input type="radio" id="2" name="cusineType" value="2">
                    <label for="2">French</label><br>
                    <input type="radio" id="3" name="cusineType" value="3">
                    <label for="3">Asian</label><br> 
                    <input type="radio" id="4" name="cusineType" value="4">
                    <label for="4">Latin American</label><br>
                    <input type="radio" id="3" name="cusineType" value="5">
                    <label for="5">Other</label><br>
                </div>
                <br>
                <div>
                    <label for="stoveTopType">Our stove top is...</label><br>
                    <select name="stoveTopType" id="stoveTopType" required>
                        <option value="0">Eletric</option>
                        <option value="1">Induction</option>
                        <option value="2">Gas</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="numBurners">Our kitchen has...</label><br>
                    <select name="numBurners" id="numBurners" required>
                        <option value="2">2 burners</option>
                        <option value="3">3 burners</option>
                        <option value="4">4 burners</option>
                        <option value="5">5 burners</option>                        
                    </select>
                </div>
                <br>
                <div>
                    <label for="oven">We have an oven...</label><br>
                    <select name="oven" id="oven" required>
                        <option value="0">No</option>                      
                        <option value="1">Yes</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="mealRangeType">We are looking for...:</label><br>
                    <select name="mealRangeType" id="mealRangeType" required>
                        <option value="0">Basic ($190 - $230 per person)</option>
                        <option value="1">Indulge ($230 - $260 per person)</option>
                        <option value="2">Exclusive ($260 - $330 per person)</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="restrictions">Any dietary Restrictions?</label><br>
                    <select name="restrictions" id="restrictions" required>
                        <option value="0">No</option>                      
                        <option value="1">Yes (Please inform on the message to the chef)</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="extraInfo">We'd like the chef to know...</label><br> 
                    <textarea name="extraInfo" rows="4" cols="50" required placeholder="Hello Chef! We would like a four couser menu with a chocolat dessert. We'd like it serverd family-style. Thank You!"></textarea>
                </div>
                
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

                <input type="submit" name="submit" value="save information">
            </form>
            <a href="chef_view_plates.php" class="btn">VIEW PLATES</a>
            <br>
     
            <!-- Back button -->
            <button onclick="location.href = 'settings.php';"">Go Back</button>
        </div>
    PROFILE;
}

function check_update_experience($conn){
    // Retrieve form values

    $numOfPeople = $_POST['numOfPeople'];
    $dayTime = $_POST['dayTime'];
    $eventDay = $_POST['eventDay'];
    $cusineType = $_POST['cusineType'];
    $stoveTopType = $_POST['stoveTopType'];
    $numBurners = $_POST['numBurners'];
    $oven = $_POST['oven'];
    $mealRangeType = $_POST['mealRangeType'];
    $restrictions = $_POST['restrictions'];
    $extraInfo = $_POST['extraInfo'];
    $userID = $GLOBALS['userId'];
    
    $experience = new Experience();

    $experience->setCustomerID($userID);
    $experience->setNumOfPeople($numOfPeople);
    $experience->setDayTime($dayTime);
    $experience->setEventDay($eventDay);
    $experience->setCusineType((int)$cusineType);
    $experience->setStoveTopType($stoveTopType);
    $experience->setNumBurners($numBurners);
    $experience->setOven($oven);
    $experience->setMealType($mealRangeType);
    $experience->setRestrictions($restrictions);
    $experience->setExtraInfo($extraInfo);
    
    $experience->addExperience($conn);
}


?>