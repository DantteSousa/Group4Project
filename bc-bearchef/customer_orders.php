<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';

// Start the session
session_start();

// Check if the user is logged in as a chef
$user_type = 'customer';
if (!(isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_type)) {
    // Redirect to login page or handle unauthorized access
    header("Location: login_form.php");
    exit();
}

// Retrieve user information from the session
$userType = $_SESSION['user_type'];
$userID = $_SESSION['userID'];

head_HTML();
header_USER('customer');
seeOrders($conn, $userID);
footer_USER();

function seeOrders($conn, $userID){
    $query = "SELECT * FROM orders WHERE customerID= '$userID'";
    $result = $conn->query($query);

    echo "<div class='content-container'>";
    echo "";
    if ($result->num_rows > 0) {
       echo "<div class='container'><table>
          <caption><h2>Orders</h2></caption>
          <tr>
                <th>Order ID</th>
                <th>Chef Name</th>
                <th>Date</th>
                <th>Details</th> 
                <th>Total of Order</th>
                <th>Order Status</th>
                <th>Send Message</th>
                <th>Cancel Order</th>                 
          </tr>";

       while ($row = $result->fetch_assoc()) {  
            $customer = retriveCustomer($conn,$row['customerID']);
            $chef = retrieveChef($conn,$row['chefID']);
            $order = retriveOrders($conn,$row['orderID']);

            echo "<tr>";
            echo "<td>" . $row['orderID'] . "</td>";
            echo "<td>" . $chef->getName() . "</td>";
            echo "<td>" . $row['dateExperience'] . "</td>";            
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
            echo "<td> CAD$ " . $row['total'] . ".00</td>";
            echo "<td> {$order->statusString()}</td>";
            if($order->getStatus() == "3" || $order->getStatus() == "5") {
                echo "<td></td>";
                echo "<td></td>";
            }elseif($order->getStatus() == "4"){
                echo "<td> <a href='customer_write_review.php?orderID=" . $row['orderID'] . "' class='btn btn-danger'>Write Review</a>
                </td>";
                echo "<td></td>";
            }else{
                echo "<td> <a href='customer_messages.php?orderID=" . $row['orderID'] . "' class='btn btn-danger'>Message</a>
                </td>";
                echo "<td><form class='form-horizontal' method='post' action='customer_orders.php'>
                <input name='orderID' type='hidden' value='" . $row['orderID'] . "'>
                <input type='submit' class='btn btn-danger' name='reject' value='Cancel'>
                </form></td>";
            }
            
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
                        location="customer_orders.php";
                    </script>';
        } elseif (isset($_POST['reject'])) {
            $orderID = $conn->real_escape_string($_POST['orderID']);
            // Update the database to mark the order as canceled
            $updateQuery = "UPDATE orders SET statusOrder = '3' WHERE orderID = '$orderID'";
            $conn->query($updateQuery);
            echo '<script type="text/javascript">
                        alert("Order Canceled");
                        location="customer_orders.php";
                    </script>';
        }


    }else{
       echo <<<NOORDER
             The user don't have any pending order <br>
             NOORDER;
    }
 }
?>



