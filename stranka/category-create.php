<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin()) {
    Utility::redirect("home.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Content::createCategory()) {
        Utility::redirect("admin.php");
    }
}


?>

    <main>
        <section class="form-section">
            <h2>Create category</h2>
            <form class="contact-form" method="post" action="category-create.php">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Category name" required>

                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" placeholder="category-slug" required>

                <button type="submit" class="submit-btn">Create category</button>
            </form>
            <p class="form-links">
                <a href="admin.php" class="submit-btn btn-secondary">Back to Admin</a>
            </p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
