<?php
include '../../server_file.php';

$output = '';

// Load/retrieve friend list
$query_friend_list = "
SELECT accounts.user_id AS user_id, accounts.username 
FROM user_friend
JOIN accounts ON user_friend.uid1 = accounts.user_id OR user_friend.uid2 = accounts.user_id
WHERE ((user_friend.uid1 = $_SESSION[user_id] AND user_friend.status = 'FRIEND' AND accounts.user_id != $_SESSION[user_id])
OR (user_friend.uid2 = $_SESSION[user_id] AND user_friend.status = 'FRIEND' AND accounts.user_id != $_SESSION[user_id]))
";

$stmt_friend_list = $_SESSION['conn']->prepare($query_friend_list);
// $stmt_friend_list->bind_param("iiiiii", $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_SESSION['user_id']);

if ($stmt_friend_list->execute()) {
    $result = $stmt_friend_list->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $output = '
    <table class="friends_table table table-bordered table-striped">
        <tr>
            <td>
                <div>
                    <p><b>Friends</b></p>
                    <p id="openFriendsModal">Add <b>+</b></p>
                </div>
            </td>
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
    <table class="friend_request_table table table-bordered table-striped">
        <tr>
            <th>Friend Request</th>
        </tr>';
} else {
    // Output or log the error
    echo $stmt_friend_list->error;
}


// Friend request
$query_friend_request = "
SELECT uf.*, a.username AS friend_username
FROM user_friend uf
JOIN accounts a ON (uf.uid1 = a.user_id OR uf.uid2 = a.user_id)
WHERE ((uf.uid1 = ? AND uf.status = 'REQ_UID2' AND uf.uid2 != ?)
       OR (uf.uid2 = ? AND uf.status = 'REQ_UID1' AND uf.uid1 != ?))
       AND a.user_id != ?
";

$stmt_friend_request = $_SESSION['conn']->prepare($query_friend_request);
$user_id = $_SESSION['user_id'];
$stmt_friend_request->bind_param("iiiii", $user_id, $user_id, $user_id, $user_id, $user_id);

if ($stmt_friend_request->execute()) {
    $result = $stmt_friend_request->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        $friend_id = 0;
        if ($row['uid1'] === $_SESSION['user_id']) {
            $friend_id = $row['uid2'];
        } else {
            $friend_id = $row['uid1'];
        }
        $output .= '
        <tr>
            <td>
                <p>'.$row['friend_username'].'</p>
                <div>
                   <button type="button" name="accept_request" class="accept_friend_request btn btn-success btn-xs" id="'.$friend_id.'">Accept</button>
                   <button type="button" name="decline_request" class="deny_friend_request btn btn-danger btn-xs" id="'.$friend_id.'">Decline</button>          
                </div>
            </td>
        </tr>
        ';
    }
} else {
    // Output or log the error
    echo $stmt_friend_request->error;
}


echo $output;

