<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin()) {
    Utility::redirect("home.php");
}

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$category = $id > 0 ? Content::getCategoryById($id) : false;

if (!$category) {
    Utility::redirect("admin.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Content::editCategory($id)) {
        Utility::redirect("admin.php");
    }
}


?>

    <main>
        <section class="form-section">
            <h2>Edit category</h2>
            <form class="contact-form" method="post" action="category-edit.php?id=<?php echo $id; ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $category["idcategory"], ENT_QUOTES, "UTF-8"); ?>">

                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category["nazov"], ENT_QUOTES, "UTF-8"); ?>" placeholder="Category name" required>

                <label for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($category["slug"], ENT_QUOTES, "UTF-8"); ?>" placeholder="category-slug" required>

                <button type="submit" class="submit-btn">Save changes</button>
            </form>
            <p class="form-links">
                <a href="admin.php" class="submit-btn btn-secondary">Back to Admin</a>
            </p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
