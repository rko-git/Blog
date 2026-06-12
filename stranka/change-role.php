<?php
require_once "../php/Blog.php";
require_once "casti/header.php";
if (!Auth::isAdmin()) {
    Utility::redirect("home.php");
}

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0; //ak je id v GET prazdny nastavi hodnotu na 0
$idrole = isset($_GET["idrole"]) ? (int) $_GET["idrole"] : 0;
$user = $id > 0 ? Content::getUserById($id) : false; //ak je v id hodnota vacsia ako 0 zavola staticku funkciu getUserById
$roles = Content::readRole();
if (!$user) { //ked pouzivatel neexistuje vykona redirect
    Utility::redirect("admin.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Content::changeRole($id)) {
        Utility::redirect("admin.php");
    }
}


?>

    <main>
        <section class="form-section">
            <h2>Edit user role</h2>
            <form class="contact-form" method="post" action="change-role.php?id=<?php echo $id; ?>">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) $user["iduser"], ENT_QUOTES, "UTF-8"); ?>">

                <label for="nick"><?php echo htmlspecialchars($user["nick"], ENT_QUOTES); ?></label>
                <input type="hidden" id="nick" name="nick" value="<?php echo htmlspecialchars($user["nick"], ENT_QUOTES, "UTF-8"); ?>" placeholder="User name" required>
                <label for="role">Role:</label>
                <?php foreach($roles as $r): ?>
                <label class ="checkbox-row" for="role"><?php echo htmlspecialchars($r["nazov"], ENT_QUOTES); ?>
                <input type="radio" id="<?php echo htmlspecialchars($r["idrole"], ENT_QUOTES);?>" name="idrole" value="<?php echo htmlspecialchars($r["idrole"], ENT_QUOTES); ?>" placeholder="role" required>
                </label>
                <?php endforeach;?>
                <button type="submit" class="submit-btn">Save changes</button>
            </form>
            <p class="form-links">
                <a href="admin.php" class="submit-btn btn-secondary">Back to Admin</a>
            </p>
        </section>
    </main>

<?php require_once "casti/footer.php"; ?>
