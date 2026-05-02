<?php
require_once "../php/Utility.php";
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
            </ul>
        </nav>
        <section class="hero-content">
            <p class="tag">School Project</p>
            <h2>Blog</h2>
            <p>A simple blog website with separate pages for home, posts, about, and contact.</p>
        </section>
    </header>
