<?php
include '../../server_file.php';

$query ="";
if ($_SESSION['user_id'] < $_POST['friend_id']) {
    $query = "
    UPDATE user_friend 
    SET status = 'FRIEND' 
    WHERE uid1 = $_SESSION[user_id] AND uid2 = $_POST[friend_id]
    ";
} else if ($_SESSION['user_id'] > $_POST['friend_id']) {
    $query = "
    UPDATE user_friend 
    SET status = 'FRIEND' 
    WHERE uid1 = $_POST[friend_id] AND uid2 = $_SESSION[user_id]
    ";
}

$stmt = $_SESSION['conn']->prepare($query);
$stmt->execute();