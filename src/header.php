<header>
    <div id="bvolby"><a href="?lang=sk">SK</a> / <a href="?lang=en">EN</a>, <a href="intranet/client/intranet.html">Intranet</a></div>
    <?php
    session_start();
    if ($_SESSION['lang']) $lang = $_SESSION['lang']; else $lang = 'sk';
    if (isset($_GET['lang'])) $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
    ?>
    <a href="index.php">
    <div class="flex-container">
    <div id="bheadercar"><img id="imgCar" src="./resources/header.png"></div>
    <div id="bheaderFEI"><img src="./resources/FEIlogo.gif" style="width: 95%;"></div>
    </div>
    </a>
</header>