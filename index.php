<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>Automobilová mechatronika</title>
    <link rel="stylesheet" type="text/css" href="menu/menuStyle.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="https://cdn.concisecss.com/concise.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/main.css">
</head>
<body>
<?php
//include 'config.php'; //neviem.. potom ked vam to bude treba odkomentujte si
include 'menu/menu.php';
isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'sk';
if($lang== 'en')
    include 'texty/homepageEN.php';
else include 'texty/homepageSK.php';

?>
<?php include_once './src/footer.php' ?>
</body>
</html>