<?php

class Experience {
    private $experienceID;
    private $customerID;
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

    // Getter and Setter for $experienceID
    public function getExperienceID() {
        return $this->experienceID;
    }

    public function setExperienceID($experienceID) {
        $this->experienceID = $experienceID;
    }

    // Getter and Setter for $customerID
    public function getCustomerID() {
        return $this->customerID;
    }

    public function setCustomerID($customerID) {
        $this->customerID = $customerID;
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
        $stoveTopType = mysqli_real_escape_string($connection, $this->getStoveTopType());
        $numBurners = mysqli_real_escape_string($connection, $this->getNumBurners());
        $oven = mysqli_real_escape_string($connection, $this->getOven());
        $mealRangeType = mysqli_real_escape_string($connection, $this->getMealType());
        $restrictions = mysqli_real_escape_string($connection, $this->getRestrictions());
        $extraInfo = mysqli_real_escape_string($connection, $this->getExtraInfo());
        $userID = mysqli_real_escape_string($connection, $this->getCustomerID());

        $select = "SELECT * FROM experiencedetail WHERE customerID = '$userID'";
        $result = mysqli_query($connection, $select);

        //In case there is alreay an experience, it will update it. 
        //Else, it will create a new one 
        
        if (mysqli_num_rows($result) > 0) {
            
        }else{
            $query = "INSERT INTO experiencedetail (customerID, numOfPeople, dayTime, eventDay, cusineType, stoveTopType, numBurners, oven, mealType, restrictions, extraInfo)
            VALUES ('$userID', '$numOfPeople', '$dayTime', '$eventDay', '$cusineType', '$stoveTopType', '$numBurners', '$oven', '$mealRangeType','$restrictions','$extraInfo')";

            // Execute the query
            mysqli_query($connection, $query);

            // You may want to add error handling here
            if (mysqli_error($connection)) {
                // Handle the error, e.g., log it or display a user-friendly message
                echo "Error: " . mysqli_error($connection);
            }
        }
        
    }
}


?>