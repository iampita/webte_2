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
        <div class="flex-container">
            <div class="kontakt flex-links" id="ustav">
                <?php echo $translation->institute;?><br>
                <?php echo $translation->faculty;?><br>
                <?php echo $translation->street;?><br>
                <?php echo $translation->city;?><br>
                <?php echo $translation->country;?><br><br>
                <?php echo $translation->secretariat;?><br>
                <?php echo $translation->secretary;?><br>
                <?php echo $translation->room;?><br>
                <?php echo $translation->phone1;?><br>
                <?php echo $translation->phone2;?><br>
                <?php echo $translation->webpage;?><br>
            </div>
            <br><br>
            <div class="map flex-map" id="map"></div>
                <script>
                    var map;
                    function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: {lat: 48.15178, lng: 17.07335},
                            zoom: 16
                        });

                        setMarkers(map);
                    }

                    var infobox = '<div id="content">'+
                        '<div id="siteNotice">'+
                        '</div>'+
                        '<h3 class="thirdHeading">FEI STU...</h3>'+
                        '<div id="bodyContent">'+
                        '<p>...radosť žiť. Or not.</p>'+
                        '</div>'+
                        '</div>';

                    function setMarkers(map) {
                        var infowindow = new google.maps.InfoWindow({
                            content: infobox
                        });

                        var marker = new google.maps.Marker({
                            position: {lat: 48.15178, lng: 17.07335},
                            map: map,
                            title: 'FEI STU'}
                        );
                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });

                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANj6-p141F6OsVijH-XQQ072cg0QHOcZw&callback=initMap"
                        async defer></script>
            <br><br>
        </div>
        <?php include_once './src/footer.php' ?>
    </body>
</html>
