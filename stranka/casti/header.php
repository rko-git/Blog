<?php
require_once "../php/Blog.php";

if (session_status() === PHP_SESSION_NONE){ // ak neexistuje session tak sa vytvori novy, server posle pouzivatelovi do prehliadaca cookie podla ktoreho server vie nacitat spravne udaje pre session pri nacitani stranky
    session_start(); 
}
Auth::loginWithRememberCookie();
$username = Auth::getLoginStatus();
if (isset($_POST["logout"])) {Auth::logout();}
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
    <header class="hero">
        <nav class="nav">
            <a class="logo-link" href="home.php">
                <h1 class="logo">Blog</h1>
            </a>

            <ul class="nav-links">
                <li><a href="home.php">Domov</a></li>
                <li><a href="posts.php">Príspevky</a></li>
                <li><a href="about.php">O nás</a></li>
                <li><a href="contact.php">Kontakt</a></li>
                <?php if (Auth::isAdmin()): ?>
                <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>
                <?php if (Auth::isLoggedIn()): ?>
                <!--<li><a href="home.php?action=logout">Logout</a></li> -->
                <li>
                    <a href="#" class="nav-logout-link" onclick="document.getElementById('logout-form').submit(); return false;">Logout</a>
                </li>
                <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
            <p class="logo-link" href="login.php" id="user"><?php 
            if (Auth::isLoggedIn()) {
                echo $username;
            }
            else {
                echo "Neprihlásený";
            }
            ?></p>
        </nav>
        <?php if (Auth::isLoggedIn()): ?>
        <form id="logout-form" method="post" class="nav-logout-form" hidden>
            <input type="hidden" name="logout" value="1">
        </form>
        <?php endif; ?>
        <section class="hero-content">
            <p class="tag">UKF</p>
            <h2>Skriptovacie Jazyky</h2>
        </section>
    </header>
