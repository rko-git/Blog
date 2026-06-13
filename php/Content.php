<?php
class Content{

    public static function createCategory():bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $name = $_POST["name"];
            $slug = $_POST["slug"];
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("insert into category(nazov,slug) values(:nazov,:slug)");
            $sql->execute(["nazov"=>$name,"slug"=>$slug]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " vytvoril kategóriu s názvom: " . $name, false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
    public static function editCategory(int $id):bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $name = $_POST["name"];
            $slug = $_POST["slug"];
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("update category set nazov = :nazov, slug = :slug where idcategory = :id");
            $sql->execute(["nazov"=>$name,"slug"=>$slug,"id"=>$id]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " upravil kategóriu s ID: " . $id, false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
    public static function getCategoryById(int $id): array|false {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select * from category where idcategory = :id");
            $sql->execute(["id" => $id]);
            $category = $sql->fetch();
            return $category ?: false;
        }
        catch (PDOException $err) {
            Utility::log($err->getMessage(), true);
            return false;
        }
    }

    public static function deleteCategory(int $id):bool{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select * from category where idcategory = :id");
            $sql->execute(["id"=>$id]);
            $cat = $sql->fetch();
            $sql = $db->prepare("delete from post_category where idcategory = :id");
            $sql->execute(["id"=>$id]);
            $sql = $db->prepare("delete from category where idcategory = :id");
            $sql->execute(["id"=>$id]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " vymazal kategóriu s ID: " . $id . " názov: " . $cat["nazov"], false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
    public static function readCategory():array{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->query("select * from category");
            return $sql->fetchAll();
        }
        catch (PDOException $err){
            Utility::log($err->getMessage(), true);
            return [];
        }
    }
    public static function readUser():array{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->query("select u.iduser,u.nick,u.email,r.nazov from user u inner join role r on u.idrole = r.idrole");
            return $sql->fetchAll();
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return [];
        }
    }
    public static function deleteUser(int $id):bool{
        try{
            if (!Auth::isAdmin()) {
                return false;
            }
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("delete from user where iduser = :id");
            $sql->execute(["id"=>$id]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " vymazal používatela s ID: " . $id, false);
            return true;
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function readRole():array{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->query("select * from role");
            return $sql->fetchAll();
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return [];
        }
    }
    public static function changeRole(int $id):bool{
        try{
            if (!Auth::isAdmin()) {
                return false;
            }
            $idrole = $_POST["idrole"];
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("update user set idrole = :idrole where iduser = :iduser");
            $sql->execute(["idrole"=>$idrole,"iduser"=>$id]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " zmenil rolu používatela s ID: " . $id . " na: " . $idrole, false);
            return true;
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function getUserById(int $id):array|false{
        try {
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select u.*, r.nazov from user u inner join role r on u.idrole = r.idrole where iduser = :id");
            $sql->execute(["id" => $id]);
            $user = $sql->fetch();
            return $user ?: false;
        }
        catch (PDOException $err) {
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function createPost():bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $database = new Database();
            $db = $database->getConnection();
            $path = __DIR__ . "/../img/";
            $iduser = $_SESSION["user_id"];
            $nadpis = $_POST["nadpis"];
            $slug = $_POST["slug"];
            $obsah = $_POST["obsah"];
            $sql = $db->prepare("insert into post (iduser,nadpis,slug,obsah,vytvorene,obrazok) values (:iduser,:nadpis,:slug,:obsah,now(),:obrazok)");
            $obrazok = "sample.png";
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK){
                $povolene = ["jpg", "jpeg", "png", "webp"];
                $pripona = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (!in_array($pripona, $povolene)){
                    return false;
                }
                $obrazok = uniqid() . "." . $pripona;
                $cestaObrazka = $path . $obrazok;
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $cestaObrazka)) {
                    return false;
                }
            }
            $sql->execute(["iduser"=>$iduser,"nadpis"=>$nadpis,"slug"=>$slug,"obsah"=>$obsah, "obrazok"=>$obrazok]);
            $idpost = (int) $db->lastInsertId();
            if (!empty($_POST["categories"]) && is_array($_POST["categories"])) {
                $categorySql = $db->prepare("insert into post_category (idpost, idcategory) values (:idpost, :idcategory)");
                foreach ($_POST["categories"] as $idcategory) {
                    $categorySql->execute(["idpost" => $idpost, "idcategory" => (int) $idcategory]);
                }
            }
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " vytvoril post s názvom: " . $nadpis, false);
            return true;
        }
        catch (Exception $err){
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function readPost():array{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->query("select p.idpost,u.nick,u.iduser,p.nadpis,p.slug,p.obsah,p.vytvorene,p.aktualizovane,p.obrazok from post p inner join user u on p.iduser = u.iduser");
            return $sql->fetchAll();
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return [];
        }
    }
    public static function readPostCategory(int $idpost):array{
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->query("select c.nazov, c.slug from category c inner join post_category pc on c.idcategory = pc.idcategory inner join post p on pc.idpost = p.idpost where p.idpost = $idpost");
            return $sql->fetchAll();
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return [];
        }
    }
    public static function getPostById(int $id): array|false {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select * from post where idpost = :id");
            $sql->execute(["id" => $id]);
            $post = $sql->fetch();
            return $post ?: false;
        }
        catch (PDOException $err) {
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function getPostCategoryIds(int $idpost): array {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select idcategory from post_category where idpost = :idpost");
            $sql->execute(["idpost" => $idpost]);
            return array_map("intval", array_column($sql->fetchAll(), "idcategory"));
        }
        catch (PDOException $err) {
            Utility::log($err->getMessage(), true);
            return [];
        }
    }

    public static function deletePost(int $id):bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("delete from post_category where idpost = :id");
            $sql->execute(["id"=>$id]);
            $sql = $db->prepare("delete from post where idpost = :id");
            $sql->execute(["id"=>$id]);
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " vymazal post s ID: " . $id, false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
    public static function editPost(int $id):bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $path = __DIR__ . "/../img/";
            $nadpis = $_POST["nadpis"];
            $slug = $_POST["slug"];
            $obsah = $_POST["obsah"];
            $database = new Database();
            $db = $database->getConnection();
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK){
                $povolene = ["jpg", "jpeg", "png", "webp"];
                $pripona = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                if (!in_array($pripona, $povolene)){
                    return false;
                }
                $obrazok = uniqid() . "." . $pripona;
                $cestaObrazka = $path . $obrazok;
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $cestaObrazka)) {
                    return false;
                }
                $sql = $db->prepare("update post set nadpis = :nadpis, slug = :slug, obsah = :obsah, aktualizovane = now(), obrazok = :obrazok where idpost = :id");
                $sql->execute(["nadpis"=>$nadpis,"slug"=>$slug,"obsah"=>$obsah,"obrazok"=>$obrazok,"id"=>$id]);
            } else {
                $sql = $db->prepare("update post set nadpis = :nadpis, slug = :slug, obsah = :obsah, aktualizovane = now() where idpost = :id");
                $sql->execute(["nadpis"=>$nadpis,"slug"=>$slug,"obsah"=>$obsah,"id"=>$id]);
            }
            $deleteCategories = $db->prepare("delete from post_category where idpost = :idpost");
            $deleteCategories->execute(["idpost" => $id]);
            if (!empty($_POST["categories"]) && is_array($_POST["categories"])) {
                $categorySql = $db->prepare("insert into post_category (idpost, idcategory) values (:idpost, :idcategory)");
                foreach ($_POST["categories"] as $idcategory) {
                    $categorySql->execute(["idpost" => $id, "idcategory" => (int) $idcategory]);
                }
            }
            Utility::log($_SESSION["user_name"] . " ID: ". $_SESSION["user_id"] . " upravil post s ID: " . $id, false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
}