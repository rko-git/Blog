<?php require_once "../php/Blog.php"; 
require_once "casti/header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (Auth::create()) {
        echo "Registrácia úspešná";
    } else {
        echo "Chyba registrácie";
    }
}
?>
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
            <h2>Register</h2>
            <form class="contact-form" action=# method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" >

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Enter your e-mail" >

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" >

                <button type="submit" class="submit-btn">Register</button>
            </form>
            <p class="form-links">
                <a href="login.php" class="submit-btn btn-secondary">Back to Login</a>
            </p>
        </section>
    </main>
</body>
</html>
<?php require_once "casti/footer.php";