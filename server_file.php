<?php
session_start();
require_once 'tables.php';

// SERVER Initials
$DATABASE_HOST = "localhost";
$DATABASE_USER = "root";
$DATABASE_PASS = "V)NGRr9k4[reMnG4";
$DATABASE_NAME = "chat-online";

$_SESSION['conn'] = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
function fetch_user_last_activity($user_id) {
    $query = "
        SELECT last_activity FROM accounts_details
        WHERE user_id = ?
        ORDER BY last_activity DESC
        LIMIT 1
    ";

    $statement = $_SESSION['conn']->prepare($query);
    $statement->bind_param("i", $user_id);  // Assuming user_id is an integer, adjust "i" accordingly
    $statement->execute();

    $result = $statement->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        return $row['last_activity'];
    } else {
        // Handle no results found if needed
        return null;
    }
}

function fetch_user_chat_history($from_user_id, $to_user_id) {
    $query = "
    SELECT * FROM chat_message
    WHERE (from_user_id = ? AND to_user_id = ?)
    OR (from_user_id = ? AND to_user_id = ?)
    ORDER BY timestamp DESC
    ";

    $statement = $_SESSION['conn']->prepare($query);
    $statement->bind_param("iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
    $statement->execute();

    $result = $statement->get_result();

    $output = '<ul class="list-unstyled">';

    while ($row = $result->fetch_assoc()) {
        $user_name = '';
        if ($row['from_user_id'] === $from_user_id) {
            $user_name = '<b class="text-success">You</b>';
        } else {
            $user_name = '<b class="text-danger">' . get_user_name($row['from_user_id']) . '</b>';
        }
        $output .= '
            <li>
                <p>' . $user_name . ' - ' . $row['chat_message'] . '
                    <div>
                        - <small><em>' . $row['timestamp'] . '</em></small>
                    </div>
                </p>
            </li>
        ';
    }

    $output .= '</ul>';
    return $output;
}

function get_user_name($user_id) {
    $query = "SELECT username FROM accounts WHERE user_id = ?";
    $statement = $_SESSION['conn']->prepare($query);
    $statement->bind_param("i", $user_id);
    $statement->execute();
    $result = $statement->get_result();

    while ($row = $result->fetch_assoc()) {
        return $row['username'];
    }
}