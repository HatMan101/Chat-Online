<?php
require "../../server_file.php";

$_POST['chat_message'] = filter_var($_POST['chat_message'], FILTER_SANITIZE_SPECIAL_CHARS);

$data = array(
    $_POST['to_user_id'],
    $_SESSION['user_id'],
    '1',
    $_POST['chat_message']
);

$query = "
INSERT INTO chat_message
(to_user_id, from_user_id, status, chat_message)
VALUES (?, ?, ?, ?)
";

$statement = $_SESSION['conn']->prepare($query);

if ($statement) {
    $statement->bind_param("iiis", $data[0], $data[1], $data[2], $data[3]);

    if ($statement->execute()) {
        echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id']);
    } else {
        echo "Execute failed: " . $statement->error;
    }
} else {
    echo "Prepare failed: " . $_SESSION['conn']->error;
}