<?php
require 'server_file.php';

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $_SESSION['conn'] -> prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt -> bind_param('s', $_POST['username']);
    $stmt -> execute();
    // Store the result, we can check if the account exists in the database.
    $stmt -> store_result();

    $id = null;
    $password = null;

    if ($stmt -> num_rows > 0) {        // Account exists, now we verify the password.
        $stmt -> bind_result($id, $password);
        $stmt -> fetch();

        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['logged-in'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
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
