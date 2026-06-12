<?php

class Auth{
    public static function login(): bool {
        try {
            if (!isset($_POST["email"]) || !isset($_POST["password"])) {return false;} //ak nie je zadana nejaka hodnota vrati false
            $email = $_POST["email"]; //nastavi hodnotu premennej email z pola superglobalnej premennej post
            $pwd = $_POST["password"];
            $database = new Database(); //vytvorenie instancie Database
            $db = $database->getConnection(); //vlozenie spojenia databazy do premennej db
            $sql = $db->prepare("select r.*,u.* from role r inner join user u on u.idrole = r.idrole where email = :email");
            $sql->execute(["email"=>$email]); 
            $user = $sql->fetch(); //fetch vrati jeden riadok do pola a fetchall vrati vsetky vysledky
            if (!$user || !password_verify($pwd, $user["heslo"])) {return false;} //ak neexistuje pouzivatel alebo nespravne heslo ukonci metodu hodnotou false, password_verify porovna zahashovane heslo v databaze so zadanym heslom
            session_regenerate_id(true); //vytvori novy session a zmaze stary session aby sa zabranilo ukradnutiu uctu
            $_SESSION["user_id"] = $user["iduser"];
            $_SESSION["user_role"] = $user["nazov"];
            $_SESSION["user_name"] = $user["nick"];
            Utility::log("Prihlaseny pouzivatel: " . $user["nick"] . " ID: ". (string)$user["iduser"], false);
            Utility::redirect("home.php");
            return true;
        }
        catch (PDOException $err){
            Utility::log("Chyba pri prihlasovani" . $err->getMessage(), true);
            return false;
        }
    }
    public static function logout():void{ 
        $_SESSION = []; // pri odhlasovani sa superglobalna premenna _SESSION pre istotu navyse vyprazdnuje
        session_destroy();
        Utility::redirect("home.php");
    }
    public static function getId(): int|null{
        return $_SESSION["user_id"] ?? null; // ?? null coalescing operator vracia pravu stranu ak lava strana nie je nastavena alebo je null
    }
    public static function isAdmin(): bool{
        return ($_SESSION["user_role"] ?? null) == "admin";
    }
    public static function isEditor(): bool{
        return ($_SESSION["user_role"] ?? null) == "editor";
    }
    public static function checkAdmin(int $id): bool{ // skontroluje ci dane user id je admin
        try{
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select r.nazov from user u inner join role r on u.idrole = r.idrole where u.iduser = :iduser");
            $sql->execute(["iduser"=>$id]);
            $role = $sql->fetch();
            if ($role["nazov"] == "admin"){
                return true;
            }
            return false;
        }
        catch(PDOException $err){
            Utility::log($err->getMessage(), true);
            return false;
        }
    }
    public static function isLoggedIn(): bool{
        if (isset($_SESSION["user_id"])) {return true;}
        return false;
    }
    public static function create() : bool{
        if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {return false;} //ak nie je zadana nejaka hodnota vrati false
        $meno = $_POST["username"];
        $mail = $_POST["email"];
        $heslo = $_POST["password"];
        try{
        $database = new Database();
        $db = $database->getConnection();
        $date = date('Y-m-d');
        $sql = $db->prepare("insert into user(nick,email,heslo,idrole,vytvorene) values(:nick,:email,:password,2,:vytvorene)");
        $sql->execute(["nick"=>$meno,"email"=>$mail,"password"=>password_hash($heslo, PASSWORD_DEFAULT),"vytvorene"=>$date]); //password_hash zahashuje heslo v databaze
        $reg = "Zaregistrovany pouzivatel: " . $meno . " E-mail: " . $mail;
        Utility::log($reg, false);
        Utility::redirect("login.php");
        return true;
        }
        catch (PDOException $err) {
            Utility::log("Chyba pri registracii" . $err->getMessage(), true);
            return false;
        }
    }
    public static function getLoginStatus(): string{
        return $_SESSION["user_name"] ?? "Neprihlásený";
    }
}
#admin login = admin@admin.net heslo = admin