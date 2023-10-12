<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit();
}
require '../dbFiles/dbChat.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>Chat-Online</title>
    <?php require_once '../components/head.html'; ?>
</head>
<body>
    <?php require_once '../components/navbar.html'; ?>
    <main>
        <h1>Chat Window</h1>
    </main>
</body>
</html>
