<?php
class Orders {
    private $orderID;
    private $customerID;
    private $chefID;
    private $experienceID;
    private $status;

    // Constructor
    public function __construct() {
        
    }

    // Getter and Setter for orderID
    public function getOrderID() {
        return $this->orderID;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    // Getter and Setter for customerID
    public function getCustomerID() {
        return $this->customerID;
    }

    public function setCustomerID($customerID) {
        $this->customerID = $customerID;
    }

    // Getter and Setter for chefID
    public function getChefID() {
        return $this->chefID;
    }

    public function setChefID($chefID) {
        $this->chefID = $chefID;
    }

    // Getter and Setter for experienceID
    public function getExperienceID() {
        return $this->experienceID;
    }

    public function setExperienceID($experienceID) {
        $this->experienceID = $experienceID;
    }

    // Getter and Setter for status
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function calculateTotal($numOfPeople, $pricePerPeople){
        return $numOfPeople * $pricePerPeople;
    }
}

?>