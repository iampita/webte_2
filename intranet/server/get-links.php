<?php require __DIR__.'/functions.php' ?>
<?php
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $dbh = connect_to_db();
    $links = fetchLinks($dbh, $request->pageName);
    echo json_encode($links);
?>
