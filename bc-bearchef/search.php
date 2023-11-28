<?php
include 'includes/config.php';
include 'views/helpers_user.php';
include "views/helpers_HTML.php";

session_start();
$user_chef = 'chef';
$user_customer = 'customer';


if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_chef) {
    header_USER($user_chef);
} elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] == $user_customer) {
    header_USER($user_customer);
}else{
    header_HTML();
}
search($conn);
footer_HTML();

function search($conn){
    
    $query = "SELECT * FROM user_form WHERE user_type= 'chef'";
    $result = $conn->query($query);

    echo "<div class='content-container'>";
    echo "<h2>Chefs</h2>";
    if ($result->num_rows > 0) {
       echo "<div class='container'><table width='' class='table table-bordered' border='1' >
          <tr>
                <th>Chef name</th>
                <th>Date</th>
                <th>Review</th>
                <th>Rating</th>                  
          </tr>";

       while ($row = $result->fetch_assoc()) {            
          echo "<tr>";
          echo "<td>" . $row['name'] . " ".$row['lastName']. "</td>";
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
    echo <<<ENDREVIEW
       <button onclick="location.href = 'index.php';"">Go Back</button>
       </div>
       ENDREVIEW;

    // close connection
    $conn->close();

}
?>