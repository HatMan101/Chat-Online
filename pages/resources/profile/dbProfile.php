<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '6K[6O8*SCI7JY)dV';
$DATABASE_NAME = 'chat-online';
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $conn -> prepare('SELECT password, email FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt -> bind_param('i', $_SESSION['id']);
$stmt -> execute();
$stmt -> bind_result($password, $email);
$stmt -> fetch();
$stmt -> close();