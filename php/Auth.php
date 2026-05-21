<?php

class Auth{
    public static function login(): bool {
        try {
            $email = $_POST["email"];
            $pwd = $_POST["password"];
            $database = new Database();
            $db = $database->getConnection();
            $sql = $db->prepare("select * from user where email = :email");
            $sql->execute(["email"=>$email]);
            $user = $sql->fetch();
            if (!$user || !password_verify($pwd, $user["heslo"])) {return false;}
            $sql = $db->prepare("select r.*,u.* from role r inner join user u on u.idrole = r.idrole where email = :email");
            $sql->execute(["email"=>$email]);
            $role = $sql->fetch();
            session_regenerate_id(true);
            $_SESSION["user_id"] = $user["iduser"];
            $_SESSION["user_role"] = $role["nazov"];
            $_SESSION["user_name"] = $user["nick"];
            Utility::redirect("home.php");
            return true;
        }
        catch (PDOException $err){
            Utility::log("Chyba pri prihlasovani" . $err->getMessage());
            return false;
        }
    }
    public static function logout():void{
        $_SESSION = [];
        session_destroy();
        Utility::redirect("home.php");
    }
    public static function getId(): int|null{
        return $_SESSION["user_id"] ?? null;
    }
    public static function isAdmin(): bool{
        if ($_SESSION["user_role"] == "admin") {return true;}
        return false;
    }
    public static function isLoggedIn(): bool{
        if (isset($_SESSION["user_id"])) {return true;}
        return false;
    }
    public static function create() : bool{
        $meno = $_POST["username"] ?? "";
        $mail = $_POST["email"] ?? "";
        $heslo = $_POST["password"] ?? "";
        try{
        $database = new Database();
        $db = $database->getConnection();
        $date = date('Y-m-d');
        $sql = $db->prepare("insert into user(nick,email,heslo,idrole,vytvorene) values(:nick,:email,:password,2,:vytvorene)");
        $sql->execute(["nick"=>$meno,"email"=>$mail,"password"=>password_hash($heslo, PASSWORD_DEFAULT),"vytvorene"=>$date]);
        Utility::redirect("login.php");
        return true;
        }
        catch (PDOException $err) {
            #Utility::log("Chyba pri registracii" . $err->getMessage());
            echo $err->getMessage();
            return false;
        }
    }
    public static function getLoginStatus(): string{
        return $_SESSION["user_name"] ?? "Neprihlásený";
    }
}
#admin login = admin@admin.net heslo = admin