<?php 
require_once "../php/Blog.php"; 
require_once "casti/header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (Auth::login()) {
        echo "Prihlasovanie prebehlo úspešne";
    } else {
        echo "Chyba pri prihlasovaní";
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
            <h2>Login</h2>
            <form class="contact-form" action="#" method="POST">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Enter your E-mail">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">

                <button type="submit" class="submit-btn">Login</button>
            </form>
            <p class="form-links">
                <a href="register.php" class="submit-btn btn-secondary">Register</a>
            </p>
        </section>
    </main>
</body>
</html>
<?php require_once "casti/footer.php"; ?>