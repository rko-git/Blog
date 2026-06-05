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
            Utility::log("Vytvorená", false);
            return true;
        }
        catch (PDOException $err){
            Utility::log($err, true);
            return false;
        }
    }
    public static function editCategory():bool{
        try{
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $name = $_POST["name"];
            $slug = $_POST["slug"];
            $id = $_POST["id"];
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("update category set nazov = :nazov, slug = :slug where idcategory = :id");
            $sql->execute(["nazov"=>$name,"slug"=>$slug,"id"=>$id]);
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
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("delete from category where idcategory = :id");
            $sql->execute(["id"=>$id]);
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
            if (!Auth::isLoggedIn()) {
                return false;
            }
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("delete from user where iduser = :id");
            $sql->execute(["id"=>$id]);
            return true;
        }
        catch(PDOException $err){
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
            $date = date('Y-m-d');
            $sql = $db->prepare("insert into post (iduser,nadpis,slug,obsah,vytvorene,aktualizovane,obrazok) values (:iduser,:nadpis,:slug,:obsah,:vytvorene,:aktualizovane,:obrazok)");
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
                $sql->execute(["iduser"=>$iduser,"nadpis"=>$nadpis,"slug"=>$slug,"obsah"=>$obsah,"vytvorene"=>$date,"aktualizovane"=>$date, "obrazok"=>$obrazok]);
                return true;
            }
            $sql->execute(["iduser"=>$iduser,"nadpis"=>$nadpis,"slug"=>$slug,"obsah"=>$obsah,"vytvorene"=>$date,"aktualizovane"=>$date, "obrazok"=>"sample.png"]);
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
            $sql = $db->query("select p.idpost,u.nick,p.nadpis,p.slug,p.obsah,p.vytvorene,p.aktualizovane,p.obrazok from post p inner join user u on p.iduser = u.iduser");
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
            $sql = $db->query("select c.nazov from category c inner join post_category pc on c.idcategory = pc.idcategory inner join post p on pc.idpost = p.idpost where p.idpost = $idpost");
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
}