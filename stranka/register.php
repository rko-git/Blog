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
            <h2>Registrácia</h2>
            <form class="contact-form" action=# method="POST">
                <label for="username">Používatelské meno</label>
                <input type="text" id="username" name="username" placeholder="Zadaj svoje používatelské meno" >

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Zadaj svoj e-mail" >

                <label for="password">Heslo</label>
                <input type="password" id="password" name="password" placeholder="Zadaj svoje heslo" >

                <button type="submit" class="submit-btn">Registrácia</button>
            </form>
            <p class="form-links">
                <a href="login.php" class="submit-btn btn-secondary">Späť na prihlásenie</a>
            </p>
        </section>
    </main>
</body>
</html>
<?php require_once "casti/footer.php";