<?php
class Database {

    private PDO $connection; #deklaracia premennej objektu PDO

    function __construct() { #konstruktor pri instancii nadviaze spojenie s databazou a vypise spravu o spojeni
        try {
        $this->connect(); //this sa pouziva pri odkazovani na aktualnu instanciu triedy narozdiel od self ktory sa pouziva na pristup statickym atributom a metodam
        #echo "Spojenie s databazou uspesne";
        } catch (PDOException $e) {
           Utility::log($e->getMessage(), true);
        }
    }
    private function connect(): void {
        $this->connection = new PDO("mysql:host=localhost;dbname=blog;charset=utf8mb4","root",""); #definicia typu databazy, hostitelskej adresy, nazvu databazy, znakovej sady, prihlasovacieho mena a hesla
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); #nastavenie atributu aby PDO vygenerovalo vynimku pri chybe
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); #nastavenie PDO aby vracalo tabulku vo forme asociativneho pola
    }
    public function getConnection(): PDO { #getter pre PDO objekt vytvoreny v triede
        return $this->connection;
    }
}