<?php
include_once './src/Translator.php';

$page = Translator::getSite();
$translation = Translator::translate($page[0], $_GET['lang'])
?>

<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $translation->title;?></title>
    <link rel="stylesheet" type="text/css" href="menu/menuStyle.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="https://cdn.concisecss.com/concise.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/main.css">
</head>
<body>
<?php include 'menu/menu.php';?>
<h1><?php echo $translation->title;?></h1>

<?php
isset($_GET['lang']) ? $lang = $_GET['lang'] : $lang = 'sk';
if($lang == 'en')
    include_once './texty/aboutusEN.php';
else include_once './texty/aboutusSK.php';

include_once './src/footer.php' ?>
</body>
</html>