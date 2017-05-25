<?php
class Translator{
    public static function translate($page, $language){
        isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'sk';
        if($lang != 'sk' && $lang != 'en') $lang = 'sk';
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


