<?php
    include 'includes/config.php';
    include 'class/user_class.php';

    function retrieveChef($conn, $userID) {
        $userID = $GLOBALS['userId'];
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
     
        $id = $chef->getId();
     
        if (isset($id)) {
           $selectFromChef = "SELECT * FROM chef WHERE chefID = $id";
           $resultFromChef = mysqli_query($conn, $selectFromChef);
           if (mysqli_num_rows($resultFromChef) > 0) {
              $rowNew = mysqli_fetch_array($resultFromChef);
              $chef->setSpecialities($rowNew["specialities"]);
              $chef->setDescription($rowNew["description"]);
              $chef->setEducation($rowNew["education"]);
              $chef->setPlates($rowNew["plates"]);
              $chef->setIsPremium($rowNew["isPremium"]);
           }
    
        }

        return $chef;
    }
?>