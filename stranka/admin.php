<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin()) {
    Utility::redirect("home.php");
}
$cat = Content::readCategory();
$users = Content::readUser();
$posts = Content::readPost();
if (isset($_GET["deleteid"]) && !Auth::checkAdmin($_GET["deleteid"]) && Auth::isAdmin() ) { //mazanie pouzivatela skontroluje ci mazany pouzivatel je admin
    Content::deleteUser($_GET["deleteid"]);
    Utility::redirect("admin.php");
}
if (isset($_GET["deletecatid"]) && Auth::isAdmin()  ) {
    Content::deleteCategory($_GET["deletecatid"]);
    Utility::redirect("admin.php");
}
if (isset($_GET["deletepostid"]) && Auth::isAdmin() ) {
    Content::deletePost($_GET["deletepostid"]);
    Utility::redirect("admin.php");
} //if podmienky pre GET poziadavky
?>

    <main class="admin-page">
        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Categories</h2>
                <a href="category-create.php" class="submit-btn">Create category</a>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cat)): ?>
                        <tr>
                            <td colspan="4" class="admin-table-empty">Zatiaľ žiadne kategórie</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($cat as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars((string) $category["idcategory"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($category["nazov"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($category["slug"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td class="admin-actions-cell">
                                <a href="category-edit.php?id=<?php echo urlencode((string) $category["idcategory"]); ?>" class="admin-btn admin-btn-edit">Edit</a>
                                <a href="admin.php?deletecatid=<?php echo urlencode((string) $category["idcategory"]); ?>" class="admin-btn admin-btn-delete">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Posts</h2>
                <a href="post-create.php" class="submit-btn">Create post</a>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Categories</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($posts)): ?>
                            <tr>
                                <td colspan="9" class="admin-table-empty">Zatiaľ žiadne príspevky</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($posts as $p): ?>
                            <?php $postc = Content::readPostCategory($p["idpost"]);?>
                        <tr>
                                <td><?php echo htmlspecialchars((string) $p["idpost"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["nick"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["nadpis"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["slug"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["obrazok"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td>
                                <?php $postcategories = [];
                                    foreach ($postc as $pc) {
                                        $postcategories[] = htmlspecialchars($pc["slug"], ENT_QUOTES, "UTF-8");
                                    }
                                    echo implode(", ", $postcategories);
                                ?>
                                </td>
                                <td><?php echo htmlspecialchars($p["obsah"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["vytvorene"], ENT_QUOTES, "UTF-8"); ?></td>
                                <td><?php echo htmlspecialchars($p["aktualizovane"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td class="admin-actions-cell">
                                <a href="post-edit.php?id=<?php echo urlencode((string) $p["idpost"]); ?>" class="admin-btn admin-btn-edit">Edit</a>
                                <a href="admin.php?deletepostid=<?php echo urlencode((string) $p["idpost"]); ?>" class="admin-btn admin-btn-delete">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="admin-section">
            <div class="admin-section-header">
                <h2>Registered users</h2>
            </div>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users)): ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars((string) $u["iduser"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($u["nick"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($u["email"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($u["nazov"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td class="admin-actions-cell">
                                <?php if (!Auth::checkAdmin($u["iduser"])): ?>
                                <a href="change-role.php?id=<?php echo urlencode((string) $u["iduser"]); ?>" class="admin-btn admin-btn-edit">Edit</a>
                                <a href="admin.php?deleteid=<?php echo urlencode((string) $u["iduser"]); ?>" class="admin-btn admin-btn-delete">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
