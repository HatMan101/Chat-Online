<?php
include '../../server_file.php';

// Check if a already made friend request exist between two users
$query_check = "
SELECT COUNT(*) as count 
FROM user_friend 
WHERE (uid1 = ? AND uid2 = ?) OR (uid1 = ? AND uid2 = ?)
";
$stmt_check = $_SESSION['conn']->prepare($query_check);
$stmt_check->bind_param("iiii", $_SESSION['user_id'], $_POST['friend_id'], $_POST['friend_id'], $_SESSION['user_id']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] > 0) {
    // The relationship already exists in the database"
    exit();
}

$query ="";
if ($_SESSION['user_id'] < $_POST['friend_id']) {
    $query = "
    INSERT INTO user_friend (uid1, uid2, status)
    VALUES ('$_SESSION[user_id]', '$_POST[friend_id]', 'REQ_UID1')
    ";
} else if ($_SESSION['user_id'] > $_POST['friend_id']) {
    $query = "
    INSERT INTO user_friend (uid1, uid2, status)
    VALUES ('$_POST[friend_id]', '$_SESSION[user_id]', 'REQ_UID2')
    ";
}

$stmt = $_SESSION['conn']->prepare($query);
$stmt->execute();