<?php

// All dbt goes here
$_SESSION['accounts'] = "CREATE TABLE accounts (
    user_id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT, AUTO_INCREMENT=4,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    password VARCHAR(100) NOT NULL
)";

$_SESSION['accounts_details'] = "CREATE TABLE accounts_details (
    user_id int(11) NOT NULL PRIMARY KEY,
    last_activity timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_type enum('no', 'yes') NOT NULL
)";


$_SESSION['chat_message'] = "CREATE TABLE chat_message (
    chat_message_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    to_user_id int(11) NOT NULL,
    from_user_id int(11) NOT NULL,
    chat_message text NOT NULL,
    timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status int(1) NOT NULL
)";