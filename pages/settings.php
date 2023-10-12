<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Settings</title>
    <?php require_once '../components/head.html'; ?>
</head>
<body>
    <?php require_once '../components/navbar.html'; ?>
    <main>
        <h1>Settings</h1>
    </main>
</body>
</html>
