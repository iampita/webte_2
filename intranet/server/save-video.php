<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();

    saveVideo($dbh, $request->title, $request->url, $request->type);
    
    echo json_encode($request);
?>
