<?php
// Initials
const DB_SERVER = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "6K[6O8*SCI7JY)dV";
const DB_NAME = "chat-online";

// Connect to db
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli -> connect_error) {
    die("ERROR could not connect: " . $mysqli -> connect_error);
}
include_once "pages/login.php";