<?php
require_once "casti/header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    Utility::message();
    Utility::redirect("contact.php");
}
?>

    <main>
        <section class="form-section">
            <h2>Odoslať správu</h2>
            <form class="contact-form" action="" method="POST">
                <label for="name">Meno</label>
                <input type="text" id="name" name="name" placeholder="Vaše meno">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="tvoj@email.com">

                <label for="description">Popis</label>
                <textarea id="description" name="description" rows="6" placeholder="Sem píš správu"></textarea>

                <label class="checkbox-row" for="consent">
                    <input type="checkbox" id="consent" name="consent">
                    <span>Súhlasím so spracovaním osobných údajov.</span>
                </label>

                <button type="submit" id="submitButton" class="submit-btn" disabled>Odoslať</button>
            </form>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
