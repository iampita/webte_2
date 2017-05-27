<?php require __DIR__.'/functions.php' ?>
<?php
    $dbh = connect_to_db();
    $all = fetchEmpAbs($dbh);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($all, JSON_UNESCAPED_UNICODE);
?>
