<?php
include '../../server_file.php';

$query ="
UPDATE accounts_details
SET is_type = '".$_POST['is_type']."'
WHERE user_id = '".$_SESSION['user_id']."'
";

$stmt = $_SESSION['conn']->prepare($query);
$stmt->execute();