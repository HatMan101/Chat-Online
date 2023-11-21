<?php
session_start();
require_once 'tables.php';

// SERVER Initials
$DATABASE_HOST = "localhost";
$DATABASE_USER = "root";
$DATABASE_PASS = "V)NGRr9k4[reMnG4";
$DATABASE_NAME = "chat-online";

$_SESSION['conn'] = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}