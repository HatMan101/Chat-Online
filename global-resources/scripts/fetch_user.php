<?php
include '../../server_file.php';

$output = '';

// Load/retrieve friend list
$query_friend_list = "
SELECT * FROM user_friend 
WHERE (uid1 = $_SESSION[user_id] AND status = 'FRIEND')
OR (uid2 = $_SESSION[user_id] AND status = 'FRIEND')
";

$stmt_friend_list = $_SESSION['conn']->prepare($query_friend_list);

if ($stmt_friend_list->execute()) {
    $result = $stmt_friend_list->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $output = '
    <table class="table table-bordered table-striped">
        <tr>
            <td>Friends</td>
        </tr>
    ';

    foreach ($rows as $row) {
        $status = '';
        $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        $user_last_activity = fetch_user_last_activity($row['user_id']);

        if ($user_last_activity > $current_timestamp) {
           $status = '<span class="label label-success">Online</span>';
        } else {
            $status = '<span class="label label-danger">Offline</span>';
        }

        $output .= '
        <tr class="start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">
            <td>'.$row['username']. " - " .$status .count_unseen_message($row['user_id'], $_SESSION['user_id']) .fetch_is_type_status($row['user_id']).'</td>
        </tr>
        ';
    }
    $output .= '
    </table>
    <table class="table table-bordered table-striped">
        <tr>
            <td>Friend Request</td>
        </tr>';
} else {
    // Output or log the error
    echo $stmt_friend_list->error;
}

// Friend request
$query_friend_request = "
SELECT * FROM user_friend 
WHERE (uid1 = $_SESSION[user_id] AND status = 'REQ_UID2')
OR (uid2 = $_SESSION[user_id] AND status = 'REQ_UID1')
";

$stmt_friend_request = $_SESSION['conn']->prepare($query_friend_request);

if ($stmt_friend_request->execute()) {
    $result = $stmt_friend_request->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

}


echo $output;

