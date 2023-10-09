<?php
session_start();
include 'tables.php';
include_once "pages/login.php";

// Initials
$DATABASE_HOST = "localhost";
$DATABASE_USER = "root";
$DATABASE_PASS = "6K[6O8*SCI7JY)dV";
$DATABASE_NAME = "chat-online";

// Connect to DB
$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ($conn -> connect_error) {
    // If error, stop and display error
    die('Failed to connect to MySQL: ' . $conn -> connect_error);
}

if ($conn -> query($_SESSION['accounts']) === TRUE) {
    echo "Table created successfully or already exist";
} else {
    echo "Error creating table: " . $conn -> connect_error;
}



$conn -> close();
session_abort();