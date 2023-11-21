<?php
   include 'includes/config.php';
   include 'class/user_class.php';

   function retrieveChef($conn, $userID) {
      // $userID = $GLOBALS['userId'];
      $select = "SELECT * FROM user_form WHERE id = $userID";
   
      $chef = new Chef();
   
      $result = mysqli_query($conn, $select);
      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);
         $chef->setId($row["id"]);
         $chef->setName($row["name"]);
         $chef->setLastName($row["lastName"]);
         $chef->setPassword($row["password"]);
         $chef->setEmail($row["email"]);
         $chef->setAddress($row["address"]);
         $chef->setPhone($row["phone"]);
      }
   

      $selectFromChef = "SELECT * FROM chef WHERE chefID = $userID";
      $resultFromChef = mysqli_query($conn, $selectFromChef);
      if (mysqli_num_rows($resultFromChef) > 0) {
         $rowNew = mysqli_fetch_array($resultFromChef);
         $chef->setSpecialities($rowNew["specialities"]);
         $chef->setDescription($rowNew["description"]);
         $chef->setEducation($rowNew["education"]);
         $chef->setPlates($rowNew["plates"]);
         $chef->setIsPremium($rowNew["isPremium"]);
      }   
      return $chef;
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
         echo <<<GOBACK
               <div><h3> Profile updated successfully! </h3> <br>
               GOBACK;
      } else {
         echo <<<GOBACK
            <div><h3> No changes made to the profile. </h3> <br>
        GOBACK;
      }
  
      // Close the statement
      $stmt->close();
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

      // Check if the statement execution was successful
      if ($stmt->affected_rows > 0) {
         echo <<<GOBACK
               <div><h3> Profile updated successfully! </h3> <br>
               GOBACK;
      } else {
         echo <<<GOBACK
            <div><h3> No changes made to the profile. </h3> <br>
            GOBACK;
      }
  
      // Close the statement
      $stmt->close();
   }
?>