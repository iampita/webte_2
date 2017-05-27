<?php
include_once './src/Translator.php';
include_once './src/Staff.php';

isset($_SESSION['lang']) ? null : $_SESSION['lang'] = 'sk';

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
        <script>
            var dept = '';
            var role = '';

            function tableFilter(deptselect, no) {
                // Declare variables
                var filter, table, tr, td, i;
                filter = deptselect.value.toUpperCase();
                table = document.getElementById("staffTable");
                tr = table.getElementsByTagName("tr");

                if(no == 3){
                    dept = filter;
                } else {
                    role = filter;
                }

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[3];
                    td2 = tr[i].getElementsByTagName("td")[4];
                    if (td1 && td2) {
                        if (dept == '' && role == ''){
                            tr[i].style.display = "";
                        } else if(dept == '') {
                            if(td2.innerText.toUpperCase().replace(/\s/g, '') == role) tr[i].style.display = "";
                            else tr[i].style.display = "none";
                        } else if(role == '') {
                            if(td1.innerText.toUpperCase().replace(/\s/g, '') == dept) tr[i].style.display = "";
                            else tr[i].style.display = "none";
                        } else if (td1.innerText.toUpperCase().replace(/\s/g, '') == dept
                            && td2.innerText.toUpperCase().replace(/\s/g, '') == role) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>
    </head>
    <body>

        <?php include 'src/header.php';
        isset($_SESSION['lang']) ? $lang = $_SESSION['lang'] : $lang = 'sk';
        if($lang == 'en')
            include_once 'menu/menuEN.php';
        else include 'menu/menu.php';?>

        <div class="atitle"><h1><?php echo $translation->title;?></h1></div>
        <?php
            $staff = new Staff();
            $result = $staff->getAll();

            $deptfilter = [];
            $rolefilter = [];
            foreach($result as $row) {
                if (!in_array($row['department'], $deptfilter, true)) {
                    if (substr($row['department'], -1) != " ") array_push($deptfilter, $row['department']);
                }
                if (!in_array($row['staffRole'], $rolefilter, true)) {
                    array_push($rolefilter, $row['staffRole']);
                }
            }

            echo "<div class='afilter aleft'>
                    {$translation->deptfilter}
                    <select onchange='tableFilter(this, 3);'>
                        <option value=''>{$translation->all}</option>";
            foreach($deptfilter as $entry){
                echo "<option value='{$entry}'>{$entry}</option>";
            }
            echo "</select></div>";
            echo "<div class='afilter aright'>
                    {$translation->rolefilter}
                    <select onchange='tableFilter(this, 4);'>
                        <option value=''>{$translation->all}</option>";
            foreach($rolefilter as $entry){
                echo "<option value='{$entry}'>{$entry}</option>";
            }
            echo "</select></div>";

            echo "<div>
                    <table id='staffTable' class='tablesorter'>
                        <thead>
                            <th class='astaffname'><div>{$translation->name}</div></th>
                            <th class='astaffroom'><div>{$translation->room}</div></th>
                            <th class='astaffphone'><div>{$translation->phone}</div></th>
                            <th class='astaffdep'><div>{$translation->department}</div></th>
                            <th class='astaffrole'><div>{$translation->role}</div></th>
                            <th class='astafffunct'><div>{$translation->function}</div></th>
                        </thead>
                    <tbody>
                  </div>";

            foreach($result as $row)
            {
                $name = $row['surname'] .', '. $row['name'];
                $row['title1'] != null ? $name = $name .', '. $row['title1']  : null;
                $row['title2'] != null ? $name = $name . ' ' . $row['title2'] : null;
                $row['function'] != null ? $funct = $row['function'] : $funct = '-';
                echo "<tr>
                        <td><div>{$name}</div></td>
                        <td><div>{$row['room']}</div></td>
                        <td><div>{$row['phone']}</div></td>
                        <td><div>{$row['department']}</div></td>
                        <td><div>{$row['staffRole']}</div></td>
                        <td><div>{$funct}</div></td>
                        </tr>";
            }
            echo '</tbody></table><br><br>';
        ?>
        <script type="text/javascript">
            $(document).ready(function()
                {
                    $.extend( $.tablesorter.characterEquivalents, {
                        "a" : "\u00e4\u00e1",
                        "c" : "\u010D",
                        "d" : "\u010F",
                        "e" : "\u00E9",
                        "i" : "\u00ED",
                        "l" : "\u013A\u013E",
                        "n" : "\u0148",
                        "o" : "\u00F3\u00F4",
                        "r" : "\u0155",
                        "s" : "\u0161",
                        "t" : "\u0165",
                        "u" : "\u00FA",
                        "y" : "\u00FD",
                        "z" : "\u017E",
                    });

                    $("#staffTable").tablesorter( {
                        sortLocaleCompare : true,
                        headers: {
                            0: {
                                sorter: true
                            },
                            1: {
                                sorter: false
                            },
                            2: {
                                sorter: false
                            },
                            3: {
                                sorter: true
                            },
                            4: {
                                sorter: true
                            },
                            5: {
                                sorter: false
                            }
                        }
                    } );
                }
            );

            $("#staffTable tbody>tr").click(function() {
                var name = this.firstElementChild.firstElementChild.innerText;
                displayDetail(name);
            });

            function displayDetail(name){
                name = name.replace(/\s+/g, '');
                name = name.split(',');
                var url = 'staffDetail.php?name='+name[1]+'&surname='+name[0];
                window.location.href = url;
            }
        </script>
        <?php include_once './src/footer.php';?>
    </body>
</html>
