<?php
class Redirect {
    private string $url;
    function __construct(string $url) {
        $this->url = $url;

    }
    static function redirect(string $url):void{
        header("Location: ".$url);
        die();
    }
}