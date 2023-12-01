<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'views/helpers_HTML.php';
include 'class/retriveDB.php';

// Start the session
session_start();

// Check if the user is logged in as a chef
$user_type = 'chef';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];
head_HTML();
header_USER('chef');
chef_top();
retrivePendingOrders($conn, $userID);
chef_bottom();
footer_USER();

function retrivePendingOrders($conn, $userId){
    $query = "SELECT * FROM orders WHERE chefID= '$userId' AND statusOrder = '0'";
    $result = $conn->query($query);

    echo "<div class='content-container'>";
    echo "";
    if ($result->num_rows > 0) {
      echo "<div class='container'><table>
          <caption><h2>Pending Orders</caption>
          <tr>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Total of Order</th>
                <th>Details</th> 
                <th>Accept Order</th>
                <th>Cancel Order</th>                 
          </tr>";

      while ($row = $result->fetch_assoc()) {  
          $customer = retriveCustomer($conn,$row['customerID']);


         echo "<tr>";
         echo "<td>" . $customer->getName() . "</td>";
         echo "<td>" . $row['dateExperience'] . "</td>";
         echo "<td> CAD$ " . $row['total'] . ".00</td>";
         echo <<<DETAILS
                <td>  
                   Number of people: {$customer->getNumOfPeople()} <br>
                   Time of the day: {$customer->getStringDayTime()}<br>
                   Stove Top Type: {$customer->getStringStoveTopType()}<br>
                   Plate Choosen: *COLOCAR O ID + O NOME DO PRATO* <br>
                   Restrictions: {$customer->doesHaveRestriction()}<br>
                   Extra Info: {$customer->getExtraInfo()}<br><br>
                </td>
                DETAILS;
         echo "<td><form class='form-horizontal' method='post' action='chef_pending_orders.php'>
             <input name='orderID' type='hidden' value='" . $row['orderID'] . "'>
             <input type='submit' class='btn btn-danger' name='accept' value='Accept'>
             </form></td>";
         echo "<td><form class='form-horizontal' method='post' action='chef_pending_orders.php'>
                <input name='orderID' type='hidden' value='" . $row['orderID'] . "'>
                <input type='submit' class='btn btn-danger' name='reject' value='Reject'>
                </form></td>";
         echo "</tr>";
       }
      echo "</table></div>";
      echo "</td></tr>";
      echo "</fieldset></form></div></div></div> ";

      if (isset($_POST['accept'])) {
            $orderID = $conn->real_escape_string($_POST['orderID']);
            // Update the database to mark the order as accepted
            $updateQuery = "UPDATE orders SET statusOrder = '2' WHERE orderID = '$orderID'";
            $conn->query($updateQuery);
            echo '<script type="text/javascript">
                        alert("Order Accepted");
                        location="chef_accepted_orders.php";
                    </script>';
      } elseif (isset($_POST['reject'])) {
            $orderID = $conn->real_escape_string($_POST['orderID']);
            // Update the database to mark the order as canceled
            $updateQuery = "UPDATE orders SET statusOrder = '3' WHERE orderID = '$orderID'";
            $conn->query($updateQuery);
            echo '<script type="text/javascript">
                        alert("Order Rejected");
                        location="chef_pending_orders.php";
                    </script>';
      }


   }else{
      echo <<<NOORDER
            The user dont't have any pending order <br>
            NOORDER;
   }
}
?>



