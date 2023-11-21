<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Settings</title>
    <?php require_once '../global-resources/components/head/head.html'; ?>
</head>
<body>
    <?php require_once '../global-resources/components/navbar/navbar.html'; ?>
    <main>
        <h1>Settings</h1>
    </main>
</body>
</html>
