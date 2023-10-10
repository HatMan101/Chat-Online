<?php
session_start();
include 'tables.php';

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


// Skapa/checka om bordet finns
if (!$conn -> query($_SESSION['accounts']) === TRUE) {
    echo "Error creating table: " . $conn -> connect_error;
}


// Kollar efter användar och lösenord
if (!isset($_POST['username'], $_POST['password'])) {
    die('Please fill both the username and password fields!');
}

if ($stmt = $conn -> prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt -> bind_param('s', $_POST['username']);
    $stmt -> execute();

    $stmt -> store_result();
    if ($stmt -> num_rows > 0) {
        $stmt -> bind_result($id, $password);
        $stmt -> fetch();

        // Om kontot finns, verifiera lösenordet
        if ($_POST['password'] === $password) {
            // Användaren loggas in
            // Använd sessions, är typ som cookies
            session_regenerate_id();
            $_SESSION['logged-in'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: pages/chat.php');
        } else {
            // Fel lösenord
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Fel användarnamn
        echo 'Incorrect username and/or password!';
    }

    $stmt -> close();
}

$conn -> close();