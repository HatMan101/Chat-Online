<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit;
}
// require 'resources/chat/dbChat.php';
require_once '../global-resources/components/head.html';
require_once '../global-resources/components/navbar/navbar.html';
?>
<!doctype html>
<html lang="en" class="light">
<head>
    <title>Chat-Online</title>
</head>
<body>
    <main class="row">
        <section class="col">
            <h1>Chat Window</h1>
        </section>
        <section id="chatWindow" class="col-6">
            <p>This is the chat window</p>
        </section>
        <section class="col">
            <p>Friend or server info</p>
        </section>
    </main>
</body>
</html>
