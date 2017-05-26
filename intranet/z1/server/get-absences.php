<?php require __DIR__.'/functions.php' ?>
<?php
    $dbh = connect_to_db();
    $absences = fetchAbsences($dbh);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($absences, JSON_UNESCAPED_UNICODE);
?>
