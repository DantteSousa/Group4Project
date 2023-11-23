<?php
    class Plate{
        private $plateID;
        private $chefID;
        private $mealRangeType;
        private $cusineType;
        private $plateName;
        private $starterMenu;
        private $firstCourse;
        private $mainCourse;
        private $dessert;

        public function __construct(){

        }

        // Getter and Setter for $plateID
        public function getPlateID() {
            return $this->plateID;
        }

        public function setPlateID($plateID) {
            $this->plateID = $plateID;
        }

        // Getter and Setter for $chefID
        public function getChefID() {
            return $this->chefID;
        }

        public function setChefID($chefID) {
            $this->chefID = $chefID;
        }

        // Getter and Setter for $mealRangeType
        public function getMealRangeType() {
            return $this->mealRangeType;
        }

        public function setMealRangeType($mealRangeType) {
            $this->mealRangeType = $mealRangeType;
        }

       // Getter and Setter for $cusineType
        public function getCusineType() {
            return $this->cusineType;
        }

        public function setCusineType($cusineType) {
            $this->cusineType = $cusineType;
        }


        // Getter and Setter for $plateName
        public function getPlateName() {
            return $this->plateName;
        }

        public function setPlateName($plateName) {
            $this->plateName = $plateName;
        }

        // Getter and Setter for $starterMenu
        public function getStarterMenu() {
            return $this->starterMenu;
        }

        public function setStarterMenu($starterMenu) {
            $this->starterMenu = $starterMenu;
        }

        // Getter and Setter for $firstCourse
        public function getFirstCourse() {
            return $this->firstCourse;
        }

        public function setFirstCourse($firstCourse) {
            $this->firstCourse = $firstCourse;
        }

        // Getter and Setter for $mainCourse
        public function getMainCourse() {
            return $this->mainCourse;
        }

        public function setMainCourse($mainCourse) {
            $this->mainCourse = $mainCourse;
        }

        // Getter and Setter for $dessert
        public function getDessert() {
            return $this->dessert;
        }

        public function setDessert($dessert) {
            $this->dessert = $dessert;
        }

        public function addToDatabase($connection) {
            $chefID = mysqli_real_escape_string($connection, $this->getChefID());
            $cusineType = mysqli_real_escape_string($connection, $this->getCusineType());
            $mealRangeType = mysqli_real_escape_string($connection, $this->getMealRangeType());
            $plateName = mysqli_real_escape_string($connection, $this->getPlateName());
            $starterMenu = mysqli_real_escape_string($connection, $this->getStarterMenu());
            $firstCourse = mysqli_real_escape_string($connection, $this->getFirstCourse());
            $mainCourse = mysqli_real_escape_string($connection, $this->getMainCourse());
            $dessert = mysqli_real_escape_string($connection, $this->getDessert());
    
            $query = "INSERT INTO plate (chefID, cusineType, mealRangeType, plateName, starterMenu, firstCourse, mainCourse, dessert)
                      VALUES ('$chefID', '$cusineType', '$mealRangeType', '$plateName', '$starterMenu', '$firstCourse', '$mainCourse', '$dessert')";
    
            // Execute the query
            mysqli_query($connection, $query);
    
            // You may want to add error handling here
            if (mysqli_error($connection)) {
                // Handle the error, e.g., log it or display a user-friendly message
                echo "Error: " . mysqli_error($connection);
            }
        }

}

?>