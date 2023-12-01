<?php
class PaymentInfo {
    private $paymentInfoID;
    private $userID;
    private $fullName;
    private $email;
    private $addressUser;
    private $cityUser;
    private $stateUser;
    private $zipUser;
    private $nameCard;
    private $creditCard;
    private $expMonth;
    private $expYear;
    private $cvv;

    
    public function __construct(
        $userID,
        $fullName,
        $email,
        $addressUser,
        $cityUser,
        $stateUser,
        $zipUser,
        $nameCard,
        $creditCard,
        $expMonth,
        $expYear,
        $cvv
    ) {
        $this->userID = $userID;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->addressUser = $addressUser;
        $this->cityUser = $cityUser;
        $this->stateUser = $stateUser;
        $this->zipUser = $zipUser;
        $this->nameCard = $nameCard;
        $this->creditCard = $creditCard;
        $this->expMonth = $expMonth;
        $this->expYear = $expYear;
        $this->cvv = $cvv;
    }

    public function getPaymentInfoID() {
        return $this->paymentInfoID;
    }

    public function setPaymentInfoID($paymentInfoID) {
        $this->paymentInfoID = $paymentInfoID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAddressUser() {
        return $this->addressUser;
    }

    public function setAddressUser($addressUser) {
        $this->addressUser = $addressUser;
    }

    public function getCityUser() {
        return $this->cityUser;
    }

    public function setCityUser($cityUser) {
        $this->cityUser = $cityUser;
    }

    public function getStateUser() {
        return $this->stateUser;
    }

    public function setStateUser($stateUser) {
        $this->stateUser = $stateUser;
    }

    public function getZipUser() {
        return $this->zipUser;
    }

    public function setZipUser($zipUser) {
        $this->zipUser = $zipUser;
    }

    public function getNameCard() {
        return $this->nameCard;
    }

    public function setNameCard($nameCard) {
        $this->nameCard = $nameCard;
    }

    public function getCreditCard() {
        return $this->creditCard;
    }

    public function setCreditCard($creditCard) {
        $this->creditCard = $creditCard;
    }

    public function getExpMonth() {
        return $this->expMonth;
    }

    public function setExpMonth($expMonth) {
        $this->expMonth = $expMonth;
    }

    public function getExpYear() {
        return $this->expYear;
    }

    public function setExpYear($expYear) {
        $this->expYear = $expYear;
    }

    public function getCvv() {
        return $this->cvv;
    }

    public function setCvv($cvv) {
        $this->cvv = $cvv;
    }

    public function makePayment($connection, $orderTotal) {
        
        $userID = mysqli_real_escape_string($connection, $this->getUserID());
        $fullName = mysqli_real_escape_string($connection, $this->getFullName());
        $email = mysqli_real_escape_string($connection, $this->getEmail());
        $addressUser = mysqli_real_escape_string($connection, $this->getAddressUser());
        $cityUser = mysqli_real_escape_string($connection, $this->getCityUser());
        $stateUser = mysqli_real_escape_string($connection, $this->getStateUser());
        $zipUser = mysqli_real_escape_string($connection, $this->getZipUser());
        $nameCard = mysqli_real_escape_string($connection, $this->getNameCard());
        $creditCard = mysqli_real_escape_string($connection, $this->getCreditCard());
        $expMonth = mysqli_real_escape_string($connection, $this->getExpMonth());
        $expYear = mysqli_real_escape_string($connection, $this->getExpYear());
        $cvv = mysqli_real_escape_string($connection, $this->getCvv());

        $query = "INSERT INTO paymentinfo (
            userID, fullName, email, address_user, city_user, state_user, zip_user,
            name_card, credit_card, exp_month, exp_year, cvv, paymentValue
        ) VALUES (
            '$userID', '$fullName', '$email', '$addressUser', '$cityUser', '$stateUser',
            '$zipUser', '$nameCard', '$creditCard', '$expMonth', '$expYear', '$cvv', '$orderTotal'
        )";

        // Execute the query
        mysqli_query($connection, $query);

        // Retrieve the last inserted ID
        $lastInsertedID = mysqli_insert_id($connection);
        echo "". $lastInsertedID ."";

        // You may want to add error handling here
        if (mysqli_error($connection)) {
            echo "Error: " . mysqli_error($connection);
        }
        return $lastInsertedID;
    }
}

?>