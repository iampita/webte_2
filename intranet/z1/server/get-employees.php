<?php require __DIR__.'/functions.php' ?>
<?php
    $dbh = connect_to_db();
    $employees = fetchEmployees($dbh);

    function cmp($a, $b){
        return strcmp($a['surname'], $b['surname']);
    }
    usort($employees, "cmp");

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($employees, JSON_UNESCAPED_UNICODE);
?>
