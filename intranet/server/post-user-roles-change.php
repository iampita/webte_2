<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();
    deleteRoles($dbh, $request[0]->staffId);
    for ($i = 0; $i < count($request); $i++){
        insertRoles($dbh, $request[$i]->staffId, $request[$i]->rolesId);
    }
    $ret = fetchRoles($dbh);
    echo json_encode($ret);
?>
