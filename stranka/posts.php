<?php
require_once "casti/header.php";
require_once "../php/Blog.php";

$posts = Content::readPost();
$categories = Content::readCategory();
if (isset($_GET["deletepostid"]) && Auth::isEditor() && Content::getPostById($_GET["deletepostid"])["iduser"] == $_SESSION["user_id"]) {
    Content::deletePost($_GET["deletepostid"]);
    Utility::redirect("admin.php");
}
?>



    <main>
        <?php if(Auth::isEditor()): ?>
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
                            <?php if($p["iduser"] == $_SESSION["user_id"]): ?>
                            <td class="admin-actions-cell">
                                <a href="post-edit.php?id=<?php echo urlencode((string) $p["idpost"]); ?>" class="admin-btn admin-btn-edit">Edit</a>
                                <a href="posts.php?deletepostid=<?php echo urlencode((string) $p["idpost"]); ?>" class="admin-btn admin-btn-delete">Delete</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php endif; ?>
        <section class="controls">
            <input id="searchInput" type="text" placeholder="Search blog posts...">
            <div class="filters">
                <button type="button" class="filter-btn active" data-category="all">All</button>
                <?php foreach ($categories as $cats): ?>
                <button type="button" class="filter-btn" data-category="<?php echo htmlspecialchars($cats["slug"], ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($cats["nazov"], ENT_QUOTES, "UTF-8"); ?></button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="posts-grid">
            <?php if (empty($posts)): ?>
            <p class="meta">No posts yet.</p>
            <?php else: ?>
            <?php foreach ($posts as $post): ?>
            <?php
                $postc = Content::readPostCategory($post["idpost"]);
                $postSlugs = [];
                $postNames = [];

                foreach ($postc as $pc) {
                    $postSlugs[] = $pc["slug"];
                    $postNames[] = $pc["nazov"];
                }
            ?>
            <article class="post-card" data-category="<?php echo htmlspecialchars(implode(",", $postSlugs), ENT_QUOTES, "UTF-8"); ?>">
                <img src="../img/<?php echo htmlspecialchars($post["obrazok"], ENT_QUOTES, "UTF-8"); ?>" alt="<?php echo htmlspecialchars($post["nadpis"], ENT_QUOTES, "UTF-8"); ?>" class="post-image">
                <h3><?php echo htmlspecialchars($post["nadpis"], ENT_QUOTES, "UTF-8"); ?></h3>
                <p class="meta">Category: <?php echo htmlspecialchars(implode(", ", $postNames), ENT_QUOTES, "UTF-8"); ?></p>
                <p><?php echo htmlspecialchars($post["obsah"], ENT_QUOTES, "UTF-8"); ?></p>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>

