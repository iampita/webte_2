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
        <?php include 'menu/menu.php';?>
        <h1><?php echo $translations->$site->title->$lang;?></h1>
        <div class="flex-container">
            <div class="kontakt flex-links" id="ustav">
                <?php echo $translations->$site->institute->$lang;?><br>
                <?php echo $translations->$site->faculty->$lang;?><br>
                <?php echo $translations->$site->street->$lang;?><br>
                <?php echo $translations->$site->city->$lang;?><br>
                <?php echo $translations->$site->country->$lang;?><br><br>
                <?php echo $translations->$site->secretariat->$lang;?><br>
                <?php echo $translations->$site->secretary->$lang;?><br>
                <?php echo $translations->$site->room->$lang;?><br>
                <?php echo $translations->$site->phone1->$lang;?><br>
                <?php echo $translations->$site->phone2->$lang;?><br>
                <?php echo $translations->$site->webpage->$lang;?><br>
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
