<?php
include_once './src/Translator.php';

isset($_SESSION['lang']) ? null : $_SESSION['lang'] = 'sk';

$page = Translator::getSite();
$translation = Translator::translate($page[0], $_SESSION['lang']);
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
<?php
include 'src/header.php';
isset($_SESSION['lang']) ? $lang = $_SESSION['lang'] : $lang = 'sk';
if($lang == 'en')
    include_once 'menu/menuEN.php';
else include 'menu/menu.php'
;?>
<div class="atitle"><h1><?php echo $translation->title;?></h1></div>
    <div class="aimgcar">
        <img class="aimg" src="http://uamt.fei.stuba.sk/web/sites/images/vozidlo6x6/dve_vozidla.png" />
    </div>
<div class="flex-container">
    <div class="flex-half">
        <?php
        echo "<h3>{$translation->spec}</h3>";
        ?>

        <ul>
            <?php
            echo "<li>{$translation->weight} 12,5kg</li>
                    <li>{$translation->dimensions} 614 x 495 x 269 mm</li>
                    <li>{$translation->control}</li>
                    <li>{$translation->drivetrain}</li>
                    <li>{$translation->electromotor}</li>
                    <li>{$translation->output} 6x 175W</li>
                    <li>{$translation->powersupply}</li>
                    <li>{$translation->battery}</li>
                    <li>{$translation->capacity} 13,2 Ah</li>";
            ?>
        </ul>
    </div><br>
    <div class="flex-half">
        <img class="aimgright" src="http://uamt.fei.stuba.sk/web/sites/images/Render_ISO.jpg" />
    </div>
</div>
<?php include_once './src/footer.php' ?>
</body>
</html>
