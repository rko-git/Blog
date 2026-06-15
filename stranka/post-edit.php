<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin() && !Auth::isEditor()) {
    Utility::redirect("home.php");
}

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$post = $id > 0 ? Content::getPostById($id) : false;

if (!$post) {
    Utility::redirect("admin.php");
}

$categories = Content::readCategory();
$selectedCategories = Content::getPostCategoryIds($id);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Content::editPost($id)) {
        Utility::redirect("admin.php");
    }
}
?>

    <main>
        <section class="form-section">
            <h2>Edit post</h2>
            <form class="contact-form" method="post" action="post-edit.php?id=<?php echo urlencode($id); ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $post["idpost"], ENT_QUOTES, "UTF-8"); ?>">

                <label for="nadpis">Title</label>
                <input type="text" id="nadpis" name="nadpis" value="<?php echo htmlspecialchars($post["nadpis"], ENT_QUOTES, "UTF-8"); ?>" placeholder="Post title" required>

                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($post["slug"], ENT_QUOTES, "UTF-8"); ?>" placeholder="post-slug" required>

                <label for="obsah">Content</label>
                <textarea id="obsah" name="obsah" rows="8" placeholder="Write post content" required><?php echo htmlspecialchars($post["obsah"], ENT_QUOTES, "UTF-8"); ?></textarea>

                <p class="meta">Current image: <?php echo htmlspecialchars($post["obrazok"], ENT_QUOTES, "UTF-8"); ?></p>
                <img src="../img/<?php echo htmlspecialchars($post["obrazok"], ENT_QUOTES, "UTF-8"); ?>" alt="Current post image" class="post-image">

                <label for="image">Replace image (optional)</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">

                <fieldset class="category-fieldset">
                    <legend>Categories</legend>
                    <?php if (empty($categories)): ?>
                    <p class="meta">No categories available.</p>
                    <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                    <?php $categoryId = (int) $category["idcategory"]; ?>
                    <label class="checkbox-row" for="category-<?php echo htmlspecialchars((string) $categoryId, ENT_QUOTES, "UTF-8"); ?>">
                        <input type="checkbox" id="category-<?php echo htmlspecialchars((string) $categoryId, ENT_QUOTES, "UTF-8"); ?>" name="categories[]" value="<?php echo htmlspecialchars((string) $categoryId, ENT_QUOTES, "UTF-8"); ?>"<?php echo in_array($categoryId, $selectedCategories, true) ? " checked" : ""; ?>>
                        <span><?php echo htmlspecialchars($category["nazov"], ENT_QUOTES, "UTF-8"); ?></span>
                    </label>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </fieldset>

                <button type="submit" class="submit-btn">Save changes</button>
            </form>
            <p class="form-links">
                <a href="admin.php" class="submit-btn btn-secondary">Return</a>
            </p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
