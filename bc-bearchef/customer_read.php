<?php
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

header_USER('customer');
retrieve_messages_from_customer($conn);
footer_USER();

function retrieve_messages_from_customer($conn){
    $userID = $GLOBALS['userID'];
    $query = "SELECT * FROM messages WHERE senderID = '$userID' OR receiverID = '$userID' ORDER BY 'dateExperience' DESC";
    $result = $conn->query($query);

    echo "<div class='content-container'>";
    echo "";
    if (!$result) {
       // Handle query error
       echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo "<div class='container'><table>
            <caption><h2>Messages</caption></h2>
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
            if($row['senderID'] == $userID){
                $sender = "You";
                $chef = retrieveChef($conn, $row['receiverID']);
                $receiver = $chef->getName();
            }else{
                $chef = retrieveChef($conn, $row['senderID']);
                $sender = $chef->getName();
                $receiver = "You";
            } 
            echo "<tr>";
            echo "<td> #" . $row['orderID']. "</td>";
            echo "<td>" . $row['dateMsg'] . "</td>";
            echo "<td>" . $sender . "</td>";
            echo "<td>" . $receiver ."</td>";
            echo "<td>" . $row['textMsg'] . "</td>";
            echo "<td> <a href='customer_messages.php?orderID=" . $row['orderID'] . "' class='btn btn-danger'>Message</a></td>";
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