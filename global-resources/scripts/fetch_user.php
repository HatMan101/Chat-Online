<?php
include '../../server_file.php';

$query = "
SELECT * FROM accounts 
WHERE user_id != '".$_SESSION['user_id']."'
";

$statement = $_SESSION['conn']->prepare($query);

if ($statement->execute()) {
    $result = $statement->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $output = '
    <table class="table table-bordered table-striped">
        <tr>
            <td>Registered Users</td>
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
            <td>'.$row['username']. " - " .$status.'</td>
        </tr>
        ';
    } 

    $output .= '</table>';

    echo $output;
} else {
    // Output or log the error
    echo $statement->error;
}
