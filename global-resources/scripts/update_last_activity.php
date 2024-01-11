<?php
include '../../server_file.php';

$query = "
UPDATE accounts_details
SET last_activity = now()
WHERE user_id = '".$_SESSION['user_id']."'
";

$statement = $_SESSION['conn']->prepare($query);

$statement->execute();
