<?php

class Message {
    private $messageID;
    private $senderID;
    private $receiverID;
    private $dateMsg;
    private $textMsg;

    private $orderID; 
    public function __construct($senderID, $receiverID, $dateMsg, $textMsg) {
        $this->senderID = $senderID;
        $this->receiverID = $receiverID;
        $this->dateMsg = $dateMsg;
        $this->textMsg = $textMsg;
    }

    public function getMessageID() {
        return $this->messageID;
    }

    public function setMessageID($messageID) {
        $this->messageID = $messageID;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }
    public function getSenderID() {
        return $this->senderID;
    }

    public function setSenderID($senderID) {
        $this->senderID = $senderID;
    }

    public function getReceiverID() {
        return $this->receiverID;
    }

    public function setReceiverID($receiverID) {
        $this->receiverID = $receiverID;
    }

    public function getDateMsg() {
        return $this->dateMsg;
    }

    public function setDateMsg($dateMsg) {
        $this->dateMsg = $dateMsg;
    }

    public function getTextMsg() {
        return $this->textMsg;
    }

    public function setTextMsg($textMsg) {
        $this->textMsg = $textMsg;
    }

    public function sendMessage($connection){
        $senderID = mysqli_real_escape_string($connection, $this->getSenderID());
        $customerID = mysqli_real_escape_string($connection, $this->getReceiverID());
        $date = mysqli_real_escape_string($connection, $this->getDateMsg());
        $message = mysqli_real_escape_string($connection, $this->getTextMsg());
        $orderID = mysqli_real_escape_string($connection, $this->getOrderID());

        
        $query = "INSERT INTO messages (senderID, receiverID, dateMsg, textMsg, orderID) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $senderID, $customerID, $date, $message, $orderID);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Error handling 
        if (mysqli_stmt_error($stmt)) {
            echo "Error: " . mysqli_stmt_error($stmt);
        } else {
            echo '<script type="text/javascript">
                alert("Message sent!");
                location="chef_read.php";
                </script>';
        }
    }

    public function sendMessageToChef($connection){
        $senderID = mysqli_real_escape_string($connection, $this->getSenderID());
        $customerID = mysqli_real_escape_string($connection, $this->getReceiverID());
        $date = mysqli_real_escape_string($connection, $this->getDateMsg());
        $message = mysqli_real_escape_string($connection, $this->getTextMsg());
        $orderID = mysqli_real_escape_string($connection, $this->getOrderID());

        
        $query = "INSERT INTO messages (senderID, receiverID, dateMsg, textMsg, orderID) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $senderID, $customerID, $date, $message, $orderID);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Error handling 
        if (mysqli_stmt_error($stmt)) {
            echo "Error: " . mysqli_stmt_error($stmt);
        } else {
            echo '<script type="text/javascript">
                alert("Message sent!");
                location="customer_read.php";
                </script>';
        }
    }
}


?>