<?php

$servername = 'localhost';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Database name
$dbname = 'euVouChorar';

// Check if the database exists
if (!mysqli_select_db($conn, $dbname)) {
    // If the database doesn't exist, create it
    $createDbQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
    
    if ($conn->query($createDbQuery) === TRUE) {
        echo "Database created successfully\n";
    } else {
        echo "Error creating database: " . $conn->error . "\n";
        exit(); // exit if there's an error creating the database
    }
}

// Close the connection
$conn->close();

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Creation of Tables

// Select the database
mysqli_select_db($conn, $dbname);

// USER TABLE ===============================================
$tableName = 'user_form';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        lastName VARCHAR(30),
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        user_type VARCHAR(50) NOT NULL,
        address VARCHAR(220),
        phone VARCHAR(50)
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}

// CHEF TABLE ===============================================
$tableName = 'chef';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE $tableName (
            chefID INT PRIMARY KEY,
            specialities VARCHAR(255),
            description TEXT,
            education VARCHAR(255),
            plates TEXT,
            isPremium BOOLEAN
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}

// Customer TABLE ===============================================
$tableName = 'customer';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE $tableName (
            customerID INT PRIMARY KEY,
            experienceID INT
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}

$tableName = 'order';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE `$tableName` (
            orderID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            customerID INT,
            chefID INT,
            dateExperienceID VARCHAR(255),
            statusOrder INT
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}


// Plate TABLE ===============================================

$tableName = 'plate';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE `$tableName` (
            plateID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            chefID INT,
            cusineType INT,
            mealRangeType INT,
            plateName VARCHAR(255),
            starterMenu TEXT,
            firstCourse TEXT,
            mainCourse TEXT,
            dessert TEXT
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}

// EXPERIENCE TABLE ===============================================

$tableName = 'experienceDetail';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE `$tableName` (
            experienceID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            customerID INT,
            numOfPeople INT,
            dayTime INT,
            eventDay VARCHAR(255),
            cusineType INT,
            stoveTopType INT,
            numBurners INT,
            oven BOOLEAN,
            mealType INT,
            restrictions BOOLEAN,
            typeRestrictions TEXT,
            extraInfo TEXT
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}


// MESSAGE TABLE ===============================================

$tableName = 'message';
$tableExistsQuery = "SELECT * FROM `$tableName`";
$tableExists = mysqli_query($conn, $tableExistsQuery);

if (!$tableExists) {
    // If the table doesn't exist, create it
    $createTableQuery = "CREATE TABLE `$tableName` (
            messageID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            senderID INT,
            receiverID INT,
            dateMsg VARCHAR(255),
            textMsg TEXT
    )";

    if ($conn->query($createTableQuery) === FALSE) {
       echo "Error creating table: " . $conn->error . "\n";
    }
}

?>
