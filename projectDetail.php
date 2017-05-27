<?php
include_once './src/Translator.php';
include_once './src/Projects.php';

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.5/js/jquery.tablesorter.min.js"></script>
        <link rel="stylesheet" href="src/main.css">
    </head>
    <body>
        <?php include 'menu/menu.php';?>
        <a href="javascript:history.back()"><?php echo $translation->goback;?></a>
        <h1><?php echo $translation->title;?></h1>
        <?php
        $projects = new Projects();
        $result = $projects->getDetail($_GET['id']);

        $_SESSION['lang'] == 'en' ?
            $title = $result[0]['titleEN'] :
            $title = $result[0]['titleSK'];

        $_SESSION['lang'] == 'sk' ?
            $annotation = $result[0]['annotationEN'] :
            $annotation = $result[0]['annotationSK'];

        if($annotation == null)
            $annotation = '-';

        echo "<div class='flex-container'>";
        echo "<div class='adetail'>
                <p><b>$translation->type</b> {$result[0]['projectType']}<br>
                <b>$translation->number</b> {$result[0]['number']}<br>
                <b>$translation->projtitle</b> {$title}<br>
                <b>$translation->duration</b> {$result[0]['duration']}<br>
                <b>$translation->coordinator</b> {$result[0]['coordinator']}<br>
                <b>$translation->annotation</b> {$annotation}</p>
              </div>";
        echo "</div>";
        ?>

        <?php include_once './src/footer.php';?>
    </body>
</html>