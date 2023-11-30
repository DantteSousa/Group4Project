<?php

class Message {
    private $messageID;
    private $senderID;
    private $receiverID;
    private $dateMsg;
    private $textMsg;

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

        
        $query = "INSERT INTO message (senderID, receiverID, dateMsg, textMsg) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $senderID, $customerID, $date, $message);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // You may want to add error handling here
        if (mysqli_stmt_error($stmt)) {
            echo "Error: " . mysqli_stmt_error($stmt);
        } else {
            echo '<script type="text/javascript">
                alert("Message sent");
                location="settings.php";
                </script>';
        }
    }
}


?>