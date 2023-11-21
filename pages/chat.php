<?php

if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit;
}
require 'resources/chat/dbChat.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>Chat-Online</title>
    <?php require_once '../global-resources/components/head/head.html'; ?>
</head>
<body>
    <?php require_once '../global-resources/components/navbar/navbar.html'; ?>
    <main>
        <h1>Chat Window</h1>
    </main>
</body>
</html>
