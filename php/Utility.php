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
}