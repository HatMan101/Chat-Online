<?php
include '../../server_file.php';

$_SESSION['user_id'] = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
$_POST['friend_id'] = filter_var($_POST['friend_id'], FILTER_SANITIZE_NUMBER_INT);

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