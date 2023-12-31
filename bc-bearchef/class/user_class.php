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

        function updateUserInfo($conn, $userID, $name, $lastname, $email, $password, $address, $phone){
            $stmt = $conn->prepare("UPDATE user_form SET name=?, lastName=?, email=?, password=?, address=?, phone=? WHERE id=?");
            
            // Check if the statement was prepared successfully
            if (!$stmt) {
                die("Error during updateChefInfo preparation: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("ssssssi", $name, $lastname, $email, $password, $address, $phone, $userID);
            
            // Check if the parameters were bound successfully
            if (!$stmt) {
                die("Error during updateChefInfo binding: " . $conn->error);
            }

            // Execute the statement
            $stmt->execute();

            // Check if the statement execution was successful
            if ($stmt->affected_rows > 0) {
                echo '<script type="text/javascript">
                alert("Profile Successfully Updated");
                location="settings.php";
                </script>';
            }   
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
        
        function updateChefInfo($conn, $userID, $specialities, $description, $education){
            $stmt = $conn->prepare("UPDATE chef SET specialities=?, description=?, education=? WHERE chefID=?");
          
            // Check if the statement was prepared successfully
            if (!$stmt) {
               die("Error during updateChefInfo preparation: " . $conn->error);
            }
      
            // Bind parameters
            $stmt->bind_param("sssi", $specialities, $description, $education, $userID);
            
            // Check if the parameters were bound successfully
            if (!$stmt) {
               die("Error during updateChefInfo binding: " . $conn->error);
            }
      
            // Execute the statement
            $stmt->execute();
      
            // Check for errors
            if ($stmt->errno) {
                die("Error during updateChefToPremium execution: " . $stmt->error);
            }

            // Check if the statement execution was successful
            if ($stmt->affected_rows > 0) {
               echo '<script type="text/javascript">
                     alert("Profile Successfully Updated");
                     location="settings.php";
                     </script>';
            } 

        }

        function updateChefToPremium($conn){
            $stmt = $conn->prepare("UPDATE chef SET isPremium=? WHERE chefID=?");
            

            // Check if the statement was prepared successfully
            if (!$stmt) {
                die("Error during updateChefInfo preparation: " . $conn->error);
            }
            
            $premium = true;
            $chefId = $this->getChefId();  
            echo "UPDATE chef SET isPremium=$premium WHERE chefID=$chefId";
            // Bind parameters
            $stmt->bind_param("si", $premium, $chefId);  // Pass the variable by reference

            // Check if the parameters were bound successfully
            if (!$stmt->bind_param("si", $premium, $chefId)) {
                die("Error during updateChefInfo binding: " . $stmt->error);
            }

            // Execute the statement
            $stmt->execute();

            // Check for errors during execution
            if ($stmt->errno) {
                echo "Error during updateChefToPremium execution: " . $stmt->error;
            } else {
                // Check if the statement execution was successful
                if ($stmt->affected_rows > 0) {
                    echo '<script type="text/javascript">
                        alert("Thank you for becoming premium!");
                        location="settings.php";
                    </script>';
                } else {
                    echo 'No rows were affected.';
                }
            }

        }
        
    }
    
?>