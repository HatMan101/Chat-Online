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
            <div id="userDetails"></div>
        </section>
        <section id="chatWindow" class="col-7">
            <div id="userDialog" class="user_dialog" title="">
                <div class="chat_history" data-touserid="" id=""></div>
                <div class="form-group">
                    <textarea name="" id="" class="form-control"></textarea>
                </div><div class="form-group">
                    <button type="button" name="send_chat" id="" class="send_chat">Send</button>
                </div>
            </div>
        </section>
        <section class="col">
            <p>Friend or server info</p>
        </section>
    </main>
</body>
</html>
