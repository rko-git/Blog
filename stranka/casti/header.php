<?php
require_once "../php/Blog.php";
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
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
                <li><a href="home.php">Home</a></li>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
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
            <p class="tag">School Project</p>
            <h2>Blog</h2>
            <p>A simple blog website with separate pages for home, posts, about, and contact.</p>
        </section>
    </header>
