<?php

    class User{
        private $id;
        private $name;
        private $lastName;
        private $email;
        private $password;
        private $user_type;
        private $address;
        private $phone;

        public function __construct(){

        }

        // Getter and Setter for $id
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        // Getter and Setter for $name
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }

        // Getter and Setter for $lastName
        public function getLastName() {
            return $this->lastName;
        }

        public function setLastName($lastName) {
            $this->lastName = $lastName;
        }

        // Getter and Setter for $email
        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        // Getter and Setter for $password
        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        // Getter and Setter for $user_type
        public function getUserType() {
            return $this->user_type;
        }

        public function setUserType($user_type) {
            $this->user_type = $user_type;
        }

        // Getter and Setter for $address
        public function getAddress() {
            return $this->address;
        }

        public function setAddress($address) {
            $this->address = $address;
        }

        // Getter and Setter for $phone
        public function getPhone() {
            return $this->phone;
        }

        public function setPhone($phone) {
            $this->phone = $phone;
        }
    }

    class Chef extends User {
        private $chefId;
        private $specialities;
        private $description;
        private $education;
        private $plates;
        private $isPremium;
    
        public function __construct()
        {
            parent::__construct();
        }

        // Getter and Setter for $chefId
        public function getChefId() {
            return $this->chefId;
        }
    
        public function setChefId($chefId) {
            $this->chefId = $chefId;
        }
    
        // Getter and Setter for $specialities
        public function getSpecialities() {
            return $this->specialities;
        }
    
        public function setSpecialities($specialities) {
            $this->specialities = $specialities;
        }
    
        // Getter and Setter for $description
        public function getDescription() {
            return $this->description;
        }
    
        public function setDescription($description) {
            $this->description = $description;
        }
    
        // Getter and Setter for $education
        public function getEducation() {
            return $this->education;
        }
    
        public function setEducation($education) {
            $this->education = $education;
        }
    
        // Getter and Setter for $plates
        public function getPlates() {
            return $this->plates;
        }
    
        public function setPlates($plates) {
            $this->plates = $plates;
        }
    
        // Getter and Setter for $isPremium
        public function getIsPremium() {
            return $this->isPremium;
        }
    
        public function setIsPremium($isPremium) {
            $this->isPremium = $isPremium;
        }
    }
    
?>