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

    public function statusString(){
        switch($this->status) {
            case '0':
                return "Order Placed";                
            case "1":
                return "Chef accepted order";                
            case "2":
                return "Order canceled";                
            case "3":
                return "Order completed";                
            default:    
                return "";  
        }
    }

    public function makeOrder($connection) {

        $chefID = mysqli_real_escape_string($connection, $this->getChefID());
        $customerID = mysqli_real_escape_string($connection, $this->getCustomerID());
        $experienceID = mysqli_real_escape_string($connection, $this->getExperienceID());
        $statusID = mysqli_real_escape_string($connection, $this->getStatus());

        $query = "INSERT INTO orders (customerID, chefID, experienceID, statusID) 
            VALUES ('$customerID', '$chefID', '$experienceID', '$statusID')";

        // Execute the query
        mysqli_query($connection, $query);

        // You may want to add error handling here
        if (mysqli_error($connection)) {
            echo "Error: " . mysqli_error($connection);
        }
    }
}

?>