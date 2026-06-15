<?php
class Utility {
    static function getTitle(): string { # deklaracia statickej funkcie na zobrazenie nazvu stranky s navratovou hodnotou string v statickej forme aby sa nemusela vytvarat instancia
        $script = $_SERVER["SCRIPT_NAME"]; # vlozi do premennej script nazov skriptu zo superglobalnej premennej $_SERVER podla asociativneho pola SCRIPT_NAME
        $page = ucfirst(basename($script, ".php")); # vlozi do premennej page obsah premennej script bez koncovky .php a zmeni prve pismeno na velke
        return "Blog - " . $page; # spojenie retazca so spolocnym nazvom a s aktualnym nazvom stranky a vlozenie do navratovej hodnoty
    }
    static function redirect(string $url):void{
        header("Location: ".$url); # zavola vstavanu funkciu header s parametrom Location: ktora povie prehliadacu aby zmenila adresu na danu URL, pri parametre Location: odosle prehliadacu REDIRECT status code
        die(); # ukonci skript
    }
    public static function log(string $log, bool $error):void{ //logovanie, ak je hodnota error parametru true tak sa ulozi do error.log inak sa ulozi do log.log
        if ($error){
        $dir = __DIR__ . '/../log';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); //ak neexistuje zlozka tak ju vytvori s najvyssimi moznymi opravneniami
        }
        $file = $dir . '/error.log';
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] {$log}" . PHP_EOL; //PHP_EOL je znak \n pre novy riadok
        file_put_contents($file, $formattedMessage, FILE_APPEND); //ukladanie retazca do daneho suboru
        }
        else {
            $dir = __DIR__ . '/../log';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $dir . '/log.log';
            $date = date('Y-m-d H:i:s');
            $formattedMessage = "[$date] {$log}" . PHP_EOL;
            file_put_contents($file, $formattedMessage, FILE_APPEND);
        }
    }
    public static function message():void { //ukladanie sprav cez kontaktny formular
        try{
        $meno = $_POST["name"];
        $email = $_POST["email"];
        $sprava = $_POST["description"];
        $database = new Database();
        $db = $database->getConnection();
        $sql = $db->prepare("insert into message (meno,email,sprava,vytvorene) values (:meno,:email,:sprava,now())");
        $sql->execute(["meno"=>$meno,"email"=>$email,"sprava"=>$sprava]);
        }
        catch (PDOException $err){
            self::log($err->getMessage(), true); //volanie statickej metody z vlastnej triedy
        }
    }
}