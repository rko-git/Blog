<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin() && !Auth::isEditor()) {
    Utility::redirect("home.php");
}

$categories = Content::readCategory();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Content::createPost()) {
        Utility::redirect("admin.php");
    }
}
?>

    <main>
        <section class="form-section">
            <h2>Create post</h2>
            <form class="contact-form" method="post" action="post-create.php" enctype="multipart/form-data">
                <label for="nadpis">Title</label>
                <input type="text" id="nadpis" name="nadpis" placeholder="Post title" required>

                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" placeholder="post-slug" required>

                <label for="obsah">Content</label>
                <textarea id="obsah" name="obsah" rows="8" placeholder="Write post content" required></textarea>

                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">

                <fieldset class="category-fieldset">
                    <legend>Categories</legend>
                    <?php if (empty($categories)): ?>
                    <p class="meta">Zatiaľ žiadne kategórie.</p>
                    <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                    <label class="checkbox-row" for="category-<?php echo htmlspecialchars((string) $category["idcategory"], ENT_QUOTES, "UTF-8"); ?>">
                        <input type="checkbox" id="category-<?php echo htmlspecialchars((string) $category["idcategory"], ENT_QUOTES, "UTF-8"); ?>" name="categories[]" value="<?php echo htmlspecialchars((string) $category["idcategory"], ENT_QUOTES, "UTF-8"); ?>">
                        <span><?php echo htmlspecialchars($category["nazov"], ENT_QUOTES, "UTF-8"); ?></span>
                    </label>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </fieldset>

                <button type="submit" class="submit-btn">Create post</button>
            </form>
            <p class="form-links">
                <a href="admin.php" class="submit-btn btn-secondary">Return</a>
            </p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
