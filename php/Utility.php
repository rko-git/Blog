<?php
class Utility {
    static function getTitle(): string { # deklaracia statickej funkcie na zobrazenie nazvu stranky s navratovou hodnotou string v statickej forme aby sa nemusela vytvarat instancia
        $script = $_SERVER["SCRIPT_NAME"]; # vlozi do premennej script nazov skriptu zo superglobalnej premennej $_SERVER podla asociativneho pola SCRIPT_NAME
        $page = ucfirst(basename($script, ".php")); # vlozi do premennej page obsah premennej script bez koncovky .php a zmeni prve pismeno na velke
        return "Sem. praca - " . $page; # spojenie retazca so spolocnym nazvom a s aktualnym nazvom stranky a vlozenie do navratovej hodnoty
    }
    static function redirect(string $url):void{
        header("Location: ".$url); # zavola vstavanu funkciu header s parametrom Location: ktora povie prehliadacu aby zmenila adresu na danu URL
        die(); # ukonci skript
    }
    public static function log(string $log, bool $error):void{
        if ($error){
        $dir = __DIR__ . '/../error';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $file = $dir . '/log.log';
        $date = date('Y-m-d H:i:s');
        $formattedMessage = "[$date] {$log}" . PHP_EOL;
        file_put_contents($file, $formattedMessage, FILE_APPEND);
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
    public static function message():void {
        try{
        $meno = $_POST["name"];
        $email = $_POST["email"];
        $sprava = $_POST["description"];
        $database = new Database();
        $db = $database->getConnection();
        $date = date('Y-m-d');
        $sql = $db->prepare("insert into message (meno,email,sprava,vytvorene) values (:meno,:email,:sprava,:vytvorene)");
        $sql->execute(["meno"=>$meno,"email"=>$email,"sprava"=>$sprava,"vytvorene"=>$date]);
        }
        catch (PDOException $err){
            echo $err->getMessage();
            self::log($err->getMessage(), true);
        }
    }
}