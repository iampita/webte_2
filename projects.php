<?php
include_once './src/Translator.php';
include_once './src/Projects.php';

$page = Translator::getSite();
$translation = Translator::translate($page[0], $_GET['lang']);

function cmp($a, $b)
{
    if ($a['yearTo'] == $b['yearTo']) {
        if ($a['monthTo'] == $b['monthTo']) {
            if($a['yearFrom'] == $b['yearFrom']) {
                return 0;
            }
            return ($a['yearFrom'] < $b['yearFrom']) ? 1 : -1;
        }
        return ($a['monthTo'] < $b['monthTo']) ? 1 : -1;
    }
    return ($a['yearTo'] < $b['yearTo']) ? 1 : -1;
}
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
        <h1><?php echo $translation->title;?></h1>

        <?php
            $projects = new Projects();
            $projectTypes = $projects->getAllProjectTypes();

            foreach($projectTypes as $projectType) {
                switch ($projectType['projectType']) {
                    case 'APVV':
                    case 'KEGA':
                    case 'VEGA':
                    case 'Iné domáce projekty':
                        echo "<h2>{$projectType['projectType']}</h2>";
                        break;
                    default:
                        echo "<h2>Medzinárodné projekty</h2>";
                        break;
                }

                echo "<div>
                            <table class='aprojectTable'>
                                <thead>
                                    <th><div>{$translation->projno}</div></th>
                                    <th><div>{$translation->projname}</div></th>
                                    <th><div>{$translation->projtime}</div></th>
                                    <th><div>{$translation->projcoord}</div></th>
                                </thead>
                            <tbody>
                          </div>";

                $result = $projects->getProject($projectType['projectType']);

                foreach ($result as $key => $field) {
                    $pattern = '/^((.*(\d{4}).*\.(\d+).(\d{4}))|(\d{4})|((\d{4})(.*)(\d{4})))$/i';
                    $matches = [];
                    $text_vars = preg_match($pattern, $field['duration'], $matches);
//                    var_dump($text_vars);
//                    var_dump($matches);
                    $result[$key]['yearFrom'] = $matches[count($matches)-3];
                    $result[$key]['monthTo'] = $matches[count($matches)-2];
                    $result[$key]['yearTo'] = $matches[count($matches)-1];
                }

                usort($result, "cmp");

                foreach ($result as $project) {
                    $_SESSION['lang'] == 'en' ?
                        $title = $project['titleEN'] :
                        $title = $project['titleSK'];

                    echo "<tr>
                            <td><div id='{$project['id']}'>{$project['number']}</div></td>
                            <td><div>{$title}</div></td>
                            <td><div>{$project['duration']}</div></td>
                            <td><div>{$project['coordinator']}</div></td>
                          </tr>";
                }
                echo '</tbody></table><br>';
            }
        ?>
        <script>
            $(".aprojectTable tbody>tr").click(function() {
                var id = parseInt(this.firstElementChild.firstElementChild.getAttribute('id'));
                displayDetail(id);
            });

            function displayDetail(id){
                var url = 'projectDetail.php?id='+id;
                window.location.href = url;
            }
        </script>
        <?php include_once './src/footer.php';?>
    </body>
</html>