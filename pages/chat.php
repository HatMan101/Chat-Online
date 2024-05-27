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
    <div class="modal" id="addFriendsModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Friends</h5>
                    <button type="button" id="closeFriendsModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-7">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputUsername" placeholder="username#0000" aria-describedby="inputGroupPrepend" required>
                            <div class="input-group-prepend">
                                <button class="input-group-text" id="buttonAddUsername">Add</button>
                            </div>
                            <div class="invalid-feedback" id="addModalErrorMsg">
                                Please choose a username.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="row">
        <section id="userFriend" class="col">
            <div id="userDetails"></div>
        </section>
        <section id="chatWindow" class="col-7">
            <div id="userDialog" class="user_dialog" title="">
                <div class="chat_history" data-touserid="" id=""></div>
                <div class="form-group">
                    <textarea name="" id="" class="form-control chat_message"></textarea>
                </div>
            </div>
        </section>
        <section class="col">
            <p>Friend or server info</p>
            // Skapa en fil där kompisens namn, ID och konto skapades.
            // Skapa en div där ett spel sedan läggs till, 4x4
            <div id="miniGame">

            </div>
        </section>
    </main>
</body>
</html>
