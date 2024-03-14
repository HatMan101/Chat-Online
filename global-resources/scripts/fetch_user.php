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
SELECT u.username, u.user_id 
FROM user_friend uf
JOIN accounts u ON (uf.uid1 = u.user_id OR uf.uid2 = u.user_id)  
                       AND u.user_id != '".$_SESSION['user_id']."'
WHERE (uf.uid1 = ? AND uf.status = 'REQ_UID2')
OR (uf.uid2 = ? AND uf.status = 'REQ_UID1')
";

$stmt_friend_request = $_SESSION['conn']->prepare($query_friend_request);
$stmt_friend_request->bind_param("ii", $_SESSION['user_id'], $_SESSION['user_id']);

if ($stmt_friend_request->execute()) {
    $result = $stmt_friend_request->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rows as $row) {
        $output .= '
        <tr>
            <td>
                <p>'.$row['username'].'</p>
                <div>
                   <button type="button" name="accept_request" class="accept_friend_request btn btn-success btn-xs" id="'.$row['user_id'].'">Accept</button>
                   <button type="button" name="decline_request" class="deny_friend_request btn btn-danger btn-xs" id="'.$row['user_id'].'">Decline</button>          
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

