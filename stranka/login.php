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
            <h2>Prihlásenie</h2>
            <form class="contact-form" action="#" method="POST">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Zadaj svoj E-mail">

                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" placeholder="Zadaj svoje heslo">
                <div class="checkbox-row">
                    <input  type="checkbox" id="remember" name="remember" placeholder="Zapamätaj si ma">
                    <label for="remember">Zapamätaj si ma</label>
                </div>
                <button type="submit" class="submit-btn">Prihlásiť</button>
            </form>
            <p class="form-links">
                <a href="register.php" class="submit-btn btn-secondary">Registrácia</a>
            </p>
        </section>
    </main>
</body>
</html>
<?php require_once "casti/footer.php"; ?>