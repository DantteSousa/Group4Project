<?php
    class Customer extends User{
        private $customerId;
        private $numOfPeople;
        private $dayTime;
        private $eventDay;
        private $cusineType;
        private $stoveTopType;
        private $numBurners;
        private $oven;
        private $mealType;
        private $restrictions;
        private $typeRestrictions;
        private $extraInfo;

        public function __construct()
        {
            parent::__construct();
        }

        public function getCustomerId(){
            return $this->customerId;
        }

        public function setCustomerId($customerId){
            $this->customerId = $customerId;
        }

        // Getter and Setter for $numOfPeople
        public function getNumOfPeople() {
            return $this->numOfPeople;
        }

        public function setNumOfPeople($numOfPeople) {
            $this->numOfPeople = $numOfPeople;
        }

        // Getter and Setter for $dayTime
        public function getDayTime() {
            return $this->dayTime;
        }

        public function setDayTime($dayTime) {
            $this->dayTime = $dayTime;
        }

        // Getter and Setter for $eventDay
        public function getEventDay() {
            return $this->eventDay;
        }

        public function setEventDay($eventDay) {
            $this->eventDay = $eventDay;
        }

        // Getter and Setter for $cusineType
        public function getCusineType() {
            return $this->cusineType;
        }

        public function setCusineType($cusineType) {
            $this->cusineType = $cusineType;
        }

        // Getter and Setter for $stoveTopType
        public function getStoveTopType() {
            return $this->stoveTopType;
        }

        public function setStoveTopType($stoveTopType) {
            $this->stoveTopType = $stoveTopType;
        }

        // Getter and Setter for $numBurners
        public function getNumBurners() {
            return $this->numBurners;
        }

        public function setNumBurners($numBurners) {
            $this->numBurners = $numBurners;
        }

        // Getter and Setter for $oven
        public function getOven() {
            return $this->oven;
        }

        public function setOven($oven) {
            $this->oven = $oven;
        }

        // Getter and Setter for $mealType
        public function getMealType() {
            return $this->mealType;
        }

        public function setMealType($mealType) {
            $this->mealType = $mealType;
        }

        // Getter and Setter for $restrictions
        public function getRestrictions() {
            return $this->restrictions;
        }

        public function setRestrictions($restrictions) {
            $this->restrictions = $restrictions;
        }

        // Getter and Setter for $typeRestrictions
        public function getTypeRestrictions() {
            return $this->typeRestrictions;
        }

        public function setTypeRestrictions($typeRestrictions) {
            $this->typeRestrictions = $typeRestrictions;
        }

        // Getter and Setter for $extraInfo
        public function getExtraInfo() {
            return $this->extraInfo;
        }

        public function setExtraInfo($extraInfo) {
            $this->extraInfo = $extraInfo;
        }

        public function addExperience($connection) {

            $numOfPeople = mysqli_real_escape_string($connection, $this->getNumOfPeople());
            $dayTime = mysqli_real_escape_string($connection, $this->getDayTime());
            $eventDay = mysqli_real_escape_string($connection, $this->getEventDay());
            $cusineType = mysqli_real_escape_string($connection, $this->getCusineType());
            $mealRangeType = mysqli_real_escape_string($connection, $this->getMealType());
            $restrictions = mysqli_real_escape_string($connection, $this->getRestrictions());
            $extraInfo = mysqli_real_escape_string($connection, $this->getExtraInfo());
            $userID = mysqli_real_escape_string($connection, $this->getCustomerID());

            $select = "SELECT * FROM customer WHERE customerID = '$userID'";
            $result = mysqli_query($connection, $select);

            //In case there is alreay an experience, it will update it. 
            //Else, it will create a new one 
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $userID = $row["customerID"];

                $stmt = $connection->prepare("UPDATE customer SET numOfPeople=?, dayTime=?, eventDay=?, cusineType=?, mealType=?, restrictions=?, extraInfo=?  WHERE customerID=?");
                
                // Check if the statement was prepared successfully
                if (!$stmt) {
                    die("Error during updateChefInfo preparation: " . $connection->error);
                }
        
                // Bind parameters
                $stmt->bind_param('iisiiiss', $numOfPeople, $dayTime, $eventDay, $cusineType, $mealRangeType, $restrictions, $extraInfo, $userID);

                // Check if the parameters were bound successfully
                if (!$stmt) {
                    die("Error during updateChefInfo binding: " . $connection->error);
                }
        
                // Execute the statement
                $stmt->execute();
        
                // Check if the statement execution was successful
                if ($stmt->affected_rows > 0) {
                    echo '<script type="text/javascript">
                        alert("Experience Successfully Updated");
                        location="customer.php";
                        </script>';
                } 

            }    
        }

        public function addInformationAboutCustomer($connection){
            
            $stoveTopType = mysqli_real_escape_string($connection, $this->getStoveTopType());
            $numBurners = mysqli_real_escape_string($connection, $this->getNumBurners());
            $oven = mysqli_real_escape_string($connection, $this->getOven());
            $userID = mysqli_real_escape_string($connection, $this->getCustomerID());

            $stmt = $connection->prepare("UPDATE customer SET stoveTopType=?, numBurners=?, oven=? WHERE customerID=?");
            
            // Check if the statement was prepared successfully
            if (!$stmt) {
                die("Error during updateChefInfo preparation: " . $connection->error);
            }
    
            // Bind parameters
            $stmt->bind_param("iiii", $stoveTopType, $numBurners, $oven, $userID);
            
            // Check if the parameters were bound successfully
            if (!$stmt) {
                die("Error during updateChefInfo binding: " . $connection->error);
            }
    
            // Execute the statement
            $stmt->execute();
    
            // Check if the statement execution was successful
            if ($stmt->affected_rows > 0) {
            echo '<script type="text/javascript">
                    alert("Experience Successfully Updated");
                    location="customer.php";
                    </script>';
            } 
        }

        public function getStringStoveTopType(){
            $stoveTop = "";
    
            if($this->getStoveTopType() == 0){
                $stoveTop = "Eletric";
            }else if ($this->getStoveTopType() == 1){
                $stoveTop = "Induction";
            } else{
                $stoveTop = "Gas";
            }
            return $stoveTop;
        }

        public function doesHaveOven(){
            return ($this->getOven() == 0) ? "No" : "Yes"; 
        }

        public function doesHaveRestriction(){
            return ($this->getRestrictions() == 0) ? "No" : "Yes"; 
        }

        public function getStringDayTime(){
            return ($this->getDayTime() == 0) ? "Lunch" : "Dinner"; 
        }
    }

?>