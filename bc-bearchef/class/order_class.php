<?php
class Orders {
    private $orderID;
    private $customerID;
    private $chefID;
    private $dateExperience;
    private $status;
    private $total;


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
    public function getDateExperience() {
        return $this->dateExperience;
    }

    public function setDateExperience($dateExperience) {
        $this->dateExperience = $dateExperience;
    }

    // Getter and Setter for status
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function calculateTotal($numOfPeople, $pricePerPeople){
        return $numOfPeople * $pricePerPeople;
    }

    public function statusString(){
        switch($this->status) {
            case '0':
                return "Order Placed";
            case '1':
                return "Order Placed and Payed";                
            case "2":
                return "Chef accepted order";                
            case "3":
                return "Order canceled";                
            case "4":
                return "Order completed";   
            case "5":
                return "Order completed";             
            default:    
                return "";  
        }
    }

    public function makeOrder($connection) {

        $chefID = mysqli_real_escape_string($connection, $this->getChefID());
        $customerID = mysqli_real_escape_string($connection, $this->getCustomerID());
        $dateExperience = mysqli_real_escape_string($connection, $this->getDateExperience());
        $statusID = mysqli_real_escape_string($connection, $this->getStatus());
        $total = mysqli_real_escape_string($connection, $this->getTotal());
        
        $query = "INSERT INTO orders (customerID, chefID, dateExperience, statusOrder, total, paymentID) 
            VALUES ('$customerID', '$chefID', '$dateExperience', '$statusID', '$total', '')";

        // Execute the query
        mysqli_query($connection, $query);

        // You may want to add error handling here
        if (mysqli_error($connection)) {
            echo "Error: " . mysqli_error($connection);
        }
    }

    public function updatePayment($connection, $paymentID){
        $userID = mysqli_real_escape_string($connection, $this->getCustomerID());
        $stmt = $connection->prepare("UPDATE orders SET paymentID=? WHERE customerID=?");
            
        // Check if the statement was prepared successfully
        if (!$stmt) {
            die("Error during updateChefInfo preparation: " . $connection->error);
        }

        // Bind parameters
        $stmt->bind_param("ii", $paymentID, $userID);
        
        // Check if the parameters were bound successfully
        if (!$stmt) {
            die("Error during updateChefInfo binding: " . $connection->error);
        }

        // Execute the statement
        $stmt->execute();

        // Check if the statement execution was successful
        if ($stmt->affected_rows > 0) {
        echo '<script type="text/javascript">
                alert("Payment Made!");
                location="customer.php";
                </script>';
        } 
    }
}

?>