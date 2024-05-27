<?php
require __DIR__ . '/../../../server_file.php';

$_POST["username"] = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$_POST["password"] = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
$_POST["email"] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Could not get the data that should have been sent.
    die('Please complete the registration form!');
}
// Submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    // One or more values are empty.
    die('Please complete the registration form');
}

// Check if the account with that username exists.
if ($stmt = $_SESSION['conn']->prepare('SELECT user_id, password FROM accounts WHERE username = ?')) {
    // Bind parameters, hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result, we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'Username exists, please choose another!';
    } else if ($stmt = $_SESSION['conn']->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
        // Username do not exist, insert new account
        // Hash the password, and use password_verify when login-in
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
        $stmt->execute();

        $statement = $_SESSION['conn']->prepare('SELECT user_id FROM accounts WHERE username = ? AND password = ?');
        $statement->bind_param('ss', $_POST['username'], $password);  // Assuming both username and password are strings, adjust "ss" accordingly
        $statement->execute();
        $userId = 0;
        $statement->bind_result($userId);

        if ($statement->fetch()) {
            $statement->close();
            // Rows exist, $userId contains the user id
            $less_statement = $_SESSION['conn']->prepare('INSERT INTO accounts_details (user_id) VALUES (?)');
            $less_statement->bind_param('i', $userId);
            $less_statement->execute();
            $less_statement->close();
            header('Location: ../../login.php');
        } else {
            // No matching user found
            echo "No data to insert";
        }
    } else {
        // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all three fields.
        echo 'Could not prepare statement!';
    }
    $stmt -> close();
} else {
    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
    echo 'Could not prepare statement!';
}
