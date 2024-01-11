<!doctype html>
<html lang="en">
<head>
    <title>Registration</title>
    <?php require_once "../global-resources/components/head.html"; ?>
</head>
<body>
    <main>
        <div class="register">
            <h1>Register</h1>
            <form action="resources/registration/dbRegistration.php" method="post" autocomplete="off">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <label for="email">
                    <i class="fas fa-envelope"></i>
                </label>
                <input type="email" name="email" placeholder="Email" id="email" required>
                <input type="submit" value="Register">
            </form>
        </div>
        <p>If you already have an account. Please login <a href="login.php">HERE</a></p>
    </main>
</body>
</html>