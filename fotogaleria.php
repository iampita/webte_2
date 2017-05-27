<?php
include_once './src/Translator.php';

isset($_SESSION['lang']) ? null : $_SESSION['lang'] = 'sk';

$page = Translator::getSite();
$translation = Translator::translate($page[0], $_SESSION['lang']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width"/>
    <title><?php echo $translation->title;?></title>

    <link rel="stylesheet" type="text/css" href="aktivity/fotoStyle.css">
    <link rel="stylesheet" type="text/css" href="menu/menuStyle.css">
    <script src="aktivity/fotoskript.js"></script>

    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="https://cdn.concisecss.com/concise.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="src/main.css">


</head>
<body>

<?php
include 'config.php';
include 'src/header.php';
isset($_SESSION['lang']) ? $lang = $_SESSION['lang'] : $lang = 'sk';
if($lang == 'en')
    include_once 'menu/menuEN.php';
else include 'menu/menu.php';
?>
<h1><?php echo $translation->title;?></h1>
<?php
include include 'aktivity/foto.php';
if($lang == 'en')
    makeRowEN();
else makeRowSK();
?>


<div id="bmyModal" class="bmodal">
    <span class="bclose cursor" onclick="closeModal()">&times;</span>

    <div class="bmodal-content">
        <div id="bmySlides">
            <div id="bnumbertext"></div>
            <img id="bmodalimg" src="?" alt="?">
        </div>
    </div>
</div>


<?php include_once './src/footer.php' ?>
</body>
</html>