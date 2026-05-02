<?php
require_once "casti/header.php";
?>

    <main>
        <section class="form-section">
            <h2>Send a message</h2>
            <form class="contact-form" action="#" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your name">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="your@email.com">

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="6" placeholder="Write your message here"></textarea>

                <label class="checkbox-row" for="consent">
                    <input type="checkbox" id="consent" name="consent">
                    <span>I confirm that the information above is correct.</span>
                </label>

                <button type="submit" id="submitButton" class="submit-btn" disabled>Send</button>
            </form>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
