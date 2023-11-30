<?php
   include 'includes/config.php';
   include 'class/user_class.php';
   include 'class/customer_class.php';
   include 'class/order_class.php';

   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive CHEF from DB
   ////////////////////////////////////////////////////////////////////////////////////////////////
   function retrieveChef($conn, $userID) {
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

   function retriveCustomer($conn, $userID) {
      $select = "SELECT * FROM user_form WHERE id = $userID";
   
      $customer = new Customer();
   
      $result = mysqli_query($conn, $select);
      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);
         $customer->setId($row["id"]);
         $customer->setName($row["name"]);
         $customer->setLastName($row["lastName"]);
         $customer->setPassword($row["password"]);
         $customer->setEmail($row["email"]);
         $customer->setAddress($row["address"]);
         $customer->setPhone($row["phone"]);
      }

      $selectFromCustomer = "SELECT * FROM customer  WHERE customerID = $userID";
      $resultFromCustomer = mysqli_query($conn, $selectFromCustomer);
      if (mysqli_num_rows($resultFromCustomer) > 0) {
         $rowNew = mysqli_fetch_array($resultFromCustomer);
         $customer->setNumOfPeople($rowNew["numOfPeople"]);
         $customer->setDayTime($rowNew["dayTime"]);
         $customer->setEventDay($rowNew["eventDay"]);
         $customer->setCusineType($rowNew["cusineType"]);
         $customer->setStoveTopType($rowNew["stoveTopType"]);
         $customer->setNumBurners($rowNew["numBurners"]);
         $customer->setOven($rowNew["oven"]);
         $customer->setMealType($rowNew["mealType"]);
         $customer->setRestrictions($rowNew["restrictions"]);
         $customer->setTypeRestrictions($rowNew["typeRestrictions"]);
         $customer->setExtraInfo($rowNew["extraInfo"]);
          
      }         
      return $customer;
   }

   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive CUSTOMER from DB
   ////////////////////////////////////////////////////////////////////////////////////////////////
   function retrivePlates($conn, $userId){
      $query = "SELECT * FROM plate WHERE chefID= '$userId'";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
         echo "<div class='container'><table width='' class='table table-bordered' border='1' >
            <tr>
                  <th>Plate Name</th>
                  <th>Cusine</th>
                  <th>Meal Range</th>
                  <th>Starter Menu</th>
                  <th>First Course</th>
                  <th>Main Course</th>
                  <th>Dessert</th>
                  <th>Action</th>
            </tr>";

         while ($row = $result->fetch_assoc()) {
            $cusineTypeText = "";
            switch($row['cusineType']){
               case '0':
                  $cusineTypeText = 'Mediterranean';
                  break;
               case '1':
                  $cusineTypeText = 'Italian';
                  break;
               case '2':
                  $cusineTypeText = 'French';
                  break;
               case '3':
                  $cusineTypeText = 'Asian';
                  break;
               case '4':
                  $cusineTypeText = 'Latin American';
                  break;
               case '5':
                  $cusineTypeText = 'Other';
                  break;
               default:
                  $cusineTypeText = '';
                  break;
            }

            $mealRangeText = "";
            switch($row['mealRangeType']){
               case '0':
                  $mealRangeText = 'Basic ($190 - $230 per person)';
                  break;
               case '1':
                  $mealRangeText = 'Indulge ($230 - $260 per person)';
                  break;
               case '2':
                  $mealRangeText = 'Exclusive ($260 - $330 per person)';
                  break;
               default:
                  $mealRangeText = 'Other';
                  break;
            }

            echo "<tr>";
            echo "<td>" . $row['plateName'] . "</td>";
            echo "<td>" . $cusineTypeText . "</td>";
            echo "<td>" . $mealRangeText . "</td>";
            echo "<td>" . $row['starterMenu'] . "</td>";
            echo "<td>" . $row['firstCourse'] . "</td>";
            echo "<td>" . $row['mainCourse'] . "</td>";
            echo "<td>" . $row['dessert'] . "</td>";
            echo "<td><form class='form-horizontal' method='post' action='chef_view_plates.php'>
                     <input name='plateID' type='hidden' value='" . $row['plateID'] . "'>
                     <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                     </form></td>";
            echo "</tr>";
         }
         echo "</table></div>";
         echo "</td></tr>";

         // Delete record
         if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<script type="text/javascript">
                     alert("Plate Successfully Deleted");
                     location="chef_view_plates.php";
                  </script>';
         }

         if (isset($_POST['plateID'])) {
            $id = $conn->real_escape_string($_POST['plateID']);
            $sql = $conn->query("DELETE FROM plate WHERE plateID='$id'");
            if (!$sql) {
               echo ("Could not delete rows" . $conn->error);
            }
         }
         echo "</fieldset></form></div></div></div> ";

      }else{
         echo <<<NOPLATE
               The user dont't have any added plate <br>
               <a href="chef_add_plates.php" class="btn">Add Plates</a>
            NOPLATE;
      }

   }

   
   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive Plates from DB for order display on chef profile
   ////////////////////////////////////////////////////////////////////////////////////////////////
   function retrivePlatesForOrder($conn, $userId){
      $query = "SELECT * FROM plate WHERE chefID= '$userId'";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
         echo "<div class='container'><table>
            <tr>
                  <th>Plate Name</th>
                  <th>Cusine</th>
                  <th>Meal Range</th>
                  <th>Starter Menu</th>
                  <th>First Course</th>
                  <th>Main Course</th>
                  <th>Dessert</th>
                  <th>Action</th>
            </tr>";

         while ($row = $result->fetch_assoc()) {
            $cusineTypeText = "";
            switch($row['cusineType']){
               case '0':
                  $cusineTypeText = 'Mediterranean';
                  break;
               case '1':
                  $cusineTypeText = 'Italian';
                  break;
               case '2':
                  $cusineTypeText = 'French';
                  break;
               case '3':
                  $cusineTypeText = 'Asian';
                  break;
               case '4':
                  $cusineTypeText = 'Latin American';
                  break;
               case '5':
                  $cusineTypeText = 'Other';
                  break;
               default:
                  $cusineTypeText = '';
                  break;
            }

            $mealRangeText = "";
            switch($row['mealRangeType']){
               case '0':
                  $mealRangeText = 'Basic';
                  break;
               case '1':
                  $mealRangeText = 'Indulge';
                  break;
               case '2':
                  $mealRangeText = 'Exclusive';
                  break;
               default:
                  $mealRangeText = 'Other';
                  break;
            }
            $plateID = $row['plateID'];
            echo "<tr>";
            echo "<td>" . $row['plateName'] . "</td>";
            echo "<td>" . $cusineTypeText . "</td>";
            echo "<td>" . $mealRangeText . "</td>";
            echo "<td>" . $row['starterMenu'] . "</td>";
            echo "<td>" . $row['firstCourse'] . "</td>";
            echo "<td>" . $row['mainCourse'] . "</td>";
            echo "<td>" . $row['dessert'] . "</td>";
            echo "<td> <button onclick='redirectToProfile($plateID);'>Reserve</button> </td>";
            echo "</tr>";
         }
         echo "</table></div>";
         echo "</td></tr>";

         echo <<<ENDPLATE
         </div>
         <script>
           function redirectToProfile(id) {
               window.location.href = 'orders.php?id=' + id;
           }
         </script>
         ENDPLATE;

      }else{
         echo <<<NOPLATE
               The user dont't have any added plate <br>               
            NOPLATE;
      }

   }

   function sendReview($connection, $orderID, $customerID, $chefID, $today, $nameCustomer, $reviewDescription, $rating, $anonymus){
      if($anonymus == "1"){
         $nameCustomer = "Anonymus";
      }
      $query = "INSERT INTO review (customerID, chefID, dateMsg, nameCustomer, reviewDescription, rating, anonymus) 
      VALUES ('$customerID', '$chefID', '$today','$nameCustomer', '$reviewDescription', '$rating', '$anonymus')";

      // Execute the query
      mysqli_query($connection, $query);

      // Check for errors
      if (mysqli_error($connection)) {
         echo "Error: " . mysqli_error($connection);
      }

      // You may want to add error handling here
      if (mysqli_error($connection)) {
         echo "Error: " . mysqli_error($connection);
      }else {
         updateOrder($connection,$orderID);
         echo '<script type="text/javascript">
            alert("Review sent!");
            location="customer_reviews.php";
            </script>';
     }

   }

   function updateOrder($connection,$orderID){
      $stmt = $connection->prepare("UPDATE orders SET statusOrder=? WHERE orderID=?");
         
      // Check if the statement was prepared successfully
      if (!$stmt) {
         die("Error during updateChefInfo preparation: " . $connection->error);
      }
      $status = 5;
      // Bind parameters
      $stmt->bind_param("ii", $status, $orderID);
      
      // Check if the parameters were bound successfully
      if (!$stmt) {
         die("Error during updateChefInfo binding: " . $connection->error);
      }

      // Execute the statement
      $stmt->execute();
      
   }

   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive REVIEWS from DB for Chef 
   ////////////////////////////////////////////////////////////////////////////////////////////////
   function retriveReview($conn, $userId){
      $query = "SELECT * FROM review WHERE chefID= '$userId'";
      $result = $conn->query($query);

      echo "<div class='content-container'>";
      echo "<h2>Reviews</h2>";
      if ($result->num_rows > 0) {
         echo "<div class='container'><table>
            <tr>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Review</th>
                  <th>Rating</th>                  
            </tr>";

         while ($row = $result->fetch_assoc()) {            
            echo "<tr>";
            echo "<td>" . $row['nameCustomer'] . "</td>";
            echo "<td>" . $row['dateMsg'] . "</td>";
            echo "<td>" . $row['reviewDescription'] . "</td>";
            echo "<td>" . $row['rating'] . "</td>";
            echo "</tr>";
         }
         echo "</table></div>";
         echo "</td></tr>";
         echo "</fieldset></form></div></div></div> ";

      }else{
         echo <<<NOREVIEW
               The user dont't have any review <br>
               NOREVIEW;
      }
   }

   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive REVIEWS from DB for Customer be able to see it 
   ////////////////////////////////////////////////////////////////////////////////////////////////
   function retriveCustomerReviews($conn, $userId){
      $query = "SELECT * FROM review WHERE customerID= '$userId'";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
         echo "<div class='container'><table>
            <tr>
                  <th>Anonymus</th>
                  <th>Date</th>
                  <th>Review</th>
                  <th>Rating</th>
                  <th>Action</th>
            </tr>";

         while ($row = $result->fetch_assoc()) {
            $isAnonymus = ($row['anonymus'] == 0) ? "No" : "Yes";
            echo "<tr>";
            echo "<td>" . $isAnonymus . "</td>";
            echo "<td>" . $row['dateMsg'] . "</td>";
            echo "<td>" . $row['reviewDescription'] . "</td>";
            echo "<td>" . $row['rating'] . "</td>";
            echo "<td><form class='form-horizontal' method='post' action='customer_reviews.php'>
                     <input name='reviewID' type='hidden' value='" . $row['reviewID'] . "'>
                     <input type='submit' class='btn btn-danger' name='delete' value='Delete'>
                     </form></td>";
            echo "</tr>";
         }
         echo "</table></div>";
         echo "</td></tr>";

         // Delete record
         if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<script type="text/javascript">
                     alert("Review Successfully Deleted");
                     location="customer_reviews.php";
                  </script>';
         }

         if (isset($_POST['reviewID'])) {
            $id = $conn->real_escape_string($_POST['reviewID']);
            $sql = $conn->query("DELETE FROM review WHERE reviewID='$id'");
            if (!$sql) {
               echo ("Could not delete rows" . $conn->error);
            }
         }
         echo "</fieldset></form></div></div></div> ";

      }else{
         echo <<<NOREVIEW
               <div>
                  The user didn't made any review <br>
                  <button onclick="location.href = 'customer.php';"">Go Back</button>        
               </div>
               NOREVIEW;
      }

   }

   ////////////////////////////////////////////////////////////////////////////////////////////////
   //// Retrive ORDER from DB 
   ////////////////////////////////////////////////////////////////////////////////////////////////

   function retriveOrders($conn, $orderID) {
      $select = "SELECT * FROM orders WHERE orderID = $orderID";
   
      $order = new Orders();
   
      $result = mysqli_query($conn, $select);

      if (!$result) {
         // Query failed, log the error and return an empty array or handle as needed
         error_log("Query failed: " . $conn->error);
         return array();
      }
 
      
      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);
         $order->setOrderID($row["orderID"]);
         $order->setCustomerID($row["customerID"]);
         $order->setChefID($row["chefID"]);
         $order->setDateExperience($row["dateExperience"]);
         $order->setStatus($row["statusOrder"]);
         $order->setTotal($row["total"]);
      }   

      return $order;
   }

?>