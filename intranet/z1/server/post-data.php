<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();

    deleteOldMonth($dbh, $request[count($request) - 1]->from, $request[count($request) - 1]->to);

    for($i = 0; $i < count($request) - 1; $i++){
        createEmpAbsRecord($dbh, $request[$i]->employee_id, $request[$i]->absence_id, $request[$i]->dateAtr);
    }
?>
