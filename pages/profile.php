<?php
session_start();
if (!isset($_SESSION['logged-in'])) {
    header('Location: login.php');
    exit();
}
require_once '../dbFiles/dbProfile.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>Features</title>
    <?php require_once '../components/head.html'; ?>
</head>
<body>
    <?php require_once '../components/navbar.html'; ?>
    <main>
        <div class="content">
            <h2>Profile Page</h2>
            <div>
                <p>Your account details are below:</p>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><?=$_SESSION['name']?></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><?=$password?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?=$email?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
    <?php require_once '../components/footer.html'; ?>
</body>
</html>
