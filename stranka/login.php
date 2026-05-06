<?php require_once "../php/Blog.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Utility::getTitle(); ?></title>
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <main>
        <section class="form-section">
            <h2>Login</h2>
            <form class="contact-form" action="#" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">

                <button type="submit" class="submit-btn">Login</button>
            </form>
        </section>
    </main>
</body>
</html>
