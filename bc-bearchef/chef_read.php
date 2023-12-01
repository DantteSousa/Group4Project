<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include "views/helpers_HTML.php";

// Start the session
session_start();

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
retrieve_messages_from_chef($conn, $userID);
chef_bottom();
footer_USER();

function retrieve_messages_from_chef($conn, $userId){
    $query = "SELECT * FROM messages WHERE senderID= '$userId' OR receiverID = '$userId'";
    $result = $conn->query($query);

    echo "<div class='content-container'>";
    echo "";
    if (!$result) {
       // Handle query error
       echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo "<div class='table-order'>
                <table>
                <h2>Messages</h2>                      
                <tr>
                    <th>OrderID</th>
                    <th>Date</th>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Message</th> 
                    <th>Send message</th>                 
            </tr>";
            $sender= "";
            $receiver = "";
            
        while ($row = $result->fetch_assoc()) {     
            if($row['senderID'] == $userId){
                $sender = "You";
                $customer = retriveCustomer($conn, $row['senderID']);
                $receiver = $customer->getName();
            }else{
                $customer = retriveCustomer($conn, $row['receiverID']);
                $sender = $customer->getName();
                $receiver = "You";
            } 
            echo "<tr>";
            echo "<td> #" . $row['orderID']. "</td>";
            echo "<td>" . $row['dateMsg'] . "</td>";
            echo "<td>" . $sender . "</td>";
            echo "<td>" . $receiver ."</td>";
            echo "<td>" . $row['textMsg'] . "</td>";
            echo "<td> <a href='chef_messages.php?orderID=" . $row['orderID'] . "' class='btn btn-danger'>Message</a></td>";
            echo "</tr>";
        }
        echo "</table></div>";
        echo "</td></tr>";
        echo "</fieldset></form></div></div></div> ";
    } else {
       echo <<<NOORDER
        The user doesn't have any messages <br>
        NOORDER;
    }
}

?>