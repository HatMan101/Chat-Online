<?php
require 'server_file.php';

$_POST["username"] = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
$_POST["password"] = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $_SESSION['conn']->prepare('SELECT user_id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', trim($_POST['username']));
    $stmt->execute();
    // Store the result, we can check if the account exists in the database.
    $stmt->store_result();

    $user_id = null;
    $password = null;

    if ($stmt->num_rows > 0) {        // Account exists, now we verify the password.
        $stmt->bind_result($user_id, $password);
        $stmt->fetch();

        // Using password_hash
        if (password_verify(trim($_POST['password']), $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['logged-in'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['user_id'] = $user_id;
            header("Location: pages/chat.php");
            exit();
        }

        // Incorrect password
        //echo 'Incorrect username and/or password!';
        echo 'Invalid password';
    } else {
        // Incorrect username
        echo 'Invalid username';
    }

    $stmt->close();
}
