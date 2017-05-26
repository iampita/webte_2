<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();
    $staff = fetchAllStaff($dbh);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($staff, JSON_UNESCAPED_UNICODE); 
?>
