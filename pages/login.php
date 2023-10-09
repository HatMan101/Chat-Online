<!doctype html>
<html lang="en">
<head>
    <title>Sign-In</title>
    <?php require_once "components/head.html"; ?>
    <?php require_once "dbFiles/loginDB.php"?>
</head>
<body>
    <?php require_once "components/header.html"; ?>
    <main>
        <div class="login">
            <h1>Login</h1>
            <form action="authenticate.php" method="post">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <input type="submit" value="Login">
            </form>
        </div>

    </main>
    <?php include_once "components/footer.html"; ?>
</body>
</html>