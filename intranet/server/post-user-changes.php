<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();

    updateStaff($dbh, $request->id, $request->name, $request->surname, $request->title1, $request->title2, $request->ldapLogin, $request->room, $request->phone, $request->department, $request->staffRole, $request->function);
    
    echo json_encode($request);
?>
