<?php
include_once './src/Translator.php';
include_once './src/Staff.php';

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
            $staff = new Staff();
            $result = $staff->getdetail($_GET['name'], $_GET['surname']);
            $dept = $staff->getdepartment($result[0]['department']);

            $result[0]['photo'] == null ?
                $photo = 'http://147.175.98.153/semprojtim17/resources/staff_photo/no_photo.jpg' :
                $photo = 'http://147.175.98.153/semprojtim17/resources/staff_photo/' . $result[0]['photo'];

            $name = $result[0]['name'] .' '. $result[0]['surname'];
            $result[0]['title1'] != null ? $name = $result[0]['title1'] . ' ' . $name  : null;
            $result[0]['title2'] != null ? $name = $name . ', ' . $result[0]['title2'] : null;
            $phoneno = "+421260291{$result[0]['phone']}";
            echo "<div class='flex-container'>";
            echo "<div class='aphoto'><img src='{$photo}' class='avatar' /></div>";
            echo "<div class='ainfo'>
                    <p>{$name}<br>
                    {$result[0]['staffRole']}<br>
                    {$dept[0]['full_name']}<br>
                    {$translation->phone} <a href='tel:{$phoneno}'>+421 2 60291 {$result[0]['phone']}</a></br>
                    {$translation->room} {$result[0]['room']}</p>
                 </div>";
            echo "<div><br>";

            $publications = $staff->curlPublications($result[0]['ldapLogin']);
            if (count($publications) > 0) {
                echo '<table id="apersonTable" class="apersonTab">
                        <thead><tr><th class="thesis">
                        <div>Názov práce</div></th>
                        <th class="category"><div>Kategória</div></th>
                        <th class="year"><div>Rok vydania</div></th>
                      </tr></thead><tbody>';

                foreach ($publications as $row) {
                    echo '<tr><td><div><a href="' . $row['href'] . '">' . $row['name'] . '</a></div></td><td><div>'
                            . $row['category'] . '</div></td><td><div>' . $row['year'] . '</div></td></tr>';
                }
                echo '</tbody></table>';
            }
            echo "</div>";
        ?>

        <?php include_once './src/footer.php';?>
    </body>
</html>
