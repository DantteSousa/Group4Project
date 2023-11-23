<?php
// Include necessary files or configurations if needed
include 'includes/config.php';
include 'views/helpers_user.php';
include 'class/retriveDB.php';
include 'class/plate.php';

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
$userId = $_SESSION['id'];

// $plates = retrievePlates($userId); 

// Include the header and body functions
header_USER($user_type);


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

    // delete record
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        echo '<script type="text/javascript">
                        alert("Schedule Successfully Deleted");
                            location="chef_view_plates.php";
                            </script>';
    }

    if (isset($_POST['plateID'])) {
        $id = $conn->real_escape_string($_POST['plateID']);
        $sql = $conn->query("DELETE FROM plate WHERE id='$plateID'");
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
// close connection
$conn->close();


footer_USER();

?>


