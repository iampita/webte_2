<?php
$url = $_SERVER["PHP_SELF"];
$parts = explode('/', $url);
$site = explode('.', $parts[count($parts) - 1])[0];

isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'sk';
if($lang != 'sk' && $lang != 'en') $lang = 'sk';
$translations = simplexml_load_file("./src/languages.xml");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $translations->$site->title->$lang;?></title>
        <link rel="stylesheet" type="text/css" href="menu/menuStyle.css">
        <meta name="HandheldFriendly" content="true" />
        <meta name="MobileOptimized" content="320" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://cdn.concisecss.com/concise.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="src/main.css">
    </head>
    <body>
        <?php include 'menu/menu.html';?>
        <h1><?php echo $translations->$site->title->$lang;?></h1>

        <?php include_once './src/footer.php' ?>
    </body>
</html>
