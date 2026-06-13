<?php
require_once "casti/header.php";
?>

    <main>
        <section class="content-section">
            <h2>O nás</h2>
            <p>Táto stránka obsahuje základné CRUD operácie.</p>
            <p>Využíva template cez PHP pre načítanie headera a footera na každej stránke.</p>
            <p>Prepojenie s MariaDB databázou je realizované cez PDO.</p>
            <p>Autentikácia ukladá údaje o registrácií a zahashované heslo do databázy, pri prihlásení zhodou zadaných údajov alebo zistení remember cookie vytvorí session zo získanými údajmi.</p>
            <p>Autorizácia pri zistení admin role umožní prístup do admin.php a pri editor role umožní vytváranie postov v stránke pre príspevky a zároveň mazanie vlastných príspevkov.</p>
            <p>Logovanie pri akciách používatela a pri chybe.</p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
