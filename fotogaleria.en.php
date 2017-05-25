<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width"/>
    <title>Photos</title>
    <link rel="stylesheet" type="text/css" href="aktivity/fotoStyle.css">
    <link rel="stylesheet" type="text/css" href="menu/menuStyle.css">
    <script src="fotoskript.js"></script>
</head>
<body>

<?php
//include '../config.php'; ?
include 'menu/menu.php';
include 'aktivity/foto.php';
makeRowEN();
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