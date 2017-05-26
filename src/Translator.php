<?php
class Translator{
    public static function translate($page, $language){
        session_start();
        isset($_SESSION['lang']) ? $lang = $_SESSION['lang'] : $lang = 'sk';
        isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = $_SESSION['lang'];
        $_SESSION['lang'] = $lang;
        $translations = simplexml_load_file("./src/languages.xml");
        $pageTranslation = $translations->$page->$lang;
        return $pageTranslation;
    }

    public static function getSite(){
        $url = $_SERVER["PHP_SELF"];
        $parts = explode('/', $url);
        $site = explode('.', $parts[count($parts) - 1]);
        return $site;
    }
}


