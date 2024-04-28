<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$db="ChessProgram";

function createConnection($servername, $username, $password) {
    $conn = mysqli_connect($servername, $username, $password);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function createDatabase($conn) {
    $sql = "CREATE DATABASE IF NOT EXISTS ChessProgram";
    if (mysqli_query($conn, $sql)) {
        // echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }
}

function connectToDatabase($servername, $username, $password, $database) {
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully";
    return $conn;
}

function createUserTable($conn, $database) {
    mysqli_select_db($conn, $database);
    $sql = "CREATE TABLE IF NOT EXISTS userData (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50),
        email VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if (mysqli_query($conn, $sql)) {
        // echo "Table userData created successfully<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }
}

$conn = createConnection($servername, $username, $password);

createDatabase($conn);

createUserTable($conn, $db);

mysqli_close($conn);

$conn = connectToDatabase($servername, $username, $password, $db);